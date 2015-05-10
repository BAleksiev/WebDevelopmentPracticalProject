<?php

function redirect($action) {
    header('Location: '.Config::get('app.root_dir').'/'.$action);
    exit;
}

function url($url) {
    return Config::get('app.root_dir').'/'.implode('/', $url);
}

function esc($str) {
    return htmlspecialchars($str);
}