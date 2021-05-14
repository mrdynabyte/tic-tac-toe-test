<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class TicTacToeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $game = new Game([
            'name' => 'TicTacToe',
            'description' => 'A funny TicTacToe Game',
            'rules' => 'Match three Xs or Os in a row in any direction and you win!'
        ]);

        $game->save();
    }
}
