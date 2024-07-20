<?php

use Core\App;
use Libraries\Authentication;

session_start();

ob_start();

define("DS", !defined('DS') || DS !== DIRECTORY_SEPARATOR ? DIRECTORY_SEPARATOR : DS);

require_once 'app' . DS . 'Core' . DS . 'autoload.php';

new Authentication();

new App();

ob_end_flush();
