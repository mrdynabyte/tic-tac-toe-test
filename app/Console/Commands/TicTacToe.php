<?php

namespace App\Console\Commands;

use App\Games\TicTacToe\Player;
use Illuminate\Console\Command;
use App\Games\TicTacToe\GameMatch;

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
    public function __construct(Player $players)
    {
        parent::__construct();

        $this->players = $players;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {

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
            case 2:
                $this->deletePlayer();
            case 3:
                $this->startMatch();
            case 4:
                break;
            case 5:
                return;
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
        $playerOne = $this->ask('Who\'s Player 1');
        $playerTwo = $this->ask('Who\'s Player 2');

        $playerOne = $this->players->findPlayer($playerOne);
        $playerTwo = $this->players->findPlayer($playerTwo);

        if ($playerOne != null && $playerTwo != null) {
            $match = new GameMatch();
            $match->start([$playerOne, $playerTwo]);
        }

        $this->showMenu();
    }
}
