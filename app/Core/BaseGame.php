<?php

namespace App\Core;

interface BaseGame
{
    public function init();
    public function bootstrap();
    public function validate($args);
    public function setAttributes($attrs);
    public function getAttributes();
    public function render();
}
