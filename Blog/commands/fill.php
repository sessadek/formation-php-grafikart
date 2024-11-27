<?php

use App\Connection;



// Report all PHP errors
ini_set('display_errors', 1);

require_once dirname(__DIR__) . DIRECTORY_SEPARATOR .'vendor' . DIRECTORY_SEPARATOR . 'autoload.php';

// use the factory to create a Faker\Generator instance


$faker = Faker\Factory::create();

$pdo = Connection::getPDO();

$pdo->exec('DELETE FROM post');
$pdo->exec('DELETE FROM category');
$pdo->exec('DELETE FROM post_category');
$pdo->exec('DELETE FROM user');

$posts = [];
$categories = [];

for($i = 0; $i < 50; $i++) {
    $pdo->exec("INSERT INTO post(name, slug, content, created_at) VALUES('{$faker->sentence()}', '{$faker->slug()}', '{$faker->paragraphs(rand(3,15), true)}', '{$faker->dateTime()->format('Y-m-d H:i:s')}')");
    $posts[] = $pdo->lastInsertId();
}

for($i = 0; $i < 5; $i++) {
    $pdo->exec("INSERT INTO category(name, slug) VALUES('{$faker->sentence(3)}', '{$faker->slug()}')");
    $categories[] = $pdo->lastInsertId();
}

$randomCategories = $faker->randomElements($categories, rand(0, count($categories)));

foreach($posts as $post) {
    $randomCategories = $faker->randomElements($categories, rand(0, count($categories)));
    foreach($randomCategories as $category) {
        $pdo->exec("INSERT INTO post_category(post_id, category_id) VALUES('$post', '$category')");
    }
}

$password = password_hash("admin", PASSWORD_BCRYPT);

$pdo->exec("INSERT INTO user(username, password) VALUES('admin', '$password')");