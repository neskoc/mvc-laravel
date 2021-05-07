@include('includes.header')

<h1>{{ $header ?? null }}</h1>

{{ isset($message) ? '<p class="big_message">' . $message . "</p>" : '' }}

Current Balance <br>
You: &#8383;{{ $humanBalance }} | Computer: &#8383;{{ $computerBalance }}<br><br>

Your score:  {{ $humanScore }}<br>
Your last hand:
<div class="dice-utf8">
    @foreach ($graphicalHand as $value)
        {{ $value }}
    @endforeach
</div>
<p class="big_message">{{ $result }}</p>

Computer score:  {{ $computerScore }} <br>
Computer hands: 
<div class="dice-utf8">
@if ($computerRolls)
    @foreach ($computerRolls as $roll)
        @foreach ($roll as $dice)
            {{ $dice }}
        @endforeach
        &nbsp;
    @endforeach
@endif
</div>
<br><br>

Status rounds (wins):<br>
You: {{ $score["human"] }} | Computer: {{ $score["computer"] }}
<br><br>

<form action="game21" method="POST">
    @csrf
    <button name="resetGame">Reset game</button>
    <input name="playGame" type="submit" value="Play new round">
</form>
<br>

@include('includes.footer')
