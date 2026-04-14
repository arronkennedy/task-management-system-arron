<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Task;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        /*
        |--------------------------------------------------------------------------
        | CATEGORY DATA
        |--------------------------------------------------------------------------
        */

        $pekerjaan = Category::create([
            'name' => 'Pekerjaan',
            'color' => '#3B82F6',
            'description' => 'Tugas kantor dan kerja',
        ]);

        $pribadi = Category::create([
            'name' => 'Pribadi',
            'color' => '#10B981',
            'description' => 'Kegiatan harian pribadi',
        ]);

        $kuliah = Category::create([
            'name' => 'Kuliah',
            'color' => '#8B5CF6',
            'description' => 'Belajar dan tugas kampus',
        ]);

        $kesehatan = Category::create([
            'name' => 'Kesehatan',
            'color' => '#EF4444',
            'description' => 'Olahraga dan kesehatan',
        ]);

        $keuangan = Category::create([
            'name' => 'Keuangan',
            'color' => '#F59E0B',
            'description' => 'Uang dan pembayaran',
        ]);

        /*
        |--------------------------------------------------------------------------
        | TASK DATA
        |--------------------------------------------------------------------------
        */

        Task::create([
            'title' => 'Selesaikan laporan bulanan',
            'description' => 'Menyusun laporan akhir bulan',
            'status' => 'pending',
            'priority' => 'high',
            'category_id' => $pekerjaan->id,
            'due_date' => '2026-04-18',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Balas email klien',
            'description' => 'Menjawab email penting',
            'status' => 'in_progress',
            'priority' => 'medium',
            'category_id' => $pekerjaan->id,
            'due_date' => '2026-04-15',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Siapkan slide meeting',
            'description' => 'Presentasi rapat tim',
            'status' => 'completed',
            'priority' => 'high',
            'category_id' => $pekerjaan->id,
            'due_date' => '2026-04-13',
            'completed_at' => now(),
        ]);

        Task::create([
            'title' => 'Update rencana proyek',
            'description' => 'Revisi timeline kerja',
            'status' => 'cancelled',
            'priority' => 'low',
            'category_id' => $pekerjaan->id,
            'due_date' => '2026-04-20',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Belanja kebutuhan rumah',
            'description' => 'Beli kebutuhan mingguan',
            'status' => 'pending',
            'priority' => 'medium',
            'category_id' => $pribadi->id,
            'due_date' => '2026-04-16',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Bersihkan kamar',
            'description' => 'Rapikan kamar tidur',
            'status' => 'completed',
            'priority' => 'low',
            'category_id' => $pribadi->id,
            'due_date' => '2026-04-14',
            'completed_at' => now(),
        ]);

        Task::create([
            'title' => 'Perpanjang SIM',
            'description' => 'Datang ke kantor samsat',
            'status' => 'in_progress',
            'priority' => 'high',
            'category_id' => $pribadi->id,
            'due_date' => '2026-04-25',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Hubungi keluarga',
            'description' => 'Telepon orang tua',
            'status' => 'cancelled',
            'priority' => 'low',
            'category_id' => $pribadi->id,
            'due_date' => '2026-04-17',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Kumpul tugas testing',
            'description' => 'Upload final project',
            'status' => 'pending',
            'priority' => 'critical',
            'category_id' => $kuliah->id,
            'due_date' => '2026-04-19',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Belajar Laravel',
            'description' => 'Pelajari routing dan blade',
            'status' => 'in_progress',
            'priority' => 'medium',
            'category_id' => $kuliah->id,
            'due_date' => '2026-04-15',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Latihan PHPUnit',
            'description' => 'Membuat unit test',
            'status' => 'completed',
            'priority' => 'high',
            'category_id' => $kuliah->id,
            'due_date' => '2026-04-12',
            'completed_at' => now(),
        ]);

        Task::create([
            'title' => 'Baca materi database',
            'description' => 'Review relasi tabel',
            'status' => 'pending',
            'priority' => 'low',
            'category_id' => $kuliah->id,
            'due_date' => '2026-04-22',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Jogging pagi',
            'description' => 'Lari 30 menit',
            'status' => 'pending',
            'priority' => 'medium',
            'category_id' => $kesehatan->id,
            'due_date' => '2026-04-15',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Pesan dokter gigi',
            'description' => 'Booking pemeriksaan',
            'status' => 'in_progress',
            'priority' => 'high',
            'category_id' => $kesehatan->id,
            'due_date' => '2026-04-21',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Minum 2 liter air',
            'description' => 'Target hidrasi harian',
            'status' => 'completed',
            'priority' => 'low',
            'category_id' => $kesehatan->id,
            'due_date' => '2026-04-14',
            'completed_at' => now(),
        ]);

        Task::create([
            'title' => 'Beli vitamin',
            'description' => 'Stok vitamin habis',
            'status' => 'cancelled',
            'priority' => 'low',
            'category_id' => $kesehatan->id,
            'due_date' => '2026-04-18',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Bayar listrik',
            'description' => 'Tagihan bulan ini',
            'status' => 'pending',
            'priority' => 'critical',
            'category_id' => $keuangan->id,
            'due_date' => '2026-04-16',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Review budget bulanan',
            'description' => 'Cek pengeluaran',
            'status' => 'in_progress',
            'priority' => 'medium',
            'category_id' => $keuangan->id,
            'due_date' => '2026-04-20',
            'completed_at' => null,
        ]);

        Task::create([
            'title' => 'Transfer tabungan',
            'description' => 'Sisihkan dana bulanan',
            'status' => 'completed',
            'priority' => 'high',
            'category_id' => $keuangan->id,
            'due_date' => '2026-04-13',
            'completed_at' => now(),
        ]);

        Task::create([
            'title' => 'Batalkan langganan aplikasi',
            'description' => 'Aplikasi tidak dipakai',
            'status' => 'cancelled',
            'priority' => 'low',
            'category_id' => $keuangan->id,
            'due_date' => '2026-04-23',
            'completed_at' => null,
        ]);
    }
}