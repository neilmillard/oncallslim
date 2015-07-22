<?php
// for the php built in web server
// php -S localhost:8888 public/routing.php
// public/routing.php
if (preg_match('/\.(?:png|jpg|jpeg|gif|js|css)$/', $_SERVER["REQUEST_URI"])) {
    return false;
} else {
    include __DIR__ . '/index.php';
}