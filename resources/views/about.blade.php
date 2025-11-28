@extends('layouts.user')

@section('content')

<div class="relative isolate overflow-hidden bg-slate-900 py-24 sm:py-32">
    <div
        class="absolute inset-0 -z-10 h-full w-full object-cover opacity-20 bg-[url('https://images.unsplash.com/photo-1524178232363-1fb2b075b655?ixlib=rb-4.0.3&auto=format&fit=crop&w=2070&q=80')] bg-cover bg-center">
    </div>
    <div class="mx-auto max-w-7xl px-6 lg:px-8 text-center">
        <h2 class="text-4xl font-bold tracking-tight text-white sm:text-6xl">About EDS UPI</h2>
        <p class="mt-6 text-lg leading-8 text-slate-300 max-w-2xl mx-auto">
            The English Debating Society of Universitas Pendidikan Indonesia is a student organization dedicated to
            fostering critical thinking, public speaking, and global awareness.
        </p>
    </div>
</div>

<!-- Content -->
<div class="mx-auto max-w-7xl px-6 lg:px-8 py-24">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
        <div>
            <h3 class="text-2xl font-bold tracking-tight text-slate-900 sm:text-3xl mb-6">Our Mission</h3>
            <div class="prose prose-slate text-slate-600">
                <p>
                    Established with the vision of creating a generation of critical thinkers, EDS UPI has grown to
                    become one of the most prominent debate societies in Indonesia. We believe in the power of
                    discourse to change minds and shape the future.
                </p>
                <p>
                    Our members regularly participate in national and international tournaments, consistently
                    achieving high rankings and bringing honor to the university. Beyond competition, we are a
                    family that supports each other's growth academically and personally.
                </p>
            </div>
        </div>
        <div class="grid grid-cols-2 gap-4">
            <img src="https://images.unsplash.com/photo-1517048676732-d65bc937f952?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Debate Team"
                class="rounded-xl shadow-lg rotate-3 hover:rotate-0 transition-transform duration-300">
            <img src="https://images.unsplash.com/photo-1523580494863-6f3031224c94?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80"
                alt="Tournament"
                class="rounded-xl shadow-lg -rotate-3 hover:rotate-0 transition-transform duration-300 mt-8">
        </div>
    </div>
</div>
</div>

@endsection