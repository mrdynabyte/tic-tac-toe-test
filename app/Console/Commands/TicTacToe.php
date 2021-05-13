<?php

namespace App\Console\Commands;

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
        echo "Hello world!";
        return 0;
    }
}
