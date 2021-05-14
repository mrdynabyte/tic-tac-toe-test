<?php

namespace App\Core;

interface BaseGame
{
    public function bootstrap();
    public function init();
    public function validate();
    public function getAttributes();
}
