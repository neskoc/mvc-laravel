@include('includes.header')

<h1>{{ $header ?? null }}</h1>

<p>{{ $message ?? null }}</p>

Current Balance <br>
You: &#8383;{{ $humanBalance }} | Computer: &#8383;{{ $computerBalance }}<br><br>
<form action="game21" method="POST">
    @csrf
    <label for="nrOfDices">Choose number of dices:</label>
    <select name="nrOfDices" id="nrOfDices">
        <option value="1">1</option>
        <option value="2" selected>2</option>
    </select><br>
    <label for="bet">Bet value (&#8383;):</label>
    <input class="shortInput" type="number" step="0.1" value='2' placeholder='0.0' min='0.1' max='<?= $maxBet ?>' id="bet" name="bet">
    <br><br>
    <input name="playHand" type="submit" value="Play hand">
</form>
<br>

@include('includes.footer')
