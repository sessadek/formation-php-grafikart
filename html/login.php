<?php 
require 'functions.php';
$email = 'john@doe.fr';
$password = password_hash("root", PASSWORD_DEFAULT);
$errors = null;

if(isset($_POST) && !empty($_POST['exampleInputEmail1']) && !empty($_POST['exampleInputPassword1'])) {
    if($_POST['exampleInputEmail1'] === $email && password_verify($_POST['exampleInputPassword1'], $password)) {
        session_start();
        $_SESSION['is_connected'] = 1;
        header('Location: dashbord.php');
        die;
    } else {
        $errors = 'Identifiants incorrecte';
    }
}

require 'header.php'; 

?>
<?php if($errors) : ?>
    <div class="alert alert-danger">
        <?= $errors; ?>
    </div>
<?php endif?>
<form method="POST" action="<?= $_SERVER['PHP_SELF']?>">
  <div class="mb-3">
    <label for="exampleInputEmail1" class="form-label">Email address</label>
    <input type="email" class="form-control" name="exampleInputEmail1" id="exampleInputEmail1" aria-describedby="emailHelp">
    <div id="emailHelp" class="form-text">We'll never share your email with anyone else.</div>
  </div>
  <div class="mb-3">
    <label for="exampleInputPassword1" class="form-label">Password</label>
    <input type="password" class="form-control" name="exampleInputPassword1" id="exampleInputPassword1">
  </div>
  <div class="mb-3 form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Check me out</label>
  </div>
  <button type="submit" class="btn btn-primary">Submit</button>
</form>
<?php require 'footer.php'; ?>