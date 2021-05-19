@include('includes.header')

<section>
    <h1>{{ $header ?? null }}</h1>

    <h2>
        Spelare {{ $playerNr ?? 1 }}: {{ $playerName }} 
        <br>Omgång: {{ $round ?? 1 }},  Slag: {{ $rollNr ?? 1 }}
    </h2>

    <p>
        Välj rad du vill spara i. Om du väljer redan spelat slag stryks det.
    </p>

    <form action="" method="POST">
        @csrf
        <input name="keep" type="submit" value="Spara handen">
        {!! $hand !!}

        <div>
            {!! $table !!}
        </div>
    </form>
</section>

@include('includes.footer')
