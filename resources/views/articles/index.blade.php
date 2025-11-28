@extends('layouts.user')

@section('content')

            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">News & Updates</h1>
                <p class="mt-4 text-lg text-slate-600">Latest stories, achievements, and announcements from EDS UPI.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($articles as $article)
                    <article
                        class="flex flex-col overflow-hidden rounded-2xl bg-white shadow-sm hover:shadow-md transition-shadow">
                        <div class="flex-shrink-0">
                            <img class="h-48 w-full object-cover"
                                src="{{ $article->image_path ?? 'https://placehold.co/600x400?text=EDS+UPI' }}"
                                alt="{{ $article->title }}">
                        </div>
                        <div class="flex flex-1 flex-col justify-between p-6">
                            <div class="flex-1">
                                <p class="text-sm font-medium text-indigo-600">
                                    {{ $article->category }}
                                </p>
                                <a href="/articles/{{ $article->slug }}" class="mt-2 block">
                                    <p class="text-xl font-semibold text-slate-900">{{ $article->title }}</p>
                                    <p class="mt-3 text-base text-slate-500 line-clamp-3">
                                        {{ Str::limit(strip_tags($article->content), 150) }}</p>
                                </a>
                            </div>
                            <div class="mt-6 flex items-center">
                                <div class="text-sm text-slate-500">
                                    <time
                                        datetime="{{ $article->published_at }}">{{ $article->published_at ? $article->published_at->format('M d, Y') : 'Draft' }}</time>
                                </div>
                            </div>
                        </div>
                    </article>
                @empty
                            <div class="col-span-full text-center py-12">
                                <p class="text-slate-500">No articles found.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        @endsection