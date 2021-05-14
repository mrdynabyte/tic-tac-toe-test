<?php

namespace App\Core;

interface BaseGame
{
    public function init();
    public function bootstrap();
    public function validate($args);
    public function getAttributes();
}
