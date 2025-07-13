# 📚 Dokumentasi Fitur Surveyasia-Skripsi

Dokumen ini berisi dokumentasi lengkap atas setiap fitur yang dikembangkan dalam proyek Laravel **Surveyasia-Skripsi**.  
Setiap entri mencakup deskripsi, struktur file yang terlibat, catatan teknis, serta panduan penggunaan.  
Seluruh informasi ditulis dalam Bahasa Indonesia.

---

## Fitur: [Judul Fitur]

**Tanggal:** YYYY-MM-DD  
**Penulis:** Gemini

### Deskripsi  
[Tuliskan penjelasan singkat mengenai tujuan dan fungsi dari fitur ini.]

### File yang Dibuat / Diubah
- `app/...`
- `routes/...`
- `resources/views/...`
- `database/migrations/...`

### Catatan Teknis
- [Penjelasan teknis mengenai implementasi, logika khusus, dependensi, relasi, dsb.]
- [Jika ada package pihak ketiga, sebutkan dan jelaskan penggunaannya.]

### Cara Penggunaan
- [Langkah-langkah untuk mengakses atau menguji fitur ini.]
- [URL endpoint, hak akses pengguna, form yang harus diisi, dll.]

---

## Fitur: Penyimpanan Logo Survei di Database

**Tanggal:** 2025-07-11  
**Penulis:** Gemini

### Deskripsi

Mengubah fungsionalitas unggah logo survei agar gambar disimpan di dalam database sebagai data Base64, bukan sebagai file di direktori `public/assets/img`.

### File yang Dibuat / Diubah

- `app/Http/Controllers/Survey/SurveyController.php`
- `database/migrations/2022_06_24_130755_insert_background_logo_into_surveys_table.php`
- `database/migrations/2025_07_11_214705_change_logo_column_type_in_surveys_table.php`
- `resources/views/researcher/layouts/sidebar.blade.php`

### Catatan Teknis

- Mengubah tipe data kolom `logo` pada tabel `surveys` dari `string` menjadi `longText` untuk menampung data gambar dalam format Base64.
- Memodifikasi metode `updateLogo` di `SurveyController` untuk mengonversi gambar yang diunggah menjadi Base64 sebelum menyimpannya ke database.
- Menyesuaikan tampilan di `sidebar.blade.php` untuk menampilkan gambar dari data Base64 yang tersimpan di database.

### Cara Penggunaan

1. Buka halaman manajemen survei.
2. Klik pada bagian logo untuk membuka modal unggah logo.
3. Pilih gambar logo yang ingin diunggah.
4. Klik tombol "Terapkan".
5. Logo akan tersimpan di database dan ditampilkan di halaman manajemen survei.

---

> 📝 Tambahkan dokumentasi baru di bawah ini setiap kali fitur baru dibuat.

---



---

## Perbaikan: ParseError di SurveyCompleted Notification

**Tanggal:** 2025-07-09  
**Penulis:** Gemini

### Deskripsi

Memperbaiki `ParseError: syntax error, unexpected identifier "otifications", expecting "{"` yang terjadi pada file `app/Notifications/SurveyCompleted.php`. Kesalahan ini disebabkan oleh kesalahan ketik pada deklarasi namespace.

### File yang Dibuat / Diubah

- `app/Notifications/SurveyCompleted.php`

### Catatan Teknis

Kesalahan terjadi pada baris `namespace App\notifications;` di mana "notifications" seharusnya diawali dengan huruf kapital "N" (`Notifications`). Perbaikan dilakukan dengan mengubah `notifications` menjadi `Notifications` agar sesuai dengan standar penamaan namespace PHP dan Laravel.

### Cara Penggunaan

Tidak ada langkah penggunaan khusus. Perbaikan ini bersifat korektif dan memastikan aplikasi dapat berjalan tanpa `ParseError` tersebut saat memproses notifikasi penyelesaian survei.
