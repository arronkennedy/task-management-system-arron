# Task Management System

![CI Status](https://github.com/arronkennedy/task-management-system/actions/workflows/ci.yml/badge.svg)
[![codecov](https://codecov.io/gh/arronkennedy/task-management-system/graph/badge.svg)](https://codecov.io/gh/arronkennedy/task-management-system)

Aplikasi manajemen tugas berbasis web yang dibangun dengan **Laravel 11**, dilengkapi
automated testing menggunakan **PHPUnit** dan **GitHub Actions CI**.

## Fitur Utama
- Task CRUD dengan filter status, prioritas, dan kategori
- Kategori task dengan kode warna
- Dashboard statistik & completion rate
- Deteksi task overdue

## Cara Menjalankan Aplikasi

```bash
git clone https://github.com/arronkennedy/task-management-system.git
cd task-management-system

composer install
cp .env.example .env
php artisan key:generate

# Buat database & jalankan migrasi
php artisan migrate --seed

php artisan serve        # buka http://localhost:8000
```

## Cara Menjalankan Test

```bash
# Jalankan semua test
php artisan test

# Jalankan dengan laporan coverage
php artisan test --coverage

# Jalankan test tertentu
php artisan test --filter=TaskServiceTest
```

## Strategi Pengujian

| Layer | Tool | Jumlah |
|---|---|---|
| Unit Tests | PHPUnit | 22 test case |
| Integration / Feature Tests | PHPUnit + Laravel TestCase | 13 test case |

**Unit Tests** menguji logika bisnis secara terisolasi: `TaskService`, `CategoryService`,
dan method pada model `Task` (isOverdue, isCompleted, priorityLevel, dsb.).

**Integration Tests** menguji endpoint HTTP penuh termasuk validasi form, redirect,
interaksi database, dan error handling.

**Database Testing** menggunakan SQLite `:memory:` agar cepat dan terisolasi.

## Coverage Target
Minimal 60% — diukur menggunakan Xdebug + laporan Clover/HTML.

## Pipeline CI (GitHub Actions)
Dijalankan otomatis saat `push` dan `pull_request`:
1. Setup PHP (8.2 & 8.3)
2. Install Composer dependencies
3. Generate APP_KEY
4. Jalankan seluruh test + generate coverage report
5. Upload artifact coverage HTML
6. Upload ke Codecov

## Struktur Project
```
app/
├── Http/Controllers/     # DashboardController, TaskController, CategoryController
├── Http/Requests/        # Form validation (StoreTaskRequest, dll)
├── Models/               # Task, Category
└── Services/             # TaskService, CategoryService (business logic)
database/
├── factories/            # TaskFactory, CategoryFactory
├── migrations/           # Skema database
└── seeders/              # DatabaseSeeder
tests/
├── Unit/                 # TaskServiceTest, TaskModelTest, CategoryServiceTest
└── Feature/              # TaskControllerTest, CategoryControllerTest
.github/workflows/ci.yml  # GitHub Actions pipeline
```