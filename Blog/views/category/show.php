<?php

use App\Table\PostTable;
use App\Table\CategoryTable;

$id = $match['params']['id'];
$slug = $match['params']['slug'];

$categorieTable = new CategoryTable();

$categorie = $categorieTable->find($id);


if($slug !== $categorie->getSlug()) {
    $url = $router->url('category', ['slug' => $categorie->getSlug(), 'id' => $id]);
    header('Location:' . $url, true, 301);
    exit;
}

$postTable = new PostTable();
[$posts, $pagination] = $postTable->findPaginatedByCategory($categorie->getID());


$url = $router->url('category', ['slug' => $categorie->getSlug(), 'id' => $id]);
?><h1>Page Listing blog by category</h1>


<div class="row">
    <?php foreach($posts as $post) : ?>
        <div class="col-lg-3">
            <?php require dirname(__DIR__) .DIRECTORY_SEPARATOR .'post' . DIRECTORY_SEPARATOR . 'card.php'; ?>
        </div>
    <?php endforeach ?>
</div>

<?php
    if(!is_null($pagination->render($url))) {
        echo $pagination->render($url);
    }
?>