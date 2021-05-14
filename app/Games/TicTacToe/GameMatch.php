<?php

namespace App\Games\TicTacToe;

use App\Core\BaseMatch;

class GameMatch implements BaseMatch
{
    private Game $board;
    private Player $playerOne;
    private Player $playerTwo;

    public function __construct()
    {
        $this->board = new Game();
    }

    public function start($players)
    {
        $this->playerOne = array_shift($players);
        $this->playerTWo = array_shift($players);
    }

    public function terminate()
    {
    }

    public function getPlayers()
    {
        return [$this->playerOne, $this->playerTwo];
    }

    public function getWinner()
    {
    }

    public function getLosers()
    {
    }

    public function getScore()
    {
    }

    public function performActionForPlayer()
    {
    }
}
