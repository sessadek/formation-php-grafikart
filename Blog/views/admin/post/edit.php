<?php

use App\HTML\Form;
use App\Helpers\Hydrate;
use App\Table\PostTable;
use App\Validator\PostValidator;

$id = (int)$match['params']['id'];
$postTable = new PostTable();
$post = $postTable->find($id);
$success = false;
$errors = [];
if(!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable, $post->getID());
    Hydrate::persistData($post, $_POST, ['name', 'slug', 'content', 'created_at']);
    if($v->validate()) {
        $postTable->update($post);
        $success = true;
    } else {
        // Errors
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
 

?>

<?php if(isset($_GET['created']) && $_GET['created'] === '1') :?>
    <div class="alert alert-success">L'article est bien été crée</div>
<?php endif ?>
<?php if($success) : ?>
    <div class="alert alert-success">L'article est bien été modifié</div>  
<?php endif ?>
<?php if(!empty($errors)) : ?>
    <div class="alert alert-danger">L'article n'a pas pu être modifié, merci de corriger  vos erreurs!!</div>
<?php endif ?>
<h1>Edit Post <?= $match['params']['id']; ?></h1>
<form action="<?= $router->url('adminPostEdit', ['id' => $post->getID()]); ?>" method="POST">
    <?= $form->text('name', 'Name'); ?>
    <?= $form->text('slug', 'Slug'); ?>
    <?= $form->textarea('content', 'Content'); ?>
    <?= $form->text('created_at', 'Created Date'); ?>
    <button type="submit" class="btn btn-success">Edit</button>
</form>