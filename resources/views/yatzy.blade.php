@include('includes.header')

<section>
    <h1>{{ $header ?? null }}</h1>

    <p id="message">{{ $message ?? null }}</p>

    <form action="yatzy/play" method="POST">
        @csrf
        <label for="nrOfPlayers">Välj antal spelare</label>
        <select name="nrOfPlayers" id="nrOfPlayers" onchange="changeForm()">
            <option value="1">1 spelare</option>
            <option value="2" selected>2 spelare</option>
            <option value="3">3 spelare</option>
            <option value="4">4 spelare</option>
            <option value="5">5 spelare</option>
        </select><br>
        <fieldset id="player-names">
            <legend>Ange spelarnamn</legend>
            <label for="player1">Spelare 1</label>
            <input type="text" id="player1" name="player1" maxlength="15" placeholder="Spelarnamn"><br>
            <label for="player2">Spelare 2</label>
            <input type="text" id="player2" name="player2" maxlength="15" placeholder="Spelarnamn"><br>
        </fieldset>
        <input name="playGame" type="submit" value="Spela">
    </form>
    <br>
</section>

<script>
    function changeForm() {
        let value = document.getElementById("nrOfPlayers").value;
        let fieldset = document.getElementById("player-names");
        fieldset.innerHTML = "";
        let legend = document.createElement("LEGEND");
        legend.innerText = "Ange spelarnamn";
        fieldset.appendChild(legend);
        for (i = 1; i <= value; i++) {
        let label = document.createElement("LABEL");
        let input = document.createElement("INPUT");
        let br = document.createElement("BR");

        input.type = "text";
        input.id = "player" + i;
        input.name = "player" + i;
        input.maxlength = "15";
        input.placeholder = "Spelarnamn";

        label.htmlFor = "player" + i;
        label.innerHTML = "Spelare " + i + " ";

        fieldset.appendChild(label);
        fieldset.appendChild(input);
        fieldset.appendChild(br);
        }
    }
</script>
@include('includes.footer')
