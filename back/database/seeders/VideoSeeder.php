<?php

namespace Database\Seeders;

use App\Models\Video;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;

class VideoSeeder extends Seeder
{
    public function run(): void
    {
        $entries = [
            ['id' => 'P7anojTbgbM', 'badge' => 'Прямой эфир', 'sort_order' => 1],
            ['id' => '_CXr-wN_T6s', 'badge' => null,           'sort_order' => 2],
            ['id' => 'bYc49qFS2-Y', 'badge' => null,           'sort_order' => 3],
            ['id' => 'uL9Ej5yIrRo', 'badge' => null,           'sort_order' => 4],
        ];

        foreach ($entries as $entry) {
            $youtubeId = $entry['id'];
            $watchUrl  = "https://www.youtube.com/watch?v={$youtubeId}";

            $title = $this->fetchTitle($watchUrl) ?? 'Видео АУГЗ';

            Video::create([
                'title'      => $title,
                'thumbnail'  => "https://img.youtube.com/vi/{$youtubeId}/maxresdefault.jpg",
                'url'        => "https://www.youtube.com/embed/{$youtubeId}?autoplay=1&rel=0",
                'badge'      => $entry['badge'],
                'duration'   => null,
                'sort_order' => $entry['sort_order'],
            ]);
        }
    }

    private function fetchTitle(string $url): ?string
    {
        try {
            $response = Http::timeout(5)->get('https://www.youtube.com/oembed', [
                'url'    => $url,
                'format' => 'json',
            ]);

            return $response->ok() ? ($response->json('title') ?? null) : null;
        } catch (\Throwable) {
            return null;
        }
    }
}
