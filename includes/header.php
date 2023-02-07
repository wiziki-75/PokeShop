<?php
session_start();
$dsn = 'mysql:host=localhost;dbname=pokebif';
$user = 'root';
$pass = '';
$pdo = new \PDO($dsn, $user, $pass);

if (isset($_SESSION['error_message'])) {
  echo '<script>alert("' . $_SESSION['error_message'] . '")</script>';
  unset($_SESSION['error_message']);
}

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
  <script src="https://code.jquery.com/jquery-3.6.0.js"></script>
  <link rel="stylesheet" href="//cdn.datatables.net/1.10.24/css/jquery.dataTables.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.6.1/css/font-awesome.min.css">
  <script src="//cdn.datatables.net/1.10.24/js/jquery.dataTables.min.js"></script>
  <link href="css/styles.css" rel="stylesheet" />
  <title>Pokebif</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css" rel="stylesheet" />
</head>