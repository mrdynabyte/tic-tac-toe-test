<?php

namespace App\Console\Commands;

use App\Games\TicTacToe\Player;
use Illuminate\Console\Command;
use App\Games\TicTacToe\GameMatch;
use Illuminate\Support\Facades\Session;

class TicTacToe extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'tic-tac-toe:start';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'This command will allow you to start a new TicTacToe game.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(Player $players, GameMatch $matches)
    {
        parent::__construct();

        $this->players = $players;
        $this->matches = $matches;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        Session::start();

        $this->info(base64_decode(getenv('GAME_HEADLINE')));
        $this->showMenu();
    }

    protected function showMenu()
    {
        $choice = $this->choice('Please select an option: ', [
            '1. Create player',
            '2. Delete player',
            '3. New match',
            '4. Check last match results',
            '5. Exit'
        ], 2);

        $choice = substr($choice, 0, 1);

        return $this->handleMenuChoice($choice);
    }

    protected function handleMenuChoice($choice)
    {
        switch ($choice) {
            case 1:
                $this->createPlayer();
                break;
            case 2:
                $this->deletePlayer();
                break;
            case 3:
                $this->startMatch();
                break;
            case 4:
                $this->showLastMatchResults();
                break;
            case 5:
                break;
            default:
                $this->showMenu();
                break;
        }
    }

    protected function createPlayer()
    {
        $this->info('Please input the details: ');

        $nickname = $this->ask('Username');
        $email = $this->ask('Email');

        try {
            $this->players->create([
                'nickname' => $nickname,
                'email' => $email,
            ]);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->showMenu();
    }

    protected function deletePlayer()
    {
        $this->info('Please input the details: ');

        $nickname = $this->ask('Username');

        try {
            $this->players->delete($nickname);
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }

        $this->showMenu();
    }

    protected function startMatch()
    {
        [$playerOne, $playerTwo] = $this->requireForPlayers();

        if ($playerOne != null && $playerTwo != null) {
            $match = $this->matches->create($this);
            $match->start([$playerOne, $playerTwo]);

            $this->triggerMatch($match);
        } else {
            $this->error('You need to provide an existing nickname');
        }

        $this->showMenu();
    }

    protected function showLastMatchResults()
    {
        $lastMatch = $this->matches->getLastMatchResults();

        if ($lastMatch == null) {
            $this->error(' No matches have taken place yet :(');
            $this->showMenu();
        }

        $this->comment(' ==== Last match results ===');
        $this->table([], $lastMatch->getBoard());
        $this->info('The winner was: ' . $lastMatch->getWinner()->nickname);

        $this->showMenu();
    }

    private function triggerMatch($match)
    {
        while ($match->isActive()) {
            $match->playNextTurn();
        }

        $match->terminate();

        $this->showMenu();
    }

    private function requireForPlayers()
    {
        $playerOneNickname = $this->ask('Who\'s Player 1');
        $playerTwoNickname = $this->ask('Who\'s Player 2');

        $playerOne = $this->players->findPlayer($playerOneNickname);
        $playerTwo = $this->players->findPlayer($playerTwoNickname);

        return [$playerOne, $playerTwo];
    }
}
