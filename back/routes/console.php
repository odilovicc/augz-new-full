<?php

use App\Models\Video;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Http;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('videos:sync-titles', function () {
    $videos = Video::all();
    $updated = 0;

    foreach ($videos as $video) {
        // Extract YouTube ID from embed URL or any YouTube URL
        if (preg_match('#(?:v=|/embed/|/shorts/|youtu\.be/)([a-zA-Z0-9_-]{11})#', $video->url, $m)) {
            $youtubeId = $m[1];
            $watchUrl  = "https://www.youtube.com/watch?v={$youtubeId}";

            try {
                $response = Http::timeout(5)->get('https://www.youtube.com/oembed', [
                    'url'    => $watchUrl,
                    'format' => 'json',
                ]);

                if ($response->ok() && $title = $response->json('title')) {
                    $video->update(['title' => $title]);
                    $this->line("  ✓ [{$video->id}] {$title}");
                    $updated++;
                } else {
                    $this->warn("  ✗ [{$video->id}] oEmbed вернул пустой ответ");
                }
            } catch (\Throwable $e) {
                $this->warn("  ✗ [{$video->id}] Ошибка: {$e->getMessage()}");
            }
        } else {
            $this->warn("  ? [{$video->id}] Не YouTube ссылка: {$video->url}");
        }
    }

    $this->info("Обновлено {$updated} из {$videos->count()} видео.");
})->purpose('Sync video titles from YouTube oEmbed API');
