<?php

require_once 'config/twig.php';



echo $twig->render('index.html.twig', [
      'title' => 'Početna',
]);
