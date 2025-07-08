<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\BonusPointThreshold;
use App\Models\UserAwardedBonus;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use App\Notifications\BadgeAchieved;
use App\Notifications\WeeklyBonusPointsAwarded;
use Carbon\Carbon;

class AwardBonusPoints extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'award:bonus-points';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Awards bonus points to users based on their point thresholds.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Starting bonus point award process...');

        $users = User::where('role_id', 3)->get(); // Assuming role_id 3 is for respondents
        // Order by min_points DESC to prioritize higher tiers
        $bonusThresholds = BonusPointThreshold::orderByDesc('min_points')->get();

        foreach ($users as $user) {
            $this->info("Processing user: {$user->email} (Points: {$user->points})");

            $originalBadgeName = $user->badge ? $user->badge['name'] : null; // Get current badge name before point update

            foreach ($bonusThresholds as $threshold) {
                // Check if user's points meet the threshold criteria
                $meetsMin = $user->points >= $threshold->min_points;
                $meetsMax = ($threshold->max_points === null || $user->points <= $threshold->max_points);

                if ($meetsMin && $meetsMax) {
                    // User qualifies for this threshold. Now check if they already received it this week.
                    $awardedRecord = UserAwardedBonus::where('user_id', $user->id)
                                                    ->where('bonus_point_threshold_id', $threshold->id)
                                                    ->first();

                    $startOfWeek = Carbon::now()->startOfWeek();

                    // If no record exists, or the last award for this threshold was before the current week
                    if (!$awardedRecord || ($awardedRecord && $awardedRecord->awarded_at->lt($startOfWeek))) {
                        DB::transaction(function () use ($user, $threshold, $awardedRecord) {
                            // Award bonus points
                            $user->points += $threshold->bonus_amount;
                            $user->available_points += $threshold->bonus_amount;
                            $user->save();

                            // Send weekly bonus awarded notification
                            $user->notify(new WeeklyBonusPointsAwarded($threshold->bonus_amount));

                            if ($awardedRecord) {
                                // Update existing record
                                $awardedRecord->update(['awarded_at' => now()]);
                            } else {
                                // Create new record
                                UserAwardedBonus::create([
                                    'user_id' => $user->id,
                                    'bonus_point_threshold_id' => $threshold->id,
                                    'awarded_at' => now(),
                                ]);
                            }

                            $this->info("Awarded {$threshold->bonus_amount} points to {$user->email} for reaching \"{$threshold->name}\".");
                        });
                        break; // Stop checking lower tiers for this user, as they got the highest eligible bonus
                    } else {
                        $this->info("User {$user->email} already awarded \"{$threshold->name}\" this week. Skipping.");
                        break; // Stop checking lower tiers for this user
                    }
                }
            }

            // Check for badge achievement after all bonus points for the week are processed
            $newBadge = $user->badge; // Re-evaluate badge after points might have changed
            if ($newBadge && $newBadge['name'] !== $originalBadgeName) {
                $user->notify(new BadgeAchieved($newBadge['name']));
            }
        }

        $this->info('Bonus point award process completed.');

        return Command::SUCCESS;
    }
}