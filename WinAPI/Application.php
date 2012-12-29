<?php

namespace WinAPI;

use WinAPI\Win32api;

class Application
{
    public $terminate;

    public function __construct(array $options = array())
    {
        if (!preg_match('/^5.5/', phpversion())) {
            die('Version php MUST be 5.5 or higher');
        }
    }

    public function run()
    {
        while (!$this->terminate) {

        }
    }
}