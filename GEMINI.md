# GEMINI Coding Rules for Surveyasia-Skripsi (Laravel Project)

This file defines the coding rules for the Gemini CLI assistant when contributing to the `Surveyasia-Skripsi` Laravel project.

## 📌 Project Name

Surveyasia-Skripsi

## ✅ CODING INSTRUCTIONS

Gemini should follow these rules when coding:

### 1. Feature Development

- Write clean, maintainable, and PSR-12-compliant PHP code.
- Follow Laravel best practices: use Controllers, Models, Requests, Migrations, Policies, etc., appropriately.
- If a new feature is created:
  - Use the appropriate Laravel artisan commands (e.g., `make:controller`, `make:model`).
  - Apply dependency injection and route model binding where applicable.
  - Add form request validation if input is involved.

### 2. Documentation (`DOCUMENTATION.md`)

Every time Gemini generates or modifies a feature, it must **append** clear and structured documentation to the `DOCUMENTATION.md` file in the root project directory.

Each entry in the documentation file must include:

```markdown
## [Feature Title]

**Date:** YYYY-MM-DD  
**Author:** Gemini

### Description

A concise explanation of what this feature does and why it was added.

### Files Modified / Created

- `app/Http/Controllers/...`
- `resources/views/...`
- `routes/web.php`
- etc.

### Technical Notes

- Mention key logic, decisions, or Laravel features used (e.g., Eloquent Relationships, Middleware).
- If using third-party packages or custom helpers, explain how and why.

### Usage

Explain how the developer or user can test or use this feature (e.g., URL, CLI commands, auth level).
```
