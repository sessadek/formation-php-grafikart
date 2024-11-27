<?php 
$age = null;
if(isset($_POST['year']) && !empty($_POST['year'])) {
    setcookie('year', $_POST['year']);
    $_COOKIE['year'] = $_POST['year'];
}

if(isset($_COOKIE['year']) && !empty($_COOKIE['year']) ) {
    $age = (int) date('Y') - (int) $_COOKIE['year'];
}

if(isset($_COOKIE['counter']) && !empty($_COOKIE['counter'])) {
    $counter = $_COOKIE['counter'];
    $counter++;
    setcookie('counter', $counter, time() + 60*60*24*30);
    $_COOKIE['counter'] = $counter;
}
setcookie('counter', 1, time() + 60*60*24*30);
$_COOKIE['counter'] = 1;
$counter = $_COOKIE['counter'];


echo '<pre>';
var_dump($_COOKIE);
echo '</pre>';
require 'header.php'; 

?>
<form action="/profile.php" method="post">
    <select name="year" id="">
        <?php for($i=2010;$i > 1919;$i--) : ?>
            <option value="<?= $i; ?>"><?= $i; ?></option>
        <?php endfor ?>
    </select>
    <input type="submit" value="envoyer">
</form>
<?php if(isset($_COOKIE['year']) && !empty($_COOKIE['year']) ) : ?>
    <?php if($age>= 18) : ?>
        <div>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Exercitationem iure recusandae eaque aut nobis perspiciatis dolore quidem minus ipsa in doloribus aliquam ea impedit illum, maiores provident, quasi sequi! Est.</div>
    <?php else : ?>
        <div class="alert alert-danger">Vous etes pas autorisé !!!</div>
    <?php endif ?>
<?php endif ?>
<?php require 'footer.php'; ?>