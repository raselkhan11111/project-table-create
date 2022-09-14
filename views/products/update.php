<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Only Post Request Allowed Here';
    die();
}

include_once './../../vendor/autoload.php';

use Project\Controllers\student;

$products = new student();

// echo '<pre>';
// print_r($_POST);

$products->update($_POST, $_GET['id']);

header('Location: ./index.php');
