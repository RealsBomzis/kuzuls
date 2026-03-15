@extends('layouts.public')

@section('title','Sākums')

@section('content')
@php
    use Illuminate\Support\Facades\Storage;

    $featuredEvent = $pasakumi->first();

    function eventImageUrl($event) {
        if (!$event || empty($event->attels)) return null;

        return Storage::disk('public')->exists($event->attels)
            ? Storage::url($event->attels)
            : asset('storage/'.$event->attels);
    }
@endphp

<div class="space-y-16 md:space-y-24">
    {{-- HERO --}}
    <section class="relative overflow-hidden rounded-[2rem] border border-zinc-200 bg-white hero-shell">
        <div class="absolute inset-0 hero-glow pointer-events-none"></div>

        <div class="relative grid items-center gap-10 px-6 py-12 md:px-10 md:py-16 lg:grid-cols-2 lg:px-14 lg:py-20">
            <div class="reveal-up">
                <div class="inline-flex items-center rounded-full border border-yellow-200 bg-yellow-50 px-4 py-1.5 text-sm font-medium text-yellow-800">
                    Biedrība Kūzuls
                </div>

                <h1 class="mt-6 max-w-3xl text-4xl font-semibold tracking-tight text-zinc-950 md:text-5xl lg:text-6xl">
                    Kopā veidojam aktīvu, radošu un dzīvu kopienu
                </h1>

                <p class="mt-6 max-w-2xl text-base leading-8 text-zinc-600 md:text-lg">
                    Biedrība Kūzuls organizē pasākumus, īsteno projektus un dalās ar jaunumiem,
                    kas stiprina vietējo kopienu un iedvesmo iesaistīties.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    @if($featuredEvent)
                        <a href="#tuvakais-pasakums" class="btn-primary btn-pill">
                            Apskati tuvāko pasākumu
                        </a>
                    @else
                        <a href="{{ route('public.pasakumi.index') }}" class="btn-primary btn-pill">
                            Skatīt pasākumus
                        </a>
                    @endif

                    <a href="#projekti" class="btn-secondary btn-pill">
                        Apskatīt projektus
                    </a>
                </div>
            </div>

            <div class="reveal-up delay-1">
                <div class="rounded-[1.75rem] border border-zinc-200 bg-white p-3 shadow-[0_25px_80px_rgba(0,0,0,0.08)]">
                    @if($featuredEvent && eventImageUrl($featuredEvent))
                        <div class="overflow-hidden rounded-[1.4rem] border border-zinc-100 bg-zinc-100">
                            <img
                                src="{{ eventImageUrl($featuredEvent) }}"
                                alt="{{ $featuredEvent->nosaukums }}"
                                class="h-[320px] w-full object-cover md:h-[420px]"
                            >
                        </div>
                    @else
                        <div class="flex h-[320px] items-center justify-center rounded-[1.4rem] border border-zinc-100 bg-zinc-100 text-zinc-400 md:h-[420px]">
                            Nav attēla
                        </div>
                    @endif

                    @if($featuredEvent)
                        <div class="p-5">
                            <div class="text-sm text-zinc-500">
                                {{ $featuredEvent->norises_datums?->format('d.m.Y') ?? '—' }}
                                @if($featuredEvent->sakuma_laiks)
                                    · {{ \Illuminate\Support\Str::of($featuredEvent->sakuma_laiks)->substr(0,5) }}
                                @endif
                            </div>

                            <div class="mt-2 text-2xl font-semibold text-zinc-950">
                                {{ $featuredEvent->nosaukums }}
                            </div>

                            <div class="mt-2 text-sm text-zinc-600">
                                {{ $featuredEvent->vieta }}
                            </div>

                            <a href="{{ route('public.pasakumi.show',$featuredEvent) }}"
                               class="mt-4 inline-flex items-center gap-2 text-sm font-medium text-yellow-700 hover:text-yellow-800">
                                Atvērt pasākumu
                                <span aria-hidden="true">→</span>
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </section>

    {{-- TUVĀKAIS PASĀKUMS / EVENTS --}}
    <section id="tuvakais-pasakums" class="space-y-8">
        <div class="reveal-up max-w-2xl">
            <div class="text-sm font-medium text-yellow-700">Tuvākie pasākumi</div>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                Notikumi, kuros vari iesaistīties jau tuvākajā laikā
            </h2>
            <p class="mt-3 text-base leading-7 text-zinc-600">
                Svarīgākie pasākumi un aktivitātes, kas šobrīd ir visaktuālākās mūsu kopienai.
            </p>
        </div>

        @if($pasakumi->count())
            <div class="reveal-up delay-1 event-slider rounded-[2rem] border border-zinc-200 bg-white p-4 md:p-6" data-event-slider>
                <div class="flex items-center justify-between gap-3 mb-4">
                    <div class="text-sm text-zinc-500">
                        Izvēlies nākamo pasākumu
                    </div>

                    <div class="flex gap-2">
                        <button type="button" class="slider-arrow" data-event-prev aria-label="Iepriekšējais pasākums">←</button>
                        <button type="button" class="slider-arrow" data-event-next aria-label="Nākamais pasākums">→</button>
                    </div>
                </div>

                <div class="relative overflow-hidden rounded-[1.5rem] border border-zinc-100 bg-zinc-50">
                    @foreach($pasakumi as $index => $p)
                        @php
                            $img = eventImageUrl($p);
                        @endphp

                        <a href="{{ route('public.pasakumi.show',$p) }}"
                           class="event-slide {{ $index === 0 ? '' : 'hidden' }} block"
                           data-event-slide>
                            <div class="grid lg:grid-cols-[1.15fr_0.85fr]">
                                <div class="bg-zinc-100">
                                    @if($img)
                                        <img src="{{ $img }}" alt="{{ $p->nosaukums }}" class="h-[280px] w-full object-cover md:h-[420px]">
                                    @else
                                        <div class="flex h-[280px] items-center justify-center text-zinc-400 md:h-[420px]">
                                            Nav attēla
                                        </div>
                                    @endif
                                </div>

                                <div class="flex flex-col justify-center p-6 md:p-8 lg:p-10">
                                    <div class="inline-flex w-fit rounded-full border border-yellow-200 bg-yellow-50 px-3 py-1 text-sm text-yellow-800">
                                        {{ $p->norises_datums?->format('d.m.Y') ?? '—' }}
                                        @if($p->sakuma_laiks)
                                            · {{ \Illuminate\Support\Str::of($p->sakuma_laiks)->substr(0,5) }}
                                        @endif
                                    </div>

                                    <h3 class="mt-5 text-3xl font-semibold tracking-tight text-zinc-950">
                                        {{ $p->nosaukums }}
                                    </h3>

                                    <div class="mt-3 text-zinc-600">
                                        {{ $p->vieta }}
                                    </div>

                                    @if($p->apraksts)
                                        <p class="mt-5 line-clamp-4 leading-7 text-zinc-600">
                                            {{ $p->apraksts }}
                                        </p>
                                    @endif

                                    <div class="mt-8 inline-flex items-center gap-2 text-sm font-medium text-yellow-700">
                                        Skatīt pasākumu
                                        <span aria-hidden="true">→</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>

                <div class="mt-4 grid gap-3 md:grid-cols-3">
                    @foreach($pasakumi->take(3) as $thumbIndex => $p)
                        <button type="button"
                                class="event-thumb {{ $thumbIndex === 0 ? 'is-active' : '' }}"
                                data-event-thumb="{{ $thumbIndex }}">
                            <div class="text-left">
                                <div class="text-xs text-zinc-500">{{ $p->norises_datums?->format('d.m.Y') ?? '—' }}</div>
                                <div class="mt-1 font-medium text-zinc-900 truncate">{{ $p->nosaukums }}</div>
                                <div class="mt-1 text-xs text-zinc-500 truncate">{{ $p->vieta }}</div>
                            </div>
                        </button>
                    @endforeach
                </div>

                <div class="mt-6">
                    <a href="{{ route('public.pasakumi.index') }}" class="btn-secondary btn-pill">
                        Visi pasākumi
                    </a>
                </div>
            </div>
        @else
            <div class="rounded-[1.5rem] border border-zinc-200 bg-white p-6 text-zinc-600">
                Pašlaik nav publicētu tuvāko pasākumu.
            </div>
        @endif
    </section>

    {{-- JAUNUMI --}}
    <section id="jaunumi" class="space-y-8">
        <div class="reveal-up max-w-2xl">
            <div class="text-sm font-medium text-yellow-700">Jaunumi</div>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                Aktuālais par mūsu darbību un iniciatīvām
            </h2>
            <p class="mt-3 text-base leading-7 text-zinc-600">
                Uzzini par jaunākajiem notikumiem, idejām un aktivitātēm, kas šobrīd ir mūsu uzmanības centrā.
            </p>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            @foreach($jaunumi as $index => $j)
                <a href="{{ route('public.jaunumi.show',$j) }}"
                   class="reveal-up {{ $index === 0 ? 'lg:col-span-2' : '' }} home-card group"
                   style="transition-delay: {{ $index * 80 }}ms;">
                    <div class="text-sm text-zinc-500">{{ $j->publicesanas_datums?->format('d.m.Y') ?? '—' }}</div>
                    <h3 class="mt-3 text-xl font-semibold tracking-tight text-zinc-950 group-hover:text-yellow-800">
                        {{ $j->virsraksts }}
                    </h3>
                    <p class="mt-3 line-clamp-4 leading-7 text-zinc-600">
                        {{ $j->ievads ?: \Illuminate\Support\Str::limit(strip_tags($j->saturs), 200) }}
                    </p>
                    <div class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-yellow-700">
                        Lasīt vairāk
                        <span aria-hidden="true" class="transition group-hover:translate-x-0.5">→</span>
                    </div>
                </a>
            @endforeach
        </div>

        <div class="reveal-up">
            <a href="{{ route('public.jaunumi.index') }}" class="btn-secondary btn-pill">
                Visi jaunumi
            </a>
        </div>
    </section>

    {{-- PROJEKTI --}}
    <section id="projekti" class="space-y-8">
        <div class="reveal-up max-w-2xl">
            <div class="text-sm font-medium text-yellow-700">Projekti</div>
            <h2 class="mt-2 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                Darbi un ieceres, kas veido nozīmīgu kopienas virzību
            </h2>
            <p class="mt-3 text-base leading-7 text-zinc-600">
                Apskati projektus, kuros Biedrība Kūzuls iesaistās, sadarbojas un rada paliekošu vērtību.
            </p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @foreach($projekti as $index => $p)
                <a href="{{ route('public.projekti.show',$p) }}"
                   class="reveal-up home-card group"
                   style="transition-delay: {{ $index * 80 }}ms;">
                    <div class="inline-flex items-center rounded-full border border-zinc-200 bg-zinc-50 px-3 py-1 text-xs font-medium text-zinc-600">
                        Projekts
                    </div>

                    <h3 class="mt-4 text-xl font-semibold tracking-tight text-zinc-950 group-hover:text-yellow-800">
                        {{ $p->nosaukums }}
                    </h3>

                    <p class="mt-3 line-clamp-4 leading-7 text-zinc-600">
                        {{ \Illuminate\Support\Str::limit(strip_tags($p->apraksts), 180) }}
                    </p>

                    <div class="mt-5 inline-flex items-center gap-2 text-sm font-medium text-yellow-700">
                        Skatīt projektu
                        <span aria-hidden="true" class="transition group-hover:translate-x-0.5">→</span>
                    </div>
                </a>
            @endforeach
        </div>
    </section>

    {{-- FINAL CTA --}}
    <section class="reveal-up rounded-[2rem] border border-zinc-200 bg-white px-6 py-10 shadow-sm md:px-10 md:py-14">
        <div class="grid items-center gap-8 lg:grid-cols-[1fr_auto]">
            <div>
                <div class="inline-flex items-center rounded-full border border-yellow-200 bg-yellow-50 px-3 py-1 text-sm font-medium text-yellow-800">
                    Iesaisties
                </div>

                <h2 class="mt-4 text-3xl font-semibold tracking-tight text-zinc-950 md:text-4xl">
                    Vēlies uzzināt vairāk vai iesaistīties mūsu darbībā?
                </h2>

                <p class="mt-4 max-w-2xl leading-7 text-zinc-600">
                    Seko mūsu jaunumiem, apskati tuvākos notikumus vai sazinies ar mums,
                    lai iepazītu Biedrības Kūzuls darbību tuvāk.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">
                <a href="{{ route('contact.create') }}" class="btn-primary btn-pill">Sazināties</a>
                <a href="{{ route('public.jaunumi.index') }}" class="btn-secondary btn-pill">Skatīt jaunumus</a>
            </div>
        </div>
    </section>
</div>
@endsection