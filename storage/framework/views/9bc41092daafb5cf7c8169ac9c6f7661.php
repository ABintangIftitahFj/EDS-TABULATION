<?php $__env->startSection('title', 'Home - EDS UPI'); ?>

<?php $__env->startSection('content'); ?>
    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-24 pb-32 md:pt-32 md:pb-48 bg-slate-50">
        <div class="absolute inset-0 -z-10 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-20">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-12 items-center">
                <!-- Text Content -->
                <div class="text-left relative z-10">
                    <div
                        class="inline-flex items-center border-2 border-black bg-white px-3 py-1 text-sm leading-6 text-black shadow-pixel-sm mb-8 transform -rotate-2 hover:rotate-0 transition-transform cursor-default">
                        <span class="flex h-3 w-3 bg-england-red mr-2 border border-black"></span>
                        <span class="font-pixel tracking-wide">THE OFFICIAL DEBATE SOCIETY OF UPI</span>
                    </div>
                    <h1
                        class="text-6xl md:text-8xl font-pixel tracking-tight text-england-blue mb-6 leading-none drop-shadow-sm">
                        SUMMON THE FIRE OF <br />
                        <span
                            class="text-england-red bg-yellow-300 px-2 border-2 border-black shadow-pixel-sm inline-block transform -rotate-1 mt-2">DISCOURSE</span>
                    </h1>
                    <p class="mt-6 text-lg leading-8 text-slate-700 max-w-lg font-sans border-l-4 border-soft-pink pl-4">
                        Join a community of critical thinkers. We foster excellence in argumentation, public speaking, and
                        analytical thinking through competitive debate.
                    </p>
                    <div class="mt-10 flex items-center gap-x-6">
                        <a href="/tournaments"
                            class="pixel-btn bg-england-blue text-white hover:bg-england-red hover:text-white text-xl px-8 py-4">
                            VIEW TOURNAMENTS
                        </a>
                        <a href="/about"
                            class="text-lg font-pixel font-bold leading-6 text-black flex items-center gap-2 hover:gap-3 transition-all underline decoration-4 decoration-soft-pink underline-offset-4">
                            LEARN MORE <span aria-hidden="true">→</span>
                        </a>
                    </div>
                </div>

                <!-- Hero Image -->
                <div class="relative z-10 hidden md:block group">
                    <div
                        class="absolute -inset-4 bg-soft-pink border-2 border-black shadow-pixel-lg transform rotate-2 group-hover:rotate-1 transition-transform">
                    </div>
                    <div
                        class="relative bg-white border-2 border-black p-2 shadow-pixel-sm transform -rotate-2 group-hover:rotate-0 transition-transform">
                        <img src="<?php echo e(asset('images/cb.png')); ?>" alt="EDS UPI Team"
                            class="w-full h-auto grayscale group-hover:grayscale-0 transition-all duration-500">
                        <div
                            class="absolute -bottom-6 -right-6 bg-yellow-300 border-2 border-black px-4 py-2 shadow-pixel-sm transform rotate-3">
                            <span class="font-pixel text-xl text-black">WE ARE CHAMPIONS! 🏆</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scroll Morph Effect (CSS Animation) -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-[50px]" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1200 120" preserveAspectRatio="none">
                <path
                    d="M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z"
                    opacity=".25" class="fill-soft-pink animate-morph"></path>
                <path
                    d="M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z"
                    opacity=".5" class="fill-england-blue animate-morph-slow"></path>
                <path
                    d="M0,0V5.63C149.93,59,314.09,71.32,475.83,42.57c43-7.64,84.23-20.12,127.61-26.46,59-8.63,112.48,12.24,165.56,35.4C827.93,77.22,886,95.24,951.2,90c86.53-7,172.46-45.71,248.8-84.81V0Z"
                    class="fill-white"></path>
            </svg>
        </div>
    </section>

    <!-- Stats / Trust Section -->
    <section class="border-y-4 border-england-red bg-england-blue py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 text-center">
                <div class="flex flex-col gap-1 group hover:-translate-y-1 transition-transform">
                    <dt class="text-5xl font-pixel text-white drop-shadow-md">50+</dt>
                    <dd class="text-sm font-pixel text-soft-pink uppercase tracking-widest">Active Members</dd>
                </div>
                <div class="flex flex-col gap-1 group hover:-translate-y-1 transition-transform">
                    <dt class="text-5xl font-pixel text-white drop-shadow-md">120+</dt>
                    <dd class="text-sm font-pixel text-soft-pink uppercase tracking-widest">Awards Won</dd>
                </div>
                <div class="flex flex-col-reverse group hover:-translate-y-1 transition-transform">
                    <dt class="text-5xl font-pixel text-white drop-shadow-md">15</dt>
                    <dd class="text-sm font-pixel text-soft-pink uppercase tracking-widest">Years of Excellence</dd>
                </div>
                <div class="flex flex-col-reverse group hover:-translate-y-1 transition-transform">
                    <dt class="text-5xl font-pixel text-white drop-shadow-md">AP/BP</dt>
                    <dd class="text-sm font-pixel text-soft-pink uppercase tracking-widest">Formats Supported</dd>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 sm:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center mb-16">
                <h2
                    class="text-xl font-pixel font-bold leading-7 text-england-red uppercase tracking-widest border-b-4 border-yellow-300 inline-block">
                    What We Do</h2>
                <p class="mt-4 text-4xl font-pixel font-bold tracking-tight text-black sm:text-5xl">EXCELLENCE IN EVERY
                    MOTION.</p>
                <p class="mt-6 text-lg leading-8 text-slate-600 font-sans">
                    We provide a comprehensive platform for debaters to grow, compete, and manage tournaments efficiently.
                </p>
            </div>
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col pixel-card p-6 bg-yellow-50 hover:bg-yellow-100 transition-colors">
                        <dt class="flex items-center gap-x-3 text-xl font-pixel font-bold leading-7 text-black">
                            <div
                                class="h-12 w-12 flex items-center justify-center bg-yellow-400 border-2 border-black shadow-pixel-sm">
                                <svg class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.24 50.552 50.552 0 00-2.658.813m-15.482 0A50.55 50.55 0 0112 13.489a50.55 50.55 0 0112-1.743m-2.418 7.627A60.2 60.2 0 0112 20.904a60.2 60.2 0 01-8.232-4.41 60.46 60.46 0 00-.491-6.347m15.482 0a50.571 50.571 0 00-2.658-.813" />
                                </svg>
                            </div>
                            REGULAR TRAINING
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-700 font-sans">
                            <p class="flex-auto">Weekly practice sessions covering matter, manner, and method across various
                                motion themes.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col pixel-card p-6 bg-blue-50 hover:bg-blue-100 transition-colors">
                        <dt class="flex items-center gap-x-3 text-xl font-pixel font-bold leading-7 text-black">
                            <div
                                class="h-12 w-12 flex items-center justify-center bg-blue-400 border-2 border-black shadow-pixel-sm">
                                <svg class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0V5.625a1.125 1.125 0 00-1.125-1.125h-2.25a1.125 1.125 0 00-1.125 1.125v9.75" />
                                </svg>
                            </div>
                            TOURNAMENT HOSTING
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-700 font-sans">
                            <p class="flex-auto">State-of-the-art tabulation system for managing large-scale tournaments
                                with ease.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col pixel-card p-6 bg-green-50 hover:bg-green-100 transition-colors">
                        <dt class="flex items-center gap-x-3 text-xl font-pixel font-bold leading-7 text-black">
                            <div
                                class="h-12 w-12 flex items-center justify-center bg-green-400 border-2 border-black shadow-pixel-sm">
                                <svg class="h-6 w-6 text-black" fill="none" viewBox="0 0 24 24" stroke-width="2"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            COMMUNITY
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-700 font-sans">
                            <p class="flex-auto">A vibrant network of alumni and students fostering connections beyond the
                                debate chamber.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <!-- Latest News / Articles Preview -->
    <section class="py-24 bg-slate-50 border-t-4 border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-4xl font-pixel font-bold tracking-tight text-england-blue drop-shadow-sm">LATEST NEWS
                    </h2>
                    <p class="mt-2 text-slate-600 font-sans">Updates from the society and the debating world.</p>
                </div>
                <a href="/articles" class="hidden md:block pixel-btn bg-white text-black hover:bg-soft-pink text-sm">
                    VIEW ALL POSTS
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Article Card 1 -->
                <article
                    class="pixel-card flex flex-col items-start justify-between bg-white p-6 hover:shadow-pixel-lg transition-all duration-300 group">
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2023-10-16" class="text-slate-500 font-mono">Oct 16, 2023</time>
                        <span
                            class="relative z-10 bg-yellow-100 px-3 py-1 font-pixel text-yellow-800 border-2 border-yellow-200 shadow-sm">ACHIEVEMENT</span>
                    </div>
                    <div class="group relative">
                        <h3
                            class="mt-3 text-xl font-pixel font-bold leading-6 text-black group-hover:text-england-red transition-colors">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                EDS UPI Wins National Championship
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600 font-sans">
                            Our delegation secured the championship title at the National University Debating
                            Championship...
                        </p>
                    </div>
                </article>

                <!-- Article Card 2 -->
                <article
                    class="pixel-card flex flex-col items-start justify-between bg-white p-6 hover:shadow-pixel-lg transition-all duration-300 group">
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2023-10-10" class="text-slate-500 font-mono">Oct 10, 2023</time>
                        <span
                            class="relative z-10 bg-blue-100 px-3 py-1 font-pixel text-blue-800 border-2 border-blue-200 shadow-sm">EVENT</span>
                    </div>
                    <div class="group relative">
                        <h3
                            class="mt-3 text-xl font-pixel font-bold leading-6 text-black group-hover:text-england-red transition-colors">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Upcoming Internal Selection
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600 font-sans">
                            We are opening registration for the internal selection process for the upcoming regional
                            tournament...
                        </p>
                    </div>
                </article>

                <!-- Article Card 3 -->
                <article
                    class="pixel-card flex flex-col items-start justify-between bg-white p-6 hover:shadow-pixel-lg transition-all duration-300 group">
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2023-09-28" class="text-slate-500 font-mono">Sep 28, 2023</time>
                        <span
                            class="relative z-10 bg-green-100 px-3 py-1 font-pixel text-green-800 border-2 border-green-200 shadow-sm">TRAINING</span>
                    </div>
                    <div class="group relative">
                        <h3
                            class="mt-3 text-xl font-pixel font-bold leading-6 text-black group-hover:text-england-red transition-colors">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Weekly Training Schedule
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600 font-sans">
                            Check out the new training schedule for this semester. We have added special sessions for
                            novices...
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>

    <style>
        @keyframes morph {
            0% {
                d: path("M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z");
            }

            50% {
                d: path("M0,0V15.81C13,36.92,27.64,56.86,47.69,72.05,99.41,111.27,165,111,224.58,91.58c31.15-10.15,60.09-26.07,89.67-39.8,40.92-19,84.73-46,130.83-49.67,36.26-2.85,70.9,9.42,98.6,31.56,31.77,25.39,62.32,62,103.63,73,40.44,10.79,81.35-6.69,119.13-24.28s75.16-39,116.92-43.05c59.73-5.85,113.28,22.88,168.9,38.84,30.2,8.66,59,6.17,87.09-7.5,22.43-10.89,48-26.93,60.65-49.24V0Z");
            }

            100% {
                d: path("M0,0V46.29c47.79,22.2,103.59,32.17,158,28,70.36-5.37,136.33-33.31,206.8-37.5C438.64,32.43,512.34,53.67,583,72.05c69.27,18,138.3,24.88,209.4,13.08,36.15-6,69.85-17.84,104.45-29.34C989.49,25,1113-14.29,1200,52.47V0Z");
            }
        }

        .animate-morph {
            animation: morph 10s ease-in-out infinite;
        }

        .animate-morph-slow {
            animation: morph 15s ease-in-out infinite reverse;
        }
    </style>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.public', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\EDS-TABULATION\resources\views\welcome.blade.php ENDPATH**/ ?>