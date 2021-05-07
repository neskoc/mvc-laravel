<?php

declare(strict_types=1);

namespace App\Models\Dice;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Game class.
 */

class Game
{
    private HumanPlayer $humanPlayer;
    private ComputerPlayer $computerPlayer;
    private int $rounds = 0;
    private int $bet;

    public function __construct()
    {
        $this->addHumanPlayer(new HumanPlayer());
        $this->addComputerPlayer(new ComputerPlayer());
    }

    public function addHumanPlayer(HumanPlayer $humanPlayer)
    {
        $this->humanPlayer = $humanPlayer;
    }

    public function addComputerPlayer(ComputerPlayer $computerPlayer)
    {
        $this->computerPlayer = $computerPlayer;
    }

    public function newGame(): View
    {
        $data = [
            "header" => "Game 21 (new game)",
            "humanBalance" => $this->humanPlayer->getBalance(),
            "computerBalance" => $this->computerPlayer->getBalance()
        ];
        return view("game21", $data);
    }

    public function playGame(): View
    {
        $data = [
            "header" => "Game 21 (play)",
            "humanBalance" => $this->humanPlayer->getBalance(),
            "maxBet" => min($this->humanPlayer->getBalance() / 2, $this->computerPlayer->getBalance()),
            "computerBalance" => $this->computerPlayer->getBalance()
        ];

        return view("play", $data);
    }

    public function playRound(Request $request): View
    {
        $request->session()->put('nrOfDices', (int) $_POST['nrOfDices']);
        $this->humanPlayer->startRound($request->session()->get('nrOfDices'));
        $this->computerPlayer->startRound($request->session()->get('nrOfDices'));
        $this->bet = (int) $_POST['bet'];
        $this->rounds += 1;

        return $this->roll($request);
    }

    public function roll(Request $request): View
    {
        $lost = false;

        $playComputerHand = false;
        if (isset($_POST['roll']) || isset($_POST['playHand'])) {
            $lost = $this->playHumanHand();
            if ($this->humanPlayer->getRoundScore() === 21) {
                $playComputerHand = true;
            }
        } else {
            $playComputerHand = true;
        }
        if ($playComputerHand) {
            $computerRolls = $this->playComputerHand();

            $lost = false;

            if (
                $this->computerPlayer->getRoundScore() >= $this->humanPlayer->getRoundScore() &&
                $this->computerPlayer->getRoundScore() <= 21
            ) {
                $lost = true;
            }
        }

        if ($lost) {
            $this->humanPlayer->removeBitcoins($this->bet);
            $this->computerPlayer->addBitcoins($this->bet);
        } elseif (isset($_POST['stop'])) {
            $this->computerPlayer->removeBitcoins($this->bet);
            $this->humanPlayer->addBitcoins($this->bet);
        }

        $data = [
            "header" => "Play round {$this->rounds}",
            "message" => $this->humanPlayer->getRoundScore() === 21 ? "You've got 21! Congratulation!" : null,
            "humanBalance" => $this->humanPlayer->getBalance(),
            "computerBalance" => $this->computerPlayer->getBalance(),
            "humanScore" => $this->humanPlayer->getRoundScore(),
            "humanLastHand" => $this->humanPlayer->getLastHand(),
            "graphicalHand" => $this->humanPlayer->getLastGraphicalHand(),
            "computerScore" => $this->computerPlayer->getRoundScore() ?? null,
            "computerRolls"  => $computerRolls ?? null,
            "bet" => $this->bet,
            "nrOfDices" => $request->session()->get('nrOfDices')
        ];

        if (!$lost && !isset($_POST['stop']) && !$playComputerHand) {
            $request->session()->put('game', serialize($this));
            // $body = renderView("layout/hand.php", $data);
            $view = view("hand", $data);
        } else {
            $this->addWin($lost);
            $request->session()->put('game', serialize($this));
            $data["header"] = "Result round {$this->rounds}";
            $data["score"] = $this->getScore();
            $data["result"] = $lost ? "You lost this round" : "You won this round";
            // $body = renderView("layout/result.php", $data);
            $view = view("result", $data);
        }

        return $view;
    }

    public function playHumanHand(): bool
    {
        if ($this->humanPlayer->playHand() > 21) {
            return true;
        }
        return false;
    }

    public function playComputerHand(): array
    {
        $rolls = [];
        do {
            $res = $this->computerPlayer->playHand();
            $rolls[] = $this->computerPlayer->getLastGraphicalHand();
        } while ($res < 21 && $res < $this->humanPlayer->getRoundScore());

        return $rolls;
    }

    public function addWin($lost): void
    {
        if ($lost) {
            $this->computerPlayer->increaseWins();
        } else {
            $this->humanPlayer->increaseWins();
        }
    }

    public function getRounds(): int
    {
        return $this->rounds;
    }

    public function getScore(): array
    {
        $score = [
            "human" => $this->humanPlayer->getWins(),
            "computer" => $this->computerPlayer->getWins()
        ];
        return $score;
    }
}
