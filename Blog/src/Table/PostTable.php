<?php

namespace App\Table;

use Exception;
use App\Model\Post;
use App\Pagination;

final class PostTable extends Table {

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    protected $className = Post::class;

    /**
     * Undocumented variable
     *
     * @var string
     */
    protected $table = 'post';

    /**
     * Undocumented function
     *
     * @return array|null
     */
    public function findPaginated(): ?array {

        $pagination = new Pagination(
            "SELECT * FROM post ORDER BY created_at DESC",
            "SELECT COUNT(id) as count FROM post",
            $this->className,
            $this->pdo
        );
        $posts = $pagination->getItems();
        $this->hydratePosts($posts);
        return [$posts, $pagination];
    }

    /**
     * Undocumented function
     *
     * @param integer $category_id
     * @return array|null
     */
    public function findPaginatedByCategory(int $category_id): ?array {
        $pagination = new Pagination(
            "SELECT * FROM post_category pc INNER JOIN {$this->table} p ON pc.post_id = p.id WHERE pc.category_id = {$category_id} ORDER BY p.created_at DESC",
            "SELECT COUNT(post_id) as count FROM post_category WHERE category_id = {$category_id}",
            $this->className,
            $this->pdo
        );
        $posts = $pagination->getItems($this->className);
        $this->hydratePosts($posts);
        return [$posts, $pagination];
    }

    /**
     * Undocumented function
     *
     * @param \App\Model\Post[] $posts
     * @return void
     */
    public function hydratePosts(array $posts) {
        return (new CategoryTable())->pushPosts($posts);
    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @return void
     */
    public function update (Post $post) {
        $query = $this->pdo->prepare("UPDATE {$this->table} SET name = :name, slug = :slug, content = :content, created_at = :created_at  WHERE id = :id");
        $request = $query->execute([
            'id' => $post->getID(),
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        if($request === false) {
            throw(new Exception("Aucun article correspond cet id : {$post->getID()}"));
        }

    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @return void
     */
    public function insert (Post $post) {
        $query = $this->pdo->prepare("INSERT INTO {$this->table} (name, slug, content, created_at) VALUES(:name, :slug, :content, :created_at)");
        $request = $query->execute([
            'name' => $post->getName(),
            'slug' => $post->getSlug(),
            'content' => $post->getContent(),
            'created_at' => $post->getCreatedAt()->format('Y-m-d H:i:s')
        ]);
        if($request === false) {
            throw(new Exception("Aucun article correspond cet id : {$post->getID()}"));
        }
        $post->setID($this->pdo->lastInsertId());

    }

    /**
     * Undocumented function
     *
     * @param integer $id
     * @return void
     */
    public function delete (int $id) {
        $query = $this->pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        $request = $query->execute(['id' => $id]);
        if($request === false) {
            throw(new Exception("Aucun article correspond cet id : $id"));
        }

    }
}