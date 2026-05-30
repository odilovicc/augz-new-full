<template>
    <div
        class="group relative rounded-xl overflow-hidden bg-black cursor-pointer aspect-video"
        @click="emit('play', video)"
    >
        <!-- Thumbnail -->
        <img
            v-if="video.thumbnail"
            :src="video.thumbnail"
            :alt="video.title"
            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500 group-hover:brightness-75"
            @error="onThumbError"
        />
        <div v-else class="w-full h-full bg-gray-900" />

        <!-- Gradient -->
        <div class="absolute inset-0 bg-linear-to-t from-black/70 via-transparent to-transparent" />

        <!-- Badge -->
        <div v-if="video.badge" class="absolute top-3 left-3">
            <span class="text-[10px] font-black uppercase tracking-widest bg-black/60 text-white px-2 py-1 rounded-md backdrop-blur-sm border border-white/10">
                {{ video.badge }}
            </span>
        </div>

        <!-- Play button -->
        <div class="absolute inset-0 flex items-center justify-center">
            <div class="w-12 h-12 rounded-full bg-white/20 backdrop-blur-sm border border-white/30 flex items-center justify-center group-hover:bg-(--theme-color) group-hover:border-(--theme-color) transition-all duration-300 group-hover:scale-110">
                <svg class="w-5 h-5 text-white translate-x-0.5" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M8 5v14l11-7z" />
                </svg>
            </div>
        </div>

        <!-- Duration -->
        <div v-if="video.duration" class="absolute bottom-2.5 right-3">
            <span class="text-xs font-semibold text-white bg-black/60 px-1.5 py-0.5 rounded backdrop-blur-sm">
                {{ video.duration }}
            </span>
        </div>

        <!-- Title on hover -->
        <div class="absolute inset-x-0 bottom-0 p-3 translate-y-1 opacity-0 group-hover:translate-y-0 group-hover:opacity-100 transition-all duration-300">
            <p class="text-xs font-semibold text-white leading-snug line-clamp-2">{{ video.title }}</p>
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
    // fallback: maxresdefault → hqdefault
    if (img.src.includes('maxresdefault')) {
        img.src = img.src.replace('maxresdefault', 'hqdefault')
    }
}
</script>
