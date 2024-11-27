<?php

namespace App\Model;

class Category
{

    /**
     * Undocumented variable
     *
     * @var int
     */
    private $id;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $name;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $slug;

    /**
     * Undocumented function
     *
     * @param [mixed] $key
     * @return mixed
     */

     /**
      * Undocumented variable
      *
      * @var int
      */
    private $post_id;

    /**
     * Undocumented variable
     *
     * @var Post
     */
    private $post;

    /**
     * Undocumented function
     *
     * @param mixed $key
     * @return mixed
     */
    private function checkIsnull($key)
    {
        if (is_null($key)) {
            return null;
        }
        return $key;
    }

    /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function getID(): ?int
    {
        return $this->checkIsnull($this->id);
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->checkIsnull($this->name);
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getSlug(): ?string
    {
        return $this->checkIsnull($this->slug);
    }

    /**
     * Undocumented function
     *
     * @return integer|null
     */
    public function getPostID(): ?int
    {
        return $this->checkIsnull($this->post_id);
    }

    /**
     * Undocumented function
     *
     * @param Post $post
     * @return void
     */
    public function setPost(Post $post): void {
        $this->post = $post;
    }

}
