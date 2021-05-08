@include('includes.header')

<section>
    <h1>{{ $header ?? null }}</h1>

    <h2>Spelet är slut!</h2>

    <div>
        {!! $table !!}
    </div>

</section>

@include('includes.footer')
