@extends('layouts.user')

@section('content')

<div class="text-center mb-12">
    <p class="text-base font-semibold leading-7 text-indigo-600">{{ $article->category }}</p>
    <h1 class="mt-2 text-3xl font-bold tracking-tight text-black sm:text-4xl">{{ $article->title }}</h1>
    <div class="mt-6 flex items-center justify-center gap-x-4 text-sm text-black">
        <time
            datetime="{{ $article->published_at }}">{{ $article->published_at ? $article->published_at->format('F d, Y') : 'Draft' }}</time>
    </div>
</div>

@if($article->image_path)
    <div class="mb-10">
        <img src="{{ $article->image_path }}" alt="{{ $article->title }}"
            class="rounded-2xl shadow-lg w-full object-cover max-h-[500px]">
    </div>
@endif

<div class="prose prose-lg prose-slate mx-auto">
    {!! $article->content !!}
</div>

<div class="mt-12 pt-8 border-t border-slate-200">
    <a href="/articles" class="text-indigo-600 hover:text-indigo-500 font-medium">&larr; Back to all
        articles</a>
</div>
@endsection
