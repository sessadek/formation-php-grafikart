<?php


ini_set('display_errors', 1);

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';
use App\URLHelper;
use App\NumberHelper;

define('PER_PAGE', 20);


try {
    // Connect to the SQLite Database.

    $driver = 'sqlite';
    $db = dirname(__DIR__) . DIRECTORY_SEPARATOR .'products.sql';
    $host = $driver . ':' . $db;
    
    $pdo = new PDO('sqlite:../products.sql', null, null, [
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ]);
    $params = [];



    $builder = new App\QueryBuilder($pdo);
    $query = $builder->from('products');

    $sortable = ['id', 'name', 'price', 'address', 'city'];

    if(!empty($_GET['q'])) {
        $query
        ->where('city LIKE :city')
        ->setParam('city', '%' . $_GET['q'] . '%');
    }


    if(!empty($_GET['sort']) && in_array($_GET['sort'], $sortable)) {
        $query->orderBy($_GET['sort'], $_GET['dir'] ?? 'asc');
    }


    $count = (clone $query)->count();

    $page = $_GET['p'] ?? 1;
    $query
        ->page($page);

    dump($query);

    // $count = $query->count();


    $products = $query->fetchAll();




    $pages = (int)ceil($count / PER_PAGE);

    dump($pages);

} catch(Exception $e) {
    die('connection_unsuccessful: ' . $e->getMessage());
}






?><html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.84.0">
  <title>Page Title</title>

  <link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/starter-template/">

  

  <!-- Bootstrap core CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/5.0/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/5.0/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/5.0/assets/img/favicons/safari-pinned-tab.svg" color="#7952b3">
<link rel="icon" href="/docs/5.0/assets/img/favicons/favicon.ico">
<meta name="theme-color" content="#7952b3">



  
  <!-- Custom styles for this template -->
  <link href="starter-template.css" rel="stylesheet">
</head>
<body>
    <main>
        <div class="container">
            <form action="">
                <div class="mb-3">
                    <label for="q" class="form-label">query</label>
                    <input type="text" class="form-control" name="q" id="q" value="<?= htmlentities($_GET['q'] ?? null); ?>" placeholder="Recherche...">
                </div>
                <button type="submit" class="btn btn-primary">Search</button>
            </form>
            <table class="table">
                <thead>
                    <tr>
                    <th scope="col"><?= App\TableHelper::sort('id', 'ID', $_GET); ?></th> <!-- <a href="#"> -->
                    <th scope="col"><?= App\TableHelper::sort('name', 'Nom', $_GET); ?></th>
                    <th scope="col"><?= App\TableHelper::sort('price', 'Prix', $_GET); ?></th>
                    <th scope="col"><?= App\TableHelper::sort('city', 'Ville', $_GET); ?></th>
                    <th scope="col"><?= App\TableHelper::sort('address', 'Adresse', $_GET); ?></th>
                    </tr>
                    <a href="?&sort=id&dir=asc">ID</a>
                </thead>
                <tbody>
                    <?php foreach($products as $product) : ?>
                        <tr>
                            <th scope="row"><?= $product['id']; ?></th>
                            <td><?= $product['name']; ?></td>
                            <td><?= NumberHelper::price($product['price']); ?></td>
                            <td><?= $product['city']; ?></td>
                            <td><?= $product['address']; ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
            <div class="text-center">
                    <?php if($pages > 1 && $page > 1) : ?>
                        <a href="?<?= URLHelper::withParam('p', $page - 1, $_GET); ?>" class="btn btn-primary">Page Précédent</a>
                    <?php endif ?>
                    <?php if($pages > 1 && $page < $pages) : ?>
                        <a href="?<?= URLHelper::withParam('p', $page + 1, $_GET); ?>" class="btn btn-primary">Page Suivant</a>
                    <?php endif ?>
                </div>
        </div>
    </main>
  <footer class="pt-5 my-5 text-muted border-top">
  </footer>


<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
      
  </body>
</html>
