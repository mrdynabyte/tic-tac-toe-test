<?php

namespace App\Games\TicTacToe;

use App\Models\Player;
use App\Core\BaseMatch;
use Illuminate\Console\Command;
use App\Models\GameMatch as GMatch;
use Illuminate\Support\Facades\Session;

class GameMatch implements BaseMatch
{
    private $id;
    private $context;
    private Game $game;
    private Player $playerOne;
    private Player $playerTwo;

    public function __construct()
    {
    }

    public function create(Command $context = null)
    {
        $this->game = new Game();
        $this->match = new GMatch();

        $this->setExecutionContext($context);

        return $this;
    }

    public function start($players)
    {
        $this->playerOne = array_shift($players);
        $this->playerTwo = array_shift($players);

        $this->match->id = 'ttt-match-' . substr(str_shuffle(MD5(microtime())), 0, 10);
        $this->match->playerOne = $this->playerOne;
        $this->match->playerTwo = $this->playerTwo;

        $this->id = $this->match->id;

        Session::put($this->id . $this->match);
        Session::put('next-turn', 0);
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

    public function playNextTurn()
    {
        $nextTurn = Session::get('next-turn');

        $this->context->info('You need to specify coordinates with : Example: 0-0');
        $this->showBoard();

        switch ($nextTurn) {
            case 0:
                $move = $this->context->ask($this->playerOne->nickname . '\'s turn. Make your move');
                break;
            case 1:
                $move = $this->context->ask($this->playerTwo->nickname . '\'s turn. Make your move');
                break;
        }

        $this->handleMove($move, $nextTurn);

        Session::put('next-turn', (int) !$nextTurn); //handled with boolean but saved as int
    }

    public function setExecutionContext($context)
    {
        $this->context = $context;
    }

    public function handleMove($move, $nextTurn = 0)
    {
        $coords = explode('-', $move);

        $attrs = [
            'x' => array_shift($coords),
            'y' => array_shift($coords),
            'player' => $nextTurn
        ];

        $this->game->updateBoard($attrs);
    }

    public function isActive()
    {
        return $this->game->isFinished();
    }

    protected function showBoard()
    {
        if ($this->context != null) {
            $this->context->info('Make your move!');
            $this->context->table([], $this->game->getAttributes());
        }

        return $this->game->render();
    }
}
