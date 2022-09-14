<?php

namespace Project\Controllers;

use Exception;
use PDO;

class student
{
    public $id;
    public $name;
    public $conn;

    private $dbUserName = 'root';
    private $dbPassword = '1234';
    private $dbName = 'php_b8';

    public function __construct()
    {
        session_start();
        try {
            $this->conn = new PDO('mysql:host=localhost;dbname=' . $this->dbName, $this->dbUserName, $this->dbPassword);
        } catch (Exception $ex) {
            echo 'Database connection failed. Error: ' . $ex->getMessage();
            die();
        }
    }

    public function index()
    {
        // select query
        $statement = $this->conn->query("SELECT * FROM products ORDER BY id desc");
        $data = $statement->fetchAll(PDO::FETCH_ASSOC);

        return $data;
    }

    public function store(array $data)
    {
// img store.....................

$uploaddir = './../../assets/uploads/';

        // $uploadfile = $uploaddir . $_FILES['picture']['name'];

        $allowed_exttension=array('gif','png','jpg','jpeg');
        $actuaImageName = $_FILES['picture']['name'];
        $formattedImageName = date('Y-m-d') . time() . $actuaImageName;
        $uploadfile = $uploaddir . $formattedImageName;
        $uploadfiletocheck = $uploaddir . $_FILES['picture']['name'];
      //  die($formattedImageName);
         move_uploaded_file($_FILES['picture']['tmp_name'], $uploadfile);
         
	 //$imageName=$_FILES['img']['name'];
	 $file_extension=pathinfo($actuaImageName,PATHINFO_EXTENSION);


        try {
            $_SESSION['old'] = $data;

            if (empty($data['student_id'])) {
                $_SESSION['errors']['student_id'] = 'Required';
            } elseif (!is_numeric($data['student_id'])) {
                $_SESSION['errors']['student_id'] = 'Must be an integer';
            }

            if (empty($data['name'])) {
                $_SESSION['errors']['name'] = 'Required';
            }

            if (isset($_SESSION['errors'])) {
                return false;
            }

            // todo database insert
            $statement = $this->conn->prepare("INSERT INTO products (name, student_id) VALUES (:s_name, :s_id)");

            $statement->execute([
                's_name' => $data['name'],
                's_id' => $data['student_id']
            ]);

            unset($_SESSION['old']);
            $_SESSION['message'] = 'Successfully Created';
            return true;
        } catch (Exception $th) {
            $_SESSION['errors']['sqlError'] = $th->getMessage();
        }
    }

    public function details(int $id)
    {
        // select query
        $statement = $this->conn->query("SELECT * FROM products where id=$id");
        $data = $statement->fetch(PDO::FETCH_ASSOC);
        return $data;
    }

    public function update(array $data, int $id)
    {
        // todo database insert
        $statement = $this->conn->prepare("UPDATE products set name=:s_name, student_id=:s_id WHERE id=:r_id");

        $statement->execute([
            'r_id' => $id,
            's_name' => $data['name'],
            's_id' => $data['student_id']
        ]);

        $_SESSION['message'] = 'Successfully Updated';
    }

    public function destroy(int $id)
    {
        $statement = $this->conn->prepare("DELETE FROM  products where id=:s_id");
        $statement->execute([
            's_id' => $id
        ]);

        $_SESSION['message'] = 'Successfully Deleted';
    }
}
