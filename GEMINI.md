# Aturan Pengembangan Gemini untuk Proyek Laravel Surveyasia-Skripsi

File ini mendefinisikan aturan pengembangan yang harus dipatuhi oleh Gemini CLI ketika membantu menulis kode pada proyek Laravel bernama `Surveyasia-Skripsi`.

## 📌 Nama Proyek
Surveyasia-Skripsi

## ⚙️ Framework & Teknologi
- Laravel 10+
- PHP 8.1+
- MySQL
- Blade (opsional: Vue.js atau Alpine.js)

---

## ✅ ATURAN PENGKODINGAN

Gemini harus mengikuti aturan berikut:

### 1. Pengembangan Fitur
- Tulis kode PHP yang bersih, dapat dipelihara, dan sesuai standar PSR-12.
- Ikuti praktik terbaik Laravel:
  - Gunakan Controller, Model, Request, Migration, Policy, dan Resource secara tepat.
  - Gunakan `artisan` command untuk membuat struktur kode (misalnya `make:controller`, `make:model`).
  - Gunakan **Dependency Injection** dan **Route Model Binding** jika memungkinkan.
  - Tambahkan validasi menggunakan `FormRequest` untuk input dari pengguna.

### 2. Dokumentasi (`DOCUMENTATION.md`)
Setiap fitur baru yang dikembangkan **wajib didokumentasikan** secara rinci ke dalam file `DOCUMENTATION.md` pada direktori root proyek.

> **Seluruh dokumentasi dan komentar di dalam kode harus ditulis menggunakan Bahasa Indonesia yang baik dan jelas.**

Format dokumentasi:

```markdown
## [Judul Fitur]

**Tanggal:** YYYY-MM-DD  
**Penulis:** Gemini

### Deskripsi
Penjelasan singkat mengenai apa yang dilakukan oleh fitur ini dan mengapa fitur ini ditambahkan.

### File yang Dibuat / Diubah
- `app/Http/Controllers/...`
- `resources/views/...`
- `routes/web.php`
- dst.

### Catatan Teknis
- Jelaskan logika utama dan keputusan teknis (misalnya penggunaan relasi Eloquent, middleware, helper khusus, dsb.).
- Jika menggunakan package pihak ketiga, jelaskan alasan dan cara penggunaannya.

### Cara Penggunaan
Jelaskan bagaimana cara menggunakan atau menguji fitur ini (URL, hak akses, perintah artisan, dsb).
