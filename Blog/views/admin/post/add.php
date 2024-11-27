<?php

use App\HTML\Form;
use App\Helpers\Hydrate;
use App\Model\Post;
use App\Table\PostTable;
use App\Validator\PostValidator;

$postTable = new PostTable();
$success = false;
$errors = [];
$post = new Post();
$post->setCreatedAt(date('Y-m-d H:i:s'));

if(!empty($_POST)) {
    $v = new PostValidator($_POST, $postTable);
    Hydrate::persistData($post, $_POST, ['name', 'slug', 'content', 'created_at']);
    if($v->validate()) {
        $postTable->insert($post);
        $url = $router->url('adminPostEdit', ['id' => $post->getID()]);
        header('Location:' . $url . '?created=1', true, 301);
    } else {
        // Errors
        $errors = $v->errors();
    }
}
$form = new Form($post, $errors);
 

?>
<?php if(!empty($errors)) : ?>
    <div class="alert alert-danger">L'article n'a pas pu être modifié, merci de corriger  vos erreurs!!</div>
<?php endif ?>
<h1>Add Post</h1>
<form action="<?= $router->url('adminPostAdd'); ?>" method="POST">
    <?= $form->text('name', 'Name'); ?>
    <?= $form->text('slug', 'Slug'); ?>
    <?= $form->textarea('content', 'Content'); ?>
    <?= $form->text('created_at', 'Created Date'); ?>
    <button type="submit" class="btn btn-success">Add</button>
</form>