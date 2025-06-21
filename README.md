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

## 🔌 Endpoint API

Berikut adalah endpoint utama yang disediakan oleh API ini. Semua endpoint (kecuali `/register` dan `/login`) memerlukan Bearer Token untuk autentikasi.

| Method | Endpoint | Deskripsi | Wajib Auth |
| :--- | :--- | :--- | :---: |
| <img src="https://img.shields.io/badge/POST-4A90E2?style=for-the-badge" alt="POST"/> | `/api/register` | Registrasi user baru. | ❌ |
| <img src="https://img.shields.io/badge/POST-4A90E2?style=for-the-badge" alt="POST"/> | `/api/login` | Login user & mendapatkan token. | ❌ |
| <img src="https://img.shields.io/badge/POST-4A90E2?style=for-the-badge" alt="POST"/> | `/api/logout` | Logout user & menghapus token. | ✅ |
| <img src="https://img.shields.io/badge/GET-20C997?style=for-the-badge" alt="GET"/> | `/api/user` | Mengambil data user yang sedang login. | ✅ |
| | | | |
| <img src="https://img.shields.io/badge/GET-20C997?style=for-the-badge" alt="GET"/> | `/api/categories` | Mengambil semua kategori milik user. | ✅ |
| <img src="https://img.shields.io/badge/POST-4A90E2?style=for-the-badge" alt="POST"/> | `/api/categories` | Membuat kategori baru. | ✅ |
| <img src="https://img.shields.io/badge/PUT-F5A623?style=for-the-badge" alt="PUT"/> | `/api/categories/{id}` | Mengupdate kategori. | ✅ |
| <img src="https://img.shields.io/badge/DELETE-D0021B?style=for-the-badge" alt="DELETE"/> | `/api/categories/{id}` | Menghapus kategori. | ✅ |
| | | | |
| <img src="https://img.shields.io/badge/GET-20C997?style=for-the-badge" alt="GET"/> | `/api/transactions` | Mengambil daftar transaksi (dengan paginasi). | ✅ |
| <img src="https://img.shields.io/badge/POST-4A90E2?style=for-the-badge" alt="POST"/> | `/api/transactions` | Membuat transaksi baru. | ✅ |
| <img src="https://img.shields.io/badge/PUT-F5A623?style=for-the-badge" alt="PUT"/> | `/api/transactions/{id}` | Mengupdate transaksi. | ✅ |
| <img src="https://img.shields.io/badge/DELETE-D0021B?style=for-the-badge" alt="DELETE"/> | `/api/transactions/{id}` | Menghapus transaksi. | ✅ |
| | | | |
| <img src="https://img.shields.io/badge/GET-20C997?style=for-the-badge" alt="GET"/> | `/api/dashboard/summary` | Mengambil data ringkasan untuk kartu dashboard. | ✅ |
| <img src="https://img.shields.io/badge/GET-20C997?style=for-the-badge" alt="GET"/> | `/api/reports/spending-by-category` | Mengambil data agregat untuk pie chart. | ✅ |
| <img src="https://img.shields.io/badge/GET-20C997?style=for-the-badge" alt="GET"/> | `/api/reports/income-expense-trend` | Mengambil data tren untuk bar chart. | ✅ |


### Tips Tambahan

1.  **Ganti Placeholder:** Jangan lupa ganti `link_ke_screenshot...` dan `https://github.com/namamu/...` dengan link yang sebenarnya.
2.  **Screenshot/GIF itu Wajib:** Satu tips pro terakhir: tambahkan screenshot atau GIF singkat aplikasi yang sedang berjalan di bagian paling atas (di bawah judul). Ini dampaknya **luar biasa** untuk menarik perhatian dan membuat repo-mu kelihatan "hidup". Kamu bisa rekam layar pakai aplikasi seperti ScreenToGif (Windows) atau Kap (Mac).

Dengan `README.md` seperti ini, proyekmu akan terlihat sangat profesional dan terstruktur dengan baik. Mantap!
    
