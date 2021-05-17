<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Player;
use App\Games\TicTacToe\Game;
use App\Games\TicTacToe\GameMatch;
use App\Models\GameMatch as GMatch;
use Illuminate\Support\Facades\Session;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class GameTest extends TestCase
{
    public function test_it_should_create_and_bootstrap_a_tic_tac_toe_game()
    {
        $bootstrappedBoard = [
            ['-', '-', '-'],
            ['-', '-', '-'],
            ['-', '-', '-'],
        ];

        $tttDummyGame = new Game();

        $this->assertEquals($bootstrappedBoard, $tttDummyGame->getAttributes());
    }

    public function test_it_starts_a_match_with_two_players()
    {
        $rick = new Player(['nickname' => 'Rick', 'email' => 'undisclosed@c-132.com']);
        $morty = new Player(['nickname' => 'Morty', 'email' => 'therealmorty@c-132.com']);

        $match = new GameMatch();
        $match->create()->start([$rick, $morty]);

        $this->assertEquals(0, Session::get('next-turn'));
        $this->assertTrue(Session::get($match->getMatchId()) instanceof GMatch);
    }

    public function test_it_properly_validates_a_victory()
    {
        $sampleBoard = [
            ['-', '-', '-'],
            ['-', 'X', '-'],
            ['-', '-', 'X'],
        ];

        $rick = new Player(['nickname' => 'Rick', 'email' => 'undisclosed@c-132.com']);
        $morty = new Player(['nickname' => 'Morty', 'email' => 'therealmorty@c-132.com']);

        $match = new GameMatch();
        $match->create()->start([$rick, $morty]);
        $match->getGameInstance()->setBoard($sampleBoard);
        $match->handleMove('0-0');

        $this->assertTrue(Session::get('ttt-is-there-a-winner'));
        $this->assertEquals(0, Session::get('ttt-winner'));
    }
}
