<template>
    <div class="group flex flex-col cursor-pointer rounded-2xl border border-gray-100 bg-white overflow-hidden hover:shadow-md transition-shadow duration-300" @click="emit('play', video)">
        <!-- Thumbnail -->
        <div class="relative overflow-hidden bg-gray-100 aspect-video">
            <img
                v-if="video.thumbnail"
                :src="video.thumbnail"
                :alt="video.title"
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
                @error="onThumbError"
            />
            <div v-else class="w-full h-full bg-gray-100" />

            <!-- Play button -->
            <div class="absolute inset-0 flex items-center justify-center">
                <div class="w-10 h-10 rounded-full border border-gray-400/50 bg-white/10 flex items-center justify-center group-hover:bg-(--theme-color) group-hover:border-(--theme-color) transition-all duration-300">
                    <svg class="w-4 h-4 text-gray-700 group-hover:text-white translate-x-0.5 transition-colors duration-300" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M8 5v14l11-7z" />
                    </svg>
                </div>
            </div>

            <!-- Duration -->
            <div v-if="video.duration" class="absolute bottom-2 right-2">
                <span class="text-[11px] font-semibold text-white bg-black/50 px-1.5 py-0.5 rounded backdrop-blur-sm">
                    {{ video.duration }}
                </span>
            </div>
        </div>

        <!-- Title + Badge -->
        <div class="flex flex-col gap-2.5 p-4 flex-1">
            <p class="text-sm font-semibold text-gray-900 leading-snug line-clamp-2">{{ video.title }}</p>
            <div v-if="video.badge" class="mt-auto">
                <span class="text-[11px] font-semibold text-gray-400 uppercase tracking-wide">{{ video.badge }}</span>
            </div>
        </div>
    </div>
</template>

<script setup lang="ts">
export interface Video {
    id: string | number
    title: string
    thumbnail?: string
    duration?: string
    badge?: string
    url?: string
}

const props = defineProps<{
    video: Video
}>()

const emit = defineEmits<{
    play: [video: Video]
}>()

function onThumbError(e: Event) {
    const img = e.target as HTMLImageElement
    if (img.src.includes('maxresdefault')) {
        img.src = img.src.replace('maxresdefault', 'hqdefault')
    }
}
</script>
