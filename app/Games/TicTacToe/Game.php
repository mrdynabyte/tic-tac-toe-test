<?php

namespace App\Games\TicTacToe;

use App\Core\BaseGame;
use Illuminate\Support\Facades\Session;

class Game implements BaseGame
{
    private $board;

    public function __construct()
    {
        $this->bootstrap();
        Session::put('ttt-board-' . substr(str_shuffle(MD5(microtime())), 0, 10));
    }

    public function init()
    {
    }

    public function bootstrap()
    {
        $this->board = array_fill(0, 3, []);
        $this->board[0] =  array_fill(0, 3, '-');
        $this->board[1] =  array_fill(0, 3, '-');
        $this->board[2] =  array_fill(0, 3, '-');
    }

    public function validate($args = [])
    {
        return true;
    }

    public function isFinished()
    {
        return $this->validate();
    }

    public function getAttributes()
    {
        return $this->board;
    }

    public function setAttributes($attrs)
    {
    }

    public function render()
    {
        return json_encode($this->board);
    }
}
