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
    private Player $winner;

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

    public function getMatchId()
    {
        return $this->match->id;
    }

    public function start($players)
    {
        $this->playerOne = array_shift($players);
        $this->playerTwo = array_shift($players);

        $this->match->id = 'ttt-match-' . substr(str_shuffle(MD5(microtime())), 0, 10);
        $this->match->playerOne = $this->playerOne;
        $this->match->playerTwo = $this->playerTwo;

        $this->id = $this->match->id;

        Session::put($this->id, $this->match);
        Session::put('next-turn', 0);
    }

    public function terminate()
    {
        $this->setWinner();

        $this->context->error(' ===== MATCH FINISHED ===== ');
        $this->context->comment('The winner is: ' . $this->getWinner()->nickname);

        Session::put('ttt-last-match', $this);
        Session::put('ttt-last-match-winner', $this->getWinner());
    }

    public function getPlayers()
    {
        return [$this->playerOne, $this->playerTwo];
    }

    public function setWinner()
    {
        $this->winner = Session::get('ttt-winner') == 0 ? $this->playerOne : $this->playerTwo;
    }

    public function getWinner()
    {
        return $this->winner;
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

        $this->context->comment('You need to specify coordinates with : Example: 0-0');
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

        Session::put('next-turn', (int) !$nextTurn); //handled as boolean but saved as int
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

        if (($attrs['x'] < 0 || $attrs['x'] > 2) || $attrs['y'] < 0 || $attrs['y'] > 2) {
            $this->context->error('Invalid move. You lost your turn');
            return;
        }

        $this->game->updateBoard($attrs);

        $this->game->validate($attrs);
    }

    public function getGameInstance()
    {
        return $this->game;
    }

    public function getBoard()
    {
        return $this->game->getAttributes();
    }

    public function isActive()
    {
        return !$this->game->isThereAWinner();
    }

    public function getLastMatchResults()
    {
        return Session::get('ttt-last-match');
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
