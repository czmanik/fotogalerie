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
            this.scheduleNext();
        },

        scheduleNext() {
            if (this.autoplayInterval) clearTimeout(this.autoplayInterval);

            let duration = this.slides[this.activeSlide].display_duration || 5000;

            this.autoplayInterval = setTimeout(() => {
                this.next();
            }, duration);
        },

        resetAutoplay() {
            if (this.autoplayInterval) clearTimeout(this.autoplayInterval);
            if (this.slides.length > 1) {
                this.scheduleNext();
            }
        }
    }"
    class="relative h-[80vh] flex items-center justify-center overflow-hidden bg-gray-900 group/carousel"
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
            class="absolute inset-0 w-full h-full"
            :class="{
                'flex items-center': true,
                'md:grid md:grid-cols-2': slide.layout === 'split_left' || slide.layout === 'split_right',
                'justify-center': slide.layout === 'overlay'
            }"
        >

            <!-- OVERLAY LAYOUT (and Mobile Default) -->
            <!-- Background Image -->
            <div
                class="absolute inset-0 bg-gray-900"
                :class="{ 'md:hidden': slide.layout !== 'overlay' }"
            >
                <img :src="slide.image_url" class="w-full h-full object-cover opacity-50" :alt="slide.title">
                <div class="absolute inset-0 bg-gradient-to-b from-transparent via-gray-900/50 to-gray-900"></div>
            </div>

            <!-- SPLIT LAYOUT (Desktop only) -->
            <!-- Image Left -->
            <div
                x-show="slide.layout === 'split_left'"
                class="hidden md:block w-full h-full bg-gray-900 relative"
            >
                 <img :src="slide.image_url" class="w-full h-full object-cover" :alt="slide.title">
                 <div class="absolute inset-0 bg-black/10"></div>
            </div>

            <!-- Content Area -->
            <!-- Note: On mobile we always want 'overlay' behavior (absolute center),
                 on desktop 'split' we want it relative in grid column. -->
            <div
                class="relative z-10 px-4 animate-fade-in-up w-full md:w-auto"
                :class="{
                    'absolute inset-0 flex flex-col justify-center': slide.layout === 'overlay' || true, /* Mobile always overlay behavior */
                    'md:static md:flex md:flex-col md:justify-center md:h-full md:p-12 md:bg-gray-900': slide.layout !== 'overlay',
                    'md:order-first': slide.layout === 'split_right', /* If split right, content is first (left) */

                    'text-left': slide.text_alignment === 'left',
                    'text-center': slide.text_alignment === 'center',
                    'text-right': slide.text_alignment === 'right',
                }"
            >
                <!-- Boxed Wrapper -->
                <div
                    :class="{
                        'bg-black/60 p-8 backdrop-blur-sm border border-white/10 rounded-sm': slide.content_style === 'boxed',
                        'inline-block': slide.content_style === 'boxed' && slide.layout === 'overlay', /* Keep it tight on overlay */
                        'block': slide.content_style === 'boxed' && slide.layout !== 'overlay' /* Full width in grid cell */
                    }"
                    class="mx-auto md:mx-0 max-w-4xl"
                    :style="slide.text_alignment === 'center' ? 'margin-left: auto; margin-right: auto;' : (slide.text_alignment === 'right' ? 'margin-left: auto; margin-right: 0;' : 'margin-left: 0; margin-right: auto;')"
                >
                    <h1
                        x-text="slide.title"
                        class="text-5xl md:text-7xl font-bold text-white mb-6 tracking-tighter uppercase leading-tight"
                    ></h1>

                    <div
                        x-html="slide.description"
                        class="text-lg md:text-xl text-amber-500 font-light tracking-[0.2em] mb-10 uppercase prose prose-invert prose-p:text-amber-500 prose-a:text-white"
                    ></div>

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

            <!-- SPLIT LAYOUT (Desktop only) -->
            <!-- Image Right -->
            <div
                x-show="slide.layout === 'split_right'"
                class="hidden md:block w-full h-full bg-gray-900 relative"
            >
                 <img :src="slide.image_url" class="w-full h-full object-cover" :alt="slide.title">
                 <div class="absolute inset-0 bg-black/10"></div>
            </div>

        </div>
    </template>

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
