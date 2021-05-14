<?php

namespace App\Games\TicTacToe;

use Exception;
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
        if (empty($nickname)) {
            throw new Exception('Nickname cannot be empty');
        }

        $player = TTTPlayer::where(['nickname' => $nickname])->first();
        return $player->delete();
    }

    public function update()
    {
    }
}
