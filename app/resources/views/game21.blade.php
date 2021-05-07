@include('includes.header')

<h1>{{ $header ?? null }}</h1>

<p>{{ $message ?? null }}</p>

Current Balance <br>
You: &#8383;{{ $humanBalance }} | Computer: &#8383;{{ $computerBalance }}<br><br>
<form action="game21" method="POST">
    @csrf
    <input name="playGame" type="submit" value="Play">
</form>
<br>

@include('includes.footer')
