<?php 

use App\Table\PostTable;


$title = 'Admin';


$postTable = new PostTable();
[$posts, $pagination] = $postTable->findPaginated();

?>
<h1>Page Listing blog</h1>
<div class="row">
    <?php foreach($posts as $post) : ?>
        <div class="col-lg-3">
            <?php require 'card.php'; ?>
        </div>
    <?php endforeach ?>
</div>

<?php
    $url = $router->url('home');
    if(!is_null($pagination->render($url))) {
        echo $pagination->render($url);
    }
?>