@include('includes.header')

<section>
    <h1>{{ $header ?? null }}</h1>

    <p>{{ $message ?? null }}</p>

    <form action="yatzy/play" method="POST">
        @csrf
        <label for="nrOfPlayers">Välj antal spelare</label>
        <select name="nrOfPlayers" id="nrOfPlayers">
            <option value="1">1 spelare</option>
            <option value="2" selected>2 spelare</option>
            <option value="3">3 spelare</option>
            <option value="4">4 spelare</option>
            <option value="5">5 spelare</option>
        </select><br>
        <input name="playGame" type="submit" value="Spela">
    </form>
    <br>
</section>

@include('includes.footer')
