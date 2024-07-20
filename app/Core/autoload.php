<?php
require_once pathinfo(dirname(__DIR__))['dirname'] . DS . 'app' . DS . 'configs' . DS . 'paths.php';

require CONFIG .'db.php';

require CONFIG .'mail.php';

require VENDOR . 'autoload.php';

$coreClasses = ['Database', 'Model', 'Controller', 'View', 'App'];
requireFiles(CORE, $coreClasses);

$helperClasses = ['CookieManager', 'DateValidator', 'FileUploadValidator', 'FlashMessage', 'FormInputHandler', 'NumberValidator', 'RandomString', 'SessionManager', 'StringValidator', 'URLHelper'];
requireFiles(HELPERS, $helperClasses);

$librariesClasses = ['Mailer', 'Authentication'];
requireFiles(LIBRARIES, $librariesClasses);

function requireFiles(string $path, array $classes) :void
{
    foreach ($classes as $class) {
        $filePath = $path . $class . '.php';
        if (file_exists($filePath))
            require_once $filePath;
        else
            dump("Error: Class file ' $class .php' not found in ' $path '.");
    }
}


spl_autoload_register(function ($class) {
    $baseNamespace = 'Models\\';
    $baseDir = MODELS;
    if (strpos($class, $baseNamespace) === 0) {
        $relativeClass = substr($class, strlen($baseNamespace));
        $relativeClass = str_replace('\\', '/', $relativeClass);
        $file = $baseDir . $relativeClass . '.model.php';
        if (file_exists($file)) {
            require_once $file;
        } else {
            dump("Error: Class file ' $class .php' not found in ' $path '.");
        }
    }
});