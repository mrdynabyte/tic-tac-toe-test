<?php

namespace App\Core;

interface BasePlayer
{
    public function create($playerData);
    public function update($playerData);
    public function delete($nickname);
}
