@include('includes.header')

<h1>{{ $header ?? null }}</h1>

<table class="scores-container">
<thead>
    <tr>
        <th class="">Player</th>
        <th class="">Score</th>
        <th class="">Date</th>
    </tr>
</thead>

<tbody>
    @foreach ($highScore as $score)
    <tr>
        <td class="">{{ $score['player_name'] }}</td>
        <td class="">{{ $score['score'] }}</td>
        <td class="">{{ date('Y:m:d', strtotime($score['date'])) }}</td>
    </tr>
    @endforeach
</tbody>
</table>

<div class="high-score">
    @foreach ($histogram as $staple)
        {{ $staple }}
        <br><br>
    @endforeach
</div>

@include('includes.footer')
