<?php

/**
 * YatzyGame class.
 */

declare(strict_types=1);

namespace App\Models\Yatzy;

use neskoc\Dice\NewDiceHand;

use function Mos\Functions\renderView;
use function Mos\Functions\url;
use function Mos\Functions\redirectTo;

class YatzyGame
{
    private const NR_OF_DICES = 5;
    private const NR_OF_ROLLS = 3;

    private int $rollNr = 0;
    private int $round = 1;
    private int $playerNr = 1;
    private array $savedDices = [];

    public array $yatzyPlayers;
    public int $nrOfPlayers;
    public NewDiceHand $diceHand;
    public YatzyTable $yatzyTable;

    public YatzyPlayer $currentPlayer;

    public function __construct()
    {
        $this->diceHand = new NewDiceHand(5);
    }

    public function initialize(): string
    {
        $data = [
            "header" => "Yatzy (startsida)"
        ];

        $body = renderView("layout/yatzy.php", $data);

        return $body;
    }

    public function playHand(): string
    {
        $this->savedDices = $_POST['dice'] ?? [];
        $this->diceHand->rollSelectively($this->savedDices);

        if (isset($_POST['nrOfPlayers'])) {
            $this->nrOfPlayers = (int) $_POST['nrOfPlayers'];

            for ($i = 1; $i <= $this->nrOfPlayers; $i += 1) {
                $this->yatzyPlayers[$i] = new YatzyPlayer($i);
            }
            $this->currentPlayer = $this->yatzyPlayers[$this->playerNr];
            $this->yatzyTable = new YatzyTable($this->nrOfPlayers);
            $this->round = 1;
        } else {
            $yatzyTable = $this->yatzyTable->showYatzyTable($this->yatzyTable);
        }
        $yatzyTable = $yatzyTable ?? '';

        $this->yatzyTable->setLastHand($this->diceHand->getLastHand());
        $this->rollNr += 1;
        if ($this->rollNr === 3) {
            $_SESSION['yatzy-game'] = serialize($this);
            redirectTo('save');
            exit();
        }

        // $debug = json_encode($this->savedDices) . json_encode($res);
        $data = [
            "header" => "Yatzy (omgångar)",
            "message" => '',
            "table" => $yatzyTable,
            "round" => $this->round,
            "playerNr" => $this->playerNr,
            "rollNr" => $this->rollNr,
            "hand" => $this->showHandChoices($this->diceHand->getLastGraphicalHand()),
            "debug" => ''
        ];

        $body = renderView("layout/yatzyPlayHand.php", $data);

        return $body;
    }

    public function saveHand(): string
    {
        if (isset($_POST['keep'])) {
            $diceHandArray = $this->diceHand->getLastHand();
            $choice = (int) $_POST["choice"];
            $this->yatzyTable->currentColumn->saveValue($choice, $diceHandArray);
            $this->diceHand->rollSelectively([]);
            $this->savedDices = [];

            $finished = false;
            $finishedCounter = $this->nrOfPlayers + 2;
            do {
                $finishedCounter -= 1;
                $this->playerNr += 1;
                if ($this->playerNr > $this->nrOfPlayers) {
                    $this->playerNr = 1;
                }
                if ($this->yatzyTable->yatzyColumns[$this->nrOfPlayers - 1]->active === true) {
                    $finished = true;
                }
            } while (!$finished && $finishedCounter > 0);

            $this->currentPlayer = $this->yatzyPlayers[$this->playerNr];
            $this->yatzyTable->currentColumn = $this->yatzyTable->yatzyColumns[$this->playerNr - 1];
            $this->rollNr = 0;
            if ($this->playerNr == 1) {
                $this->round += 1;
            }
            if ($finishedCounter === 0) {
                $_SESSION['yatzy-game'] = serialize($this);
                redirectTo('game-over');
                exit();
            }
            $_SESSION['yatzy-game'] = serialize($this);
            if (!headers_sent()) {
                redirectTo('play');
                exit();
            }
        }

        $debug = $debug ?? '';

        $data = [
            "header" => "Yatzy (spara)",
            "message" => '',
            "table" => $this->yatzyTable->showYatzyTable($this->yatzyTable, true),
            "round" => $this->round,
            "playerNr" => $this->playerNr,
            "rollNr" => $this->rollNr,
            "hand" => $this->showHandChoices($this->diceHand->getLastGraphicalHand(), false),
            "debug" => '' // $debug
        ];

        $body = renderView("layout/yatzySaveHand.php", $data);

        return $body;
    }

    public function gameOver(): string
    {
        $yatzyTable = $this->yatzyTable->showYatzyTable($this->yatzyTable);

        $data = [
            "header" => "Yatzy (slut)",
            "message" => 'Spelet är slut!',
            "table" => $yatzyTable,
            "round" => $this->round,
            "debug" => ''
        ];

        $body = renderView("layout/yatzyGameOver.php", $data);

        return $body;
    }

    private function showHandChoices(array $graphicalHand, bool $withCheckboxes = true): string
    {
        $htmlTextContent = '<ul class="hand-choice">';
        for ($i = 0; $i < self::NR_OF_DICES; $i += 1) {
            $checked = '';
            if (in_array($i, $this->savedDices)) {
                $checked = " checked";
            }
            $htmlTextContent .= '<li class="dice-column">';
            $htmlTextContent .= "<div class=\"dice\">{$graphicalHand[$i]}";
            $htmlTextContent .= '</div>';
            $htmlTextContent .= '<div class="lower-row">';
            if ($withCheckboxes) {
                $htmlTextContent .= '<input type="checkbox" name="dice[]" value="' . "{$i}\"{$checked}>";
            }
            $htmlTextContent .= '</div>';
            $htmlTextContent .= "</div></li>";
        }
        $htmlTextContent .= "</ul>";

        return $htmlTextContent;
    }
}
// echo '<pre>' . var_export($this->currentPlayer, true) . '</pre>';
// exit();
