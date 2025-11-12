<?php

namespace Database\Factories;

use App\Models\Unit;
use App\Models\User;
use App\Models\KategoriPengaduan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengaduan>
 */
class PengaduanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $unitId = Unit::query()->inRandomOrder()->value('id')
                 ?? Unit::factory()->create()->id;

        $kategoriId = KategoriPengaduan::query()->inRandomOrder()->value('id')
                     ?? KategoriPengaduan::factory()->create()->id;

        // pastikan ada 2 user
        // $pelaporId = User::query()->inRandomOrder()->value('id')       ?? User::factory()->create()->id;

        // $petugasId = User::query()->whereKeyNot($pelaporId)->inRandomOrder()->value('id')    ?? User::factory()->create()->id;

        return [
            'no_tiket' => strtoupper('IMG-JBR-' . fake()->unique()->numerify('#####')),
            'unit_id' => $unitId,
            'kategori_id' => $kategoriId,
            // 'pelapor_id' => $pelaporId,
            // 'petugas_id' => $petugasId,
            'judul' => fake()->sentence(4),
            'deskripsi' => fake()->paragraph(),
            'prioritas' => fake()->randomElement(['rendah','sedang','tinggi','kritikal']),
            'status' => fake()->randomElement(['menunggu','proses','selesai','ditolak']),
            'sla_late' => fake()->boolean(20),
            'tanggal_selesai' => fake()->optional()->dateTime(),
        ];
    }
}
