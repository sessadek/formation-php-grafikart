<?php

use App\Table\CategoryTable;
use App\Table\PostTable;

$id = $match['params']['id'];
$slug = $match['params']['slug'];


$postTable = new PostTable();

$post = $postTable->find($id);
(new CategoryTable)->pushPosts([$post]);

if($slug !== $post->getSlug()) {
    $url = $router->url('post', ['id' => $id, 'slug' => $post->getSlug()]);
    header('Location:' . $url, true, 301);
    exit;
}

?><h1>Show Single Post</h1>


<h5 class="card-title"><?= $post->getName(); ?></h5>
<div class="text-muted"><?= $post->getCreatedAt()->format('d/m/Y H:i:s'); ?></div>
<?php if(!empty($post->getCategories())) : ?>
    <div>
        <?php foreach ($post->getCategories() as $category) : ?>
            <a class="badge text-bg-primary" href="<?= $router->url('category', ['slug' => $category->getSlug(), 'id' => $category->getID()]); ?>" role="button"><?= $category->getName(); ?></a>
        <?php endforeach ?>
    </div>
<?php endif ?>
<!-- <h6 class="card-subtitle mb-2 text-body-secondary">Card subtitle</h6> -->
<div class="card-text"><?= $post->getContent(); ?></div>
<!-- <a href="<?= $router->url('post', ['slug' => $post->getSlug(), 'id' => $post->getID()]); ?>" class="card-link">Savoir plus</a> -->
<!-- <a href="#" class="card-link">Another link</a> -->

