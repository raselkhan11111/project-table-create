<?php
include_once './../../vendor/autoload.php';

// use Project\Controllers\students;
use Project\Controllers\student;

$products = new student();

$productsInfo = $products->details($_GET['id']);

// print_r($productsInfo);

?>

<a href="./index.php">List</a>
<h1>products Info</h1>
<p>Student ID: <?= $productsInfo['student_id'] ?></p>
<p>Name: <?= $productsInfo['name'] ?></p>