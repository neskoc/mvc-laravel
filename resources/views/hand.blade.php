@include('includes.header')

<h1>{{ $header ?? null }}</h1>

<p>{{ $message ?? null }}</p>

Current Balance <br>
You: &#8383;{{ $humanBalance }} | Computer: &#8383;{{ $computerBalance }}<br><br>

Number of dices: {{ $nrOfDices }}<br><br>

Your bet: &#8383;{{ $bet }}<br><br>

Your score:  {{ $humanScore }} <br>
Your last hand: 
<div class="dice-utf8">
@foreach ($graphicalHand as $value)
    {{ $value }}
@endforeach
</div>

<form action="game21" method="POST">
    @csrf
    <button name="roll">Roll dice(s)</button>
    <input name="stop" type="submit" value="Stop">
</form>
<br>

@include('includes.footer')
