<?php

namespace Database\Seeders;

use App\Models\Leader;
use Illuminate\Database\Seeder;

class LeaderSeeder extends Seeder
{
    public function run(): void
    {
        $base = rtrim(config('app.url'), '/');

        $leaders = [
            [
                'sort_order'   => 1,
                'slug'         => 'muhitdinov',
                'name'         => "Мухитдинов\nАнвар Омонуллаевич",
                'role'         => 'Председатель АУГЗ',
                'photo'        => "{$base}/storage/leaders/muhitdinov.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ raisi'],
                    'en' => ['role' => 'Chairman of AUGZ'],
                ],
            ],
            [
                'sort_order'   => 2,
                'slug'         => 'abidov',
                'name'         => "Абидов\nМарат Шавкатович",
                'role'         => 'Заместитель председателя АУГЗ',
                'photo'        => "{$base}/storage/leaders/abidov.jpg",
                'translations' => [
                    'uz' => ['role' => "AUGZ rais o'rinbosari"],
                    'en' => ['role' => 'Deputy Chairman of AUGZ'],
                ],
            ],
            [
                'sort_order'   => 3,
                'slug'         => 'niyazov',
                'name'         => "Ниязов\nКамол Дильшодович",
                'role'         => 'Директор по стратегическому развитию',
                'photo'        => "{$base}/storage/leaders/niyazov.jpg",
                'translations' => [
                    'uz' => ['role' => 'Strategik rivojlanish direktori'],
                    'en' => ['role' => 'Director of Strategic Development'],
                ],
            ],
            [
                'sort_order'   => 4,
                'slug'         => 'irmatova',
                'name'         => "Ирматова\nНигора Абдувайитовна",
                'role'         => 'Помощник председателя АУГЗ',
                'photo'        => "{$base}/storage/leaders/irmatova.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ raisi yordamchisi'],
                    'en' => ['role' => 'Assistant to the Chairman'],
                ],
            ],
            [
                'sort_order'   => 5,
                'slug'         => 'hodjaev',
                'name'         => "Ходжаев\nФейруз Баходирович",
                'role'         => 'Эксперт АУГЗ',
                'photo'        => "{$base}/storage/leaders/hodjaev.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ eksperti'],
                    'en' => ['role' => 'AUGZ Expert'],
                ],
            ],
            [
                'sort_order'   => 6,
                'slug'         => 'muratov',
                'name'         => "Муратов\nОдилжон",
                'role'         => 'Эксперт АУГЗ',
                'photo'        => "{$base}/storage/leaders/muratov.jpg",
                'translations' => [
                    'uz' => ['role' => 'AUGZ eksperti'],
                    'en' => ['role' => 'AUGZ Expert'],
                ],
            ],
        ];

        foreach ($leaders as $data) {
            Leader::updateOrCreate(['slug' => $data['slug']], $data);
        }
    }
}
