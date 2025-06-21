# FinTrack - Personal Budget Tracker

*A full-stack web application designed to help users manage their personal finances with insightful AI-powered analysis.*

---

## 📖 Tentang Proyek

FinTrack adalah aplikasi web modern yang memungkinkan pengguna untuk mencatat pemasukan dan pengeluaran, mengkategorikan transaksi, dan memvisualisasikan kondisi keuangan mereka melalui dashboard interaktif. Proyek ini dibangun sebagai *Capstone Project* untuk kursus IBM, dengan fokus pada pengembangan aplikasi web fungsional penuh dan pemanfaatan AI untuk memberikan analisis data yang personal.

> **Repositori Backend (Laravel API):** Repositori ini berisi kode untuk sisi **Backend** aplikasi. Dibangun dengan framework Laravel, tugas utamanya adalah menyediakan REST API yang aman dan robust untuk di-consume oleh aplikasi Frontend. Ini mencakup logika untuk autentikasi pengguna, operasi CRUD (Create, Read, Update, Delete) data, dan kalkulasi data untuk laporan.

---

## 🚀 Dibangun Dengan

* **Backend:** Laravel 12, PHP 8.2, MySQL
* **API:** RESTful API, Laravel Sanctum (Token-based Authentication)
* **Deployment:** Vercel

---

## ⚙️ Getting Started

Berikut adalah langkah-langkah untuk menjalankan proyek ini di lingkungan lokal.

### Pre-requisite

Pastikan kamu sudah menginstal perangkat lunak berikut:
- (Untuk Backend) PHP 8.2 atau lebih baru
- (Untuk Backend) Composer
- (Untuk Backend) MySQL atau database sejenis

### Instalasi

**Untuk Backend (Laravel):**
1. Clone repository ini:
   ```sh
   git clone [https://github.com/namamu/backend-fintrack.git](https://github.com/namamu/backend-fintrack.git)
   
2. Masuk ke direktori proyek:
   ```sh
   cd backend-fintrack
   
3. Install dependensi Composer:
   ```sh
   composer install
   
4. Salin file .env.example menjadi .env:
   ```sh
   cp .env.example .env
   
5. Generate application key:
   ```sh
   php artisan key:generate
   
6. Konfigurasi koneksi database-mu di dalam file .env.

7. Jalankan migrasi untuk membuat tabel di database:
   ```sh
   php artisan migrate

8. Jalankan server development
   ```sh
   php artisan serve

10. Server akan berjalan di http://127.0.0.1:8000


### Tips Tambahan

1.  **Ganti Placeholder:** Jangan lupa ganti `link_ke_screenshot...` dan `https://github.com/namamu/...` dengan link yang sebenarnya.
2.  **Screenshot/GIF itu Wajib:** Satu tips pro terakhir: tambahkan screenshot atau GIF singkat aplikasi yang sedang berjalan di bagian paling atas (di bawah judul). Ini dampaknya **luar biasa** untuk menarik perhatian dan membuat repo-mu kelihatan "hidup". Kamu bisa rekam layar pakai aplikasi seperti ScreenToGif (Windows) atau Kap (Mac).

Dengan `README.md` seperti ini, proyekmu akan terlihat sangat profesional dan terstruktur dengan baik. Mantap!
    
