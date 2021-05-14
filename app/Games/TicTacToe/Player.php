<?php

namespace App\Games\TicTacToe;

use App\Core\BasePlayer;
use App\Models\Player as TTTPlayer;

class Player implements BasePlayer
{
    public function create($playerData = [])
    {
        $player = new TTTPlayer($playerData);
        $player->save();

        return $player;
    }

    public function delete($nickname = '')
    {
        $player = TTTPlayer::where(['nickname' => $nickname])->first();

        return $player->delete();
    }

    public function update()
    {
    }
}
