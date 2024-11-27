<?php 

use App\Table\PostTable;

$title = 'Mon blog';

$postTable = new PostTable();

[$posts, $pagination] = $postTable->findPaginated();

?><h1>Listing articles</h1>

<?php if(isset($_GET['delete']) && $_GET['delete'] == '1') : ?>
    <div class="alert alert-success">L'article est bien été supprimé</div>
<?php endif ?>
<a href="<?= $router->url('adminPostAdd'); ?>" class="btn btn-primary">Ajouter un article</a>

<table class="table">
    <thead>
        <tr>
            <th>#ID</th>
            <th>Name</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
    <?php foreach($posts as $post) : ?>
        <tr>
            <td><?= $post->getID(); ?></td>
            <td><?= $post->getName(); ?></td>
            <td>
                <a href="<?= $router->url('adminPostEdit', ['id' => $post->getID()]); ?>" class="btn btn-success">Edit</a>
                <form class="d-inline" action="<?= $router->url('adminPostDelete', ['id' => $post->getID()]); ?>" method="POST">
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Voulez-vous vraiment supprimer ?');">Delete</button>
                </form>
            </td>
        </tr>
    <?php endforeach ?> 
    </tbody>
</table>
<?php
    $url = $router->url('adminPostList');
    if(!is_null($pagination->render($url))) {
        echo $pagination->render($url);
    }
?>