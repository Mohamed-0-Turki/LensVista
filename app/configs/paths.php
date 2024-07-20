<?php

define('PROTOCOL', isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http');

define('HOST', $_SERVER['HTTP_HOST']);

define('BASE_URL', PROTOCOL . '://' . HOST . dirname($_SERVER['PHP_SELF']) . '/');

define('ROOT_PATH', pathinfo(dirname(__DIR__))['dirname'] . DS);

define('APP', dirname(__DIR__) . DS);

const VENDOR = ROOT_PATH . 'vendor' . DS;

const CONFIG = APP . 'configs' . DS;

const CONTROLLERS = APP . 'Controllers' . DS;

const CORE = APP . 'Core' . DS;

const MODELS = APP . 'Models' . DS;

const VIEWS = APP . 'views' . DS;
const INCLUDES = VIEWS . 'includes' . DS;

const LIBRARIES = APP . 'Libraries' . DS;

const HELPERS = APP . 'Helpers' . DS;

const PUBLIC_FOLDER = ROOT_PATH . 'public' . DS;
const UPLOADS = PUBLIC_FOLDER . 'uploads' . DS;
const UPLOAD_IMAGES = UPLOADS . 'images' . DS;