<?php

// configure your app for the production environment

$app['twig.path'] = array(
    __DIR__.'/../templates',
    /*__DIR__.'/../templates/reading_list',
    __DIR__.'/../templates/publisher_dashboard',
    __DIR__.'/../templates/publishers_home',
    __DIR__.'/../templates/readers_home',*/
);
// $app['twig.options'] = array('cache' => __DIR__.'/../var/cache/twig');
/*
$base_url = 'https://pocketapp-satya5614.c9.io/mavinreads/';

$app['asset_path_css'] = $base_url.'templates/assets/css/';
$app['asset_path_js'] = $base_url.'templates/assets/js/';
$app['asset_path_img'] = $base_url.'templates/assets/img/';
$app['asset_path_fonts'] = $base_url.'templates/assets/fonts/';*/
// define('FACEBOOK_API_KEY',    '1588055181458373');
// define('FACEBOOK_API_SECRET', '3815c9ec07557eaef4daded12efb37c7');