<?php

namespace App\Games\TicTacToe;

use Exception;
use App\Core\BasePlayer;
use App\Models\Player as TTTPlayer;
use Illuminate\Support\Facades\Session;

class Player implements BasePlayer
{
    public function create($playerData = [])
    {
        if ($playerData['nickname'] == '') {
            throw new Exception('You need to provide a nickname');
        }

        $player = new TTTPlayer($playerData);

        Session::put($player->nickname, $player);

        return $player;
    }

    public function delete($nickname = '')
    {
        if (empty($nickname)) {
            throw new Exception('You need to provide a nickname');
        }

        return Session::remove($nickname);
    }

    public function update($playerData = [])
    {
        // TODO: Add if needed
    }

    public function findPlayer($nickname)
    {
        return Session::get($nickname);
    }
}
