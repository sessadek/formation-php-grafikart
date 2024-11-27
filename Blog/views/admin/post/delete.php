<?php

use App\Table\PostTable;

$postTable = new PostTable();
$id = (int)$match['params']['id'];
$postTable->delete($id);
$url = $router->url('adminPostList') . '?delete=1';
header('Location:' . $url, true, 301);
?>
