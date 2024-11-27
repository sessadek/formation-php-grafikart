<?php

namespace App\Table;

use App\Model\Category;
use PDO;

/**
 * Undocumented class
 */
final class CategoryTable extends Table {

    protected $className = Category::class;

    protected $table = 'category';

    /**
     * Undocumented function
     *
     * @param \App\Model\Post[] $posts
     * @return void
     */
    public function pushPosts(array $posts): void {
        $postByID = [];

        foreach($posts as $post) {
            $postByID[$post->getID()] = $post;
        }

        $categories = $this->pdo->query("SELECT c.*, pc.post_id
        FROM category c
        JOIN post_category pc ON c.id = pc.category_id
        WHERE pc.post_id IN (" . implode(', ', array_keys($postByID)) . ")")->fetchAll(PDO::FETCH_CLASS, Category::class);

        foreach($categories as $category) {
            $postByID[$category->getPostID()]->addCatgory($category);
        }
    }
}