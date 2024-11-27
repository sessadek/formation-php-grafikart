<?php

namespace App\Model;

use DateTime;
use App\Helpers\Text;

class Post
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
     * Undocumented variable
     *
     * @var string
     */
    private $content;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private $created_at;

    /**
     * Undocumented function
     *
     * @return string
     */

    /**
     * Undocumented function
     *
     * @return array
     */
    
    private $categories = [];

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
     * @param integer $id
     * @return self
     */
    public function setID(int $id): self
    {
        $this->id = $id;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getName(): ?string
    {
        if (is_null($this->content)) {
            return null;
        }
        return htmlentities($this->name);
    }

    /**
     * Undocumented function
     *
     * @param string $name
     * @return self|null
     */
    public function setName(string $name): ?self
    {
        $this->name = $name;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return string|null
     */
    public function getContent(): ?string
    {
        if (is_null($this->content)) {
            return null;
        }
        return htmlentities($this->content);
    }

    public function setContent(string $content): self
    {
        $this->content = $content;
        return $this;
    }


    /**
     * Undocumented function
     *
     * @return string
     */
    public function getExcerpt(): ?string
    {
        if (is_null($this->content)) {
            return null;
        }
        return Text::truncateString($this->getContent());
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

    public function setSlug(string $slug): self {
        $this->slug = $slug;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        if (is_null($this->created_at)) {
            return null;
        }
        return new DateTime($this->created_at);
    }

    /**
     * Undocumented function
     *
     * @param string $created_at
     * @return self
     */
    public function setCreatedAt(string $created_at): self {
        $this->created_at = $created_at;
        return $this;
    }

    /**
     * Undocumented function
     *
     * @param Category $category
     * @return void
     */
    public function addCatgory(Category $category): void {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    /**
     * Undocumented function
     *
     * @return Category[]|null
     */
    public function getCategories(): ?array {
        return $this->checkIsnull($this->categories);
    }
}
