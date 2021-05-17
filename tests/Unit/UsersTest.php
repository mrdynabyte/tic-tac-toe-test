<?php

namespace Tests\Unit;

use Mockery;
use App\Games\TicTacToe\Player;
use PHPUnit\Framework\TestCase;

class UsersTest extends TestCase
{
    public function test_it_should_create_a_player()
    {
        $playerData = [
            'nickname' => 'potato_man',
            'email' => 'mrpotato@potatomail.com'
        ];

        $playersMock = $this->createMock(Player::class);
        $playersMock->expects($this->once())->method('create')->with($playerData);

        $playersMock->create($playerData);
    }

    public function test_it_should_delete_a_player()
    {
        $playerData = [
            'nickname' => 'potato_man',
        ];

        $playersMock = $this->createMock(Player::class);
        $playersMock->expects($this->once())->method('delete')->with($playerData);

        $playersMock->delete($playerData);
    }

    public function test_it_should_find_a_player()
    {
        $playerData = [
            'nickname' => 'potato_man',
        ];

        $playersMock = $this->createMock(Player::class);
        $playersMock->expects($this->once())->method('findPlayer')->with($playerData);

        $playersMock->findPlayer($playerData);
    }
}
