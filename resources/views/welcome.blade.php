@extends('layouts.public')

@section('title', 'Dashboard - EDS UPI')

@section('content')
    <!-- Hero Section -->
    <section class="relative overflow-hidden pt-24 pb-32 md:pt-32 md:pb-48">
        <div
            class="absolute inset-0 -z-10 bg-[radial-gradient(ellipse_at_top_right,_var(--tw-gradient-stops))] from-indigo-100/50 via-slate-50 to-white">
        </div>
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <div
                class="inline-flex items-center rounded-full border border-slate-200 bg-white/50 px-3 py-1 text-sm leading-6 text-slate-600 backdrop-blur-sm mb-8">
                <span class="flex h-2 w-2 rounded-full bg-indigo-500 mr-2"></span>
                The Official Debate Society of UPI
            </div>
            <h1 class="text-5xl md:text-7xl font-bold tracking-tight text-slate-900 mb-6">
                Summon the fire of <br class="hidden md:block" />
                <span class="text-transparent bg-clip-text bg-gradient-to-r from-indigo-600 to-violet-600">discourse &
                    debate.</span>
            </h1>
            <p class="mt-6 text-lg leading-8 text-slate-600 max-w-2xl mx-auto">
                Join a community of critical thinkers. We foster excellence in argumentation, public speaking, and
                analytical thinking through competitive debate.
            </p>
            <div class="mt-10 flex items-center justify-center gap-x-6">
                <a href="/tournaments"
                    class="rounded-full bg-slate-900 px-8 py-3.5 text-sm font-semibold text-white shadow-sm hover:bg-slate-800 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-slate-900 transition-all">
                    View Tournaments
                </a>
                <a href="/about"
                    class="text-sm font-semibold leading-6 text-slate-900 flex items-center gap-1 hover:gap-2 transition-all">
                    Learn more <span aria-hidden="true">→</span>
                </a>
            </div>
        </div>
    </section>

    <!-- Stats / Trust Section -->
    <section class="border-y border-slate-100 bg-slate-50/50 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 gap-8 md:grid-cols-4 text-center">
                <div class="flex flex-col gap-1">
                    <dt class="text-3xl font-bold text-slate-900">50+</dt>
                    <dd class="text-sm font-medium text-slate-500">Active Members</dd>
                </div>
                <div class="flex flex-col gap-1">
                    <dt class="text-3xl font-bold text-slate-900">120+</dt>
                    <dd class="text-sm font-medium text-slate-500">Awards Won</dd>
                </div>
                <div class="flex flex-col gap-1">
                    <dt class="text-3xl font-bold text-slate-900">15</dt>
                    <dd class="text-sm font-medium text-slate-500">Years of Excellence</dd>
                </div>
                <div class="flex flex-col gap-1">
                    <dt class="text-3xl font-bold text-slate-900">AP/BP</dt>
                    <dd class="text-sm font-medium text-slate-500">Formats Supported</dd>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="py-24 sm:py-32 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="mx-auto max-w-2xl lg:text-center mb-16">
                <h2 class="text-base font-semibold leading-7 text-indigo-600">What We Do</h2>
                <p class="mt-2 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">Excellence in every motion.</p>
                <p class="mt-6 text-lg leading-8 text-slate-600">
                    We provide a comprehensive platform for debaters to grow, compete, and manage tournaments efficiently.
                </p>
            </div>
            <div class="mx-auto max-w-2xl lg:max-w-none">
                <dl class="grid max-w-xl grid-cols-1 gap-x-8 gap-y-16 lg:max-w-none lg:grid-cols-3">
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.499 5.24 50.552 50.552 0 00-2.658.813m-15.482 0A50.55 50.55 0 0112 13.489a50.55 50.55 0 0112-1.743m-2.418 7.627A60.2 60.2 0 0112 20.904a60.2 60.2 0 01-8.232-4.41 60.46 60.46 0 00-.491-6.347m15.482 0a50.571 50.571 0 00-2.658-.813" />
                                </svg>
                            </div>
                            Regular Training
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600">
                            <p class="flex-auto">Weekly practice sessions covering matter, manner, and method across various
                                motion themes.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M16.5 18.75h-9m9 0a3 3 0 013 3h-15a3 3 0 013-3m9 0v-3.375c0-.621-.503-1.125-1.125-1.125h-.871M7.5 18.75v-3.375c0-.621.504-1.125 1.125-1.125h.872m5.007 0H9.497m5.007 0V5.625a1.125 1.125 0 00-1.125-1.125h-2.25a1.125 1.125 0 00-1.125 1.125v9.75" />
                                </svg>
                            </div>
                            Tournament Hosting
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600">
                            <p class="flex-auto">State-of-the-art tabulation system for managing large-scale tournaments
                                with ease.</p>
                        </dd>
                    </div>
                    <div class="flex flex-col">
                        <dt class="flex items-center gap-x-3 text-base font-semibold leading-7 text-slate-900">
                            <div class="h-10 w-10 flex items-center justify-center rounded-lg bg-indigo-50">
                                <svg class="h-6 w-6 text-indigo-600" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                                </svg>
                            </div>
                            Community
                        </dt>
                        <dd class="mt-4 flex flex-auto flex-col text-base leading-7 text-slate-600">
                            <p class="flex-auto">A vibrant network of alumni and students fostering connections beyond the
                                debate chamber.</p>
                        </dd>
                    </div>
                </dl>
            </div>
        </div>
    </section>

    <!-- Latest News / Articles Preview -->
    <section class="py-24 bg-slate-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold tracking-tight text-slate-900">Latest News</h2>
                    <p class="mt-2 text-slate-600">Updates from the society and the debating world.</p>
                </div>
                <a href="/articles" class="hidden md:block text-sm font-semibold text-indigo-600 hover:text-indigo-500">
                    View all posts <span aria-hidden="true">→</span>
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Article Card 1 -->
                <article
                    class="flex flex-col items-start justify-between bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2023-10-16" class="text-slate-500">Oct 16, 2023</time>
                        <span
                            class="relative z-10 rounded-full bg-slate-100 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-200">Achievement</span>
                    </div>
                    <div class="group relative">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-slate-900 group-hover:text-slate-600">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                EDS UPI Wins National Championship
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600">
                            Our delegation secured the championship title at the National University Debating
                            Championship...
                        </p>
                    </div>
                </article>

                <!-- Article Card 2 -->
                <article
                    class="flex flex-col items-start justify-between bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2023-10-10" class="text-slate-500">Oct 10, 2023</time>
                        <span
                            class="relative z-10 rounded-full bg-slate-100 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-200">Event</span>
                    </div>
                    <div class="group relative">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-slate-900 group-hover:text-slate-600">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Upcoming Internal Selection
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600">
                            We are opening registration for the internal selection process for the upcoming regional
                            tournament...
                        </p>
                    </div>
                </article>

                <!-- Article Card 3 -->
                <article
                    class="flex flex-col items-start justify-between bg-white p-6 rounded-2xl shadow-sm hover:shadow-md transition-shadow">
                    <div class="flex items-center gap-x-4 text-xs">
                        <time datetime="2023-09-28" class="text-slate-500">Sep 28, 2023</time>
                        <span
                            class="relative z-10 rounded-full bg-slate-100 px-3 py-1.5 font-medium text-slate-600 hover:bg-slate-200">Training</span>
                    </div>
                    <div class="group relative">
                        <h3 class="mt-3 text-lg font-semibold leading-6 text-slate-900 group-hover:text-slate-600">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                Weekly Training Schedule
                            </a>
                        </h3>
                        <p class="mt-5 line-clamp-3 text-sm leading-6 text-slate-600">
                            Check out the new training schedule for this semester. We have added special sessions for
                            novices...
                        </p>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection