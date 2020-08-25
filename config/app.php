<?php
/**
 *Description: ...
 *Created by: Isaac
 *Date: 7/23/2020
 *Time: 11:15 AM
 */
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();
define('ROOT', dirname( __DIR__));
define('VERSION',  $_SERVER['VERSION']);
define('DEBUG',  $_SERVER['DEBUG']);
const


EL = PHP_EOL ,


DS = DIRECTORY_SEPARATOR,
PUBLIC_PATH = ROOT . DS . 'public',
JS_PATH = PUBLIC_PATH . 'res' . 'js',
IMG_PATH = PUBLIC_PATH . 'res' . 'img',
CSS_PATH = PUBLIC_PATH . 'res' . 'css',
VIDEO_PATH = PUBLIC_PATH . 'res' . 'video',
MODELS_PATH = ROOT . DS . 'app' . DS .'models',
VIEWS_PATH = ROOT . DS . 'app' . DS .'views',
FORM_ERROR = VIEWS_PATH . DS .'templates' . DS . 'util' . DS . 'form-error.php',
CONTROLLERS_PATH = ROOT . DS . 'app' . DS .'controllers',
MIGRATIONS_PATH = ROOT.DS.'app'.DS.'src'.DS.'database'.DS.'migrations',



DEFAULT_METHOD = 'index',
DEFAULT_CONTROLLER = 'Home',
DEFAULT_LAYOUT = 'default',




SITE_TITLE = 'ZIKZAY Framework',
MENU_BRAND = 'ZIKZAY',



REMEMBER_ME_COOKIE_EXPIRY = 2592000,
COOKIE_LIFETIME = 36*5,
SESSION_LIFETIME = 3600,
SESSION_PREFIX = 'zik_',
COOKIE_PREFIX = 'zik_',

HASH_KEY = '$2y$10$hxsezYF6/nLrqzO7NXQLiOnbSFe16jgJaBoQpERY5ZdTTwlt0RHlu',
PAYSTACK_PRIVATE_KEY = 'Authorization: Bearer sk_live_388874e39160c232b4aeca35479232a528098c2d',
USER_PAY_CARD_TRANSACTION_CHARGE = false;










function dnd($data) {
    echo '<pre>';
        var_dump($data);
    echo '</pre>';
    die();
}

require_once ROOT . DS .'config' . DS . 'lang.php';


