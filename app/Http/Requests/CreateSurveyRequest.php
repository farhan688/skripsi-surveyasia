<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateSurveyRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'user_id' => ['required'],
            'estimate_completion' => ['required'],
            'category_id' => ['required'],
            'reward_point' => ['required', 'integer', 'min:0'],
            'max_attempt' => ['required', 'integer', 'min:1']
        ];
    }

    public function messages()
    {
        return [
            'title.required' => 'Judul survei wajib diisi.',
            'description.required' => 'Deskripsi survei wajib diisi.',
            'user_id.required' => 'ID pengguna wajib diisi.',
            'estimate_completion.required' => 'Estimasi penyelesaian wajib diisi.',
            'category_id.required' => 'Kategori wajib diisi.',
            'reward_point.required' => 'Jumlah reward wajib diisi.',
            'reward_point.integer' => 'Jumlah reward harus berupa angka.',
            'reward_point.min' => 'Jumlah reward tidak boleh kurang dari 0.',
            'max_attempt.required' => 'Maksimum responden wajib diisi.',
            'max_attempt.integer' => 'Maksimum responden harus berupa angka.',
            'max_attempt.min' => 'Maksimum responden tidak boleh kurang dari 1.',
        ];
    }
}
