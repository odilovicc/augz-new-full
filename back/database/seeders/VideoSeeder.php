<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $videos = [
            [
                'title'      => 'АУГЗ — прямой эфир',
                'thumbnail'  => 'https://img.youtube.com/vi/P7anojTbgbM/maxresdefault.jpg',
                'url'        => 'https://www.youtube.com/embed/P7anojTbgbM?autoplay=1&rel=0',
                'badge'      => 'Прямой эфир',
                'duration'   => null,
                'sort_order' => 1,
            ],
            [
                'title'      => 'Видео материалы АУГЗ',
                'thumbnail'  => 'https://img.youtube.com/vi/_CXr-wN_T6s/maxresdefault.jpg',
                'url'        => 'https://www.youtube.com/embed/_CXr-wN_T6s?autoplay=1&rel=0',
                'badge'      => null,
                'duration'   => null,
                'sort_order' => 2,
            ],
            [
                'title'      => 'Видео материалы АУГЗ',
                'thumbnail'  => 'https://img.youtube.com/vi/bYc49qFS2-Y/maxresdefault.jpg',
                'url'        => 'https://www.youtube.com/embed/bYc49qFS2-Y?autoplay=1&rel=0',
                'badge'      => null,
                'duration'   => null,
                'sort_order' => 3,
            ],
            [
                'title'      => 'Видео материалы АУГЗ',
                'thumbnail'  => 'https://img.youtube.com/vi/uL9Ej5yIrRo/maxresdefault.jpg',
                'url'        => 'https://www.youtube.com/embed/uL9Ej5yIrRo?autoplay=1&rel=0',
                'badge'      => null,
                'duration'   => null,
                'sort_order' => 4,
            ],
        ];

        foreach ($videos as $video) {
            Video::create($video);
        }
    }
}
