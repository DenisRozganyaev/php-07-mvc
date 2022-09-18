<?php
define('BASE_DIR', dirname(__DIR__));
define('SERVER_PORT', (!empty($_SERVER['SERVER_PORT']) ? ':' . $_SERVER['SERVER_PORT'] : ''));
define('SITE_URL', $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . SERVER_PORT);

const ASSET_URL = SITE_URL . '/assets';
const IMG_URL = ASSET_URL . '/images';
const APP_DIR = BASE_DIR . '/App';
const VIEW_DIR = APP_DIR . '/Views/';
const IMG_DIR = BASE_DIR . '/public/assets/images';
