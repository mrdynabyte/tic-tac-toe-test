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

    public function __construct(Command $context = null)
    {
        $this->game = new Game();
        $this->match = new GMatch();

        $this->setExecutionContext($context);
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

        $this->showBoard();
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
        $this->context->ask('');
    }

    public function setExecutionContext($context)
    {
        $this->context = $context;
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
