<?php

namespace App\Core;

interface BaseMatch
{
    public function start($players);
    public function terminate();
    public function getPlayers();
    public function getWinner();
    public function getLosers();
    public function getScore();
    public function performActionForPlayer();
}
