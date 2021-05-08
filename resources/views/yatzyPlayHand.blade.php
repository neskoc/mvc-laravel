@include('includes.header')

<section>
    <h1>{{ $header ?? null }}</h1>

    <h2>Spelare: {{ $playerNr ?? 1 }}, Omgång: {{ $round ?? 1 }},  Slag: {{ $rollNr ?? 1 }}</h2>

    <form action="" method="POST">
        @csrf
        @if ($rollNr < 3)
            <input name="playHand" type="submit" value="Slå tärningar">
        @endif
        <button type="submit" formaction="save" value="save">Stanna</button>
        {!! $hand !!}

        <div>
            {!! $table !!}
        </div>
    </form>
</section>

@include('includes.footer')
