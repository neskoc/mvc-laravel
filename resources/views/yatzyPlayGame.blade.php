@include('includes.header')

<section>
    <h1>{{ $header ?? null }}</h1>

    <h2>{{ $message ?? null }}</h2>

    <div class="container-table100" data-pattern="priority-columns">
        <div class="wrap-table100">
            {!! $table !!}
        </div>
    </div>

    <form action="" method="POST">
        @csrf
        <input name="playGame" type="submit" value="Spela">
    </form>
    <br>
</section>

@include('includes.footer')

