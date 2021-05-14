<?php

namespace App\Console\Commands;

use App\Games\TicTacToe\Match;
use Illuminate\Console\Command;

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
    public function __construct()
    {
        parent::__construct();
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
            '3. Start match',
            '4. Check results',
            '5. Exit'
        ], 2);

        $choice = substr($choice, 0, 1);

        return $this->handleMenuChoice($choice);
    }

    protected function handleMenuChoice($choice)
    {
        switch ($choice) {
            case 1:
                break;
            case 2:
                break;
            case 3:
                break;
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
}
