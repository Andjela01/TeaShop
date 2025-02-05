<?php
session_start();

require_once '../vendor/autoload.php';
require_once '../config/connection.php';



$twig = new \Twig\Environment(new \Twig\Loader\FilesystemLoader('../app/Views'));


echo $twig->render('admin.html.twig');
?>