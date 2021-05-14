<?php

namespace App\Games\TicTacToe;

use App\Core\BaseGame;
use App\Games\TicTacToe\Player;

class Game implements BaseGame
{
    private $board;

    public function __construct()
    {
        $this->bootstrap();
    }

    public function init()
    {
    }

    public function bootstrap()
    {
        $this->board = array_fill(0, 3, []);
        $this->board[0] =  array_fill(0, 3, 0);
        $this->board[1] =  array_fill(0, 3, 0);
        $this->board[2] =  array_fill(0, 3, 0);
    }

    public function validate($args = [])
    {
    }

    public function getAttributes()
    {
        return [
            'board' => $this->board
        ];
    }
}
