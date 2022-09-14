<?php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo 'Only Post Request Allowed Here';
    die();
}

include_once './../../vendor/autoload.php';

use Project\Controllers\student;

$products = new student();

if (!$products->store($_POST)) {
    header('Location: ./create.php');
} else {
    header('Location: ./index.php');
}
