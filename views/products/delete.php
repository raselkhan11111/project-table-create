<?php
include_once './../../vendor/autoload.php';

use Project\Controllers\student;

$product = new student();

$product->destroy($_GET['id']);

header('Location: ./index.php');