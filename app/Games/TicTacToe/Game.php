<?php

namespace App\Games\TicTacToe;

use App\Core\BaseGame;
use Illuminate\Support\Facades\Session;

class Game implements BaseGame
{
    const LENGTH = 3;

    private $board;

    public function __construct()
    {
        $this->bootstrap();
        Session::put('ttt-board-' . substr(str_shuffle(MD5(microtime())), 0, 10));
        Session::put('ttt-is-there-a-winner', false);
    }

    public function init()
    {
        // TODO: Not actually needed. Its there just for logic separation in the future
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
        $player = $args['player'] == 0 ? 'X' : 'O';

        $hScore = $this->validateHorizontal($player, $args['x']);
        $vScore = $this->validateVertical($player, $args['y']);
        $dScore = $this->validateDiagonal($player);
        $dScore = $this->validateDiagonal($player);
        $dRScore = $this->validateReverseDiagonal($player);

        $isThereAWinner = ($hScore == self::LENGTH || $vScore == self::LENGTH || $dScore == self::LENGTH || $dRScore == self::LENGTH);

        if ($isThereAWinner) {
            Session::put('ttt-is-there-a-winner', $isThereAWinner);
            Session::put('ttt-winner', $args['player']);
            Session::put('ttt-winner-board', $this->board);
        }

        return $isThereAWinner;
    }

    public function setBoard($board)
    {
        $this->board = $board;
    }

    public function isThereAWinner()
    {
        return Session::get('ttt-is-there-a-winner');
    }

    public function getAttributes()
    {
        return $this->board;
    }

    public function setAttributes($attrs)
    {
        $this->board[$attrs['x']][$attrs['y']] = $attrs['player'] == 0 ? 'X' : 'O';
    }

    public function render()
    {
        return json_encode($this->board);
    }

    public function updateBoard($attrs)
    {
        $this->setAttributes($attrs);
    }

    protected function validateHorizontal($player, $row)
    {
        $score = 0;

        for ($i = 0; $i < self::LENGTH; $i++) {
            if ($this->board[$row][$i] == $player) {
                $score++;
            }
        }

        return $score;
    }

    protected function validateVertical($player, $column)
    {
        $score = 0;

        for ($i = 0; $i < self::LENGTH; $i++) {
            if ($this->board[$i][$column] == $player) {
                $score++;
            }
        }

        return $score;
    }

    protected function validateDiagonal($player)
    {
        $score = 0;

        for ($i = 0; $i < self::LENGTH; $i++) {
            if ($this->board[$i][$i] == $player) {
                $score++;
            }
        }

        return $score;
    }

    protected function validateReverseDiagonal($player)
    {
        $score = 0;

        if ($this->board[0][2] == $player) {
            $score++;
        }

        if ($this->board[1][1] == $player) {
            $score++;
        }

        if ($this->board[2][0] == $player) {
            $score++;
        }

        return $score;
    }
}
