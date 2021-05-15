<?php

namespace App\Games\TicTacToe;

use Session;
use Exception;
use App\Core\BasePlayer;
use App\Models\Player as TTTPlayer;

class Player implements BasePlayer
{
    public function create($playerData = [])
    {
        $player = new TTTPlayer($playerData);
        Session::put($player->nickname, $player);

        return $player;
    }

    public function delete($nickname = '')
    {
        if (empty($nickname)) {
            throw new Exception('Nickname cannot be empty');
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
