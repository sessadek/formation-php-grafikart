<?php

require_once '../vendor/autoload.php';

use App\App;

$auth = App::getAuth();


if(session_status() === PHP_SESSION_NONE) {
  session_start();
}

// if(isset($_SESSION) && !empty($_SESSION['user'])) {
//   $user = $auth->user();
//   if(!is_null($user) && is_object($user)) {
//     header('Location: index.php');
//     exit;
//   }
// }

$error = false;

if(!empty($_POST)) {
  $user = $auth->login($_POST['username'], $_POST['password']);
  if($user) {
    header('Location: index.php?login=1');
    exit;
  }
  $error = true;
}
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body class="p-4 container">
  <?php if($error) : ?>
    <div class="alert alert-danger">
      Identifiant ou password est incorrecte
    </div>
  <?php endif ?>
  <?php if(isset($_GET['forbidden'])) : ?>
    <div class="alert alert-danger">
      L'accés a la page est intérdit
    </div>
  <?php endif ?>
  <form method="POST" action="">
    <div class="mb-3">
      <label for="username" class="form-label">Username</label>
      <input type="text" class="form-control" name="username" id="username">
    </div>
    <div class="mb-3">
      <label for="password" class="form-label">Password</label>
      <input type="password" class="form-control" name="password" id="password">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
  </form>
</body>
</html>