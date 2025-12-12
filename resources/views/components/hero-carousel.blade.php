<div
    x-data="{
        activeSlide: 0,
        slides: {{ $slides->toJson() }},
        autoplayInterval: null,

        init() {
            if (this.slides.length > 1) {
                this.startAutoplay();
            }
        },

        next() {
            this.activeSlide = (this.activeSlide + 1) % this.slides.length;
            this.resetAutoplay();
        },

        prev() {
            this.activeSlide = (this.activeSlide - 1 + this.slides.length) % this.slides.length;
            this.resetAutoplay();
        },

        goTo(index) {
            this.activeSlide = index;
            this.resetAutoplay();
        },

        startAutoplay() {
            // Use the duration from the CURRENT slide for the NEXT transition?
            // Or simple global/per-slide logic.
            // For simplicity with per-slide duration, we need a recursive timeout or interval reset.
            // Let's use a dynamic timeout based on current slide's duration.

            this.scheduleNext();
        },

        scheduleNext() {
            if (this.autoplayInterval) clearTimeout(this.autoplayInterval);

            let duration = this.slides[this.activeSlide].display_duration || 5000;

            this.autoplayInterval = setTimeout(() => {
                this.next();
                // scheduleNext is called implicitly via watcher or we just call it?
                // Actually next() calls resetAutoplay which calls startAutoplay which calls scheduleNext.
            }, duration);
        },

        resetAutoplay() {
            if (this.autoplayInterval) clearTimeout(this.autoplayInterval);
            if (this.slides.length > 1) {
                this.scheduleNext();
            }
        }
    }"
    class="relative h-[80vh] flex items-center justify-center overflow-hidden bg-gray-900"
>
    <!-- Slides -->
    <template x-for="(slide, index) in slides" :key="slide.id">
        <div
            x-show="activeSlide === index"
            x-transition:enter="transition ease-out duration-1000"
            x-transition:enter-start="opacity-0 transform scale-105"
            x-transition:enter-end="opacity-100 transform scale-100"
            x-transition:leave="transition ease-in duration-1000 absolute"
            x-transition:leave-start="opacity-100 transform scale-100"
            x-transition:leave-end="opacity-0 transform scale-95"
            class="absolute inset-0 w-full h-full flex items-center justify-center"
        >
            <!-- Background Image -->
            <div class="absolute inset-0 bg-gray-900">
                <img :src="slide.image_url" class="w-full h-full object-cover opacity-50" :alt="slide.title">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900/50 to-gray-900"></div>
            </div>

            <!-- Content -->
            <div class="relative z-10 text-center px-4 animate-fade-in-up">
                <h1
                    x-text="slide.title"
                    class="text-5xl md:text-8xl font-bold text-white mb-6 tracking-tighter uppercase"
                ></h1>

                <p
                    x-text="slide.description"
                    class="text-lg md:text-2xl text-amber-500 font-light tracking-[0.2em] mb-10 uppercase"
                ></p>

                <a
                    x-show="slide.button_text && slide.button_url"
                    :href="slide.button_url"
                    class="group inline-flex items-center gap-3 px-8 py-4 border border-gray-600 text-gray-300 hover:border-white hover:text-white transition duration-500 uppercase tracking-widest text-xs"
                >
                    <span x-text="slide.button_text"></span>
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 group-hover:translate-x-1 transition"><path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" /></svg>
                </a>
            </div>
        </div>
    </template>

    <!-- Fallback if no slides (though controller should handle this, good to have safeguard) -->
    <div x-show="slides.length === 0" class="absolute inset-0 flex items-center justify-center text-white">
        <!-- Render default static hero if no slides? Or empty. -->
        <!-- We will ensure controller passes at least one slide or we fallback in Blade. -->
    </div>

    <!-- Controls -->
    <div x-show="slides.length > 1" class="absolute inset-x-0 bottom-10 z-20 flex justify-center gap-4">
        <!-- Prev Button -->
        <button @click="prev()" class="p-2 text-white/50 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5L8.25 12l7.5-7.5" />
            </svg>
        </button>

        <!-- Dots -->
        <div class="flex items-center gap-2">
            <template x-for="(slide, index) in slides" :key="slide.id">
                <button
                    @click="goTo(index)"
                    class="w-2 h-2 rounded-full transition-all duration-300"
                    :class="activeSlide === index ? 'bg-amber-500 w-8' : 'bg-white/30 hover:bg-white/50'"
                ></button>
            </template>
        </div>

        <!-- Next Button -->
        <button @click="next()" class="p-2 text-white/50 hover:text-white transition">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
            </svg>
        </button>
    </div>
</div>
