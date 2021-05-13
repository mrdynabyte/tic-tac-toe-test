<?php

interface BaseGame {
    public function rules();
    public function validateRules();
    public function getAttributes();
}