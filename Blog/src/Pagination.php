<?php 

namespace App;

use PDO;
use stdClass;

class Pagination {

    /**
     * Undocumented variable
     *
     * @var string
     */
    private string $query;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private string $queryCount;

    /**
     * Undocumented variable
     *
     * @var string
     */
    private string $classMapping;

    /**
     * Undocumented variable
     *
     * @var PDO
     */
    private PDO $pdo;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private int $perPage;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private int $count;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private int $pages;

    /**
     * Undocumented variable
     *
     * @var integer
     */
    private $currentPage;

    /**
     * Undocumented variable
     *
     * @var [type]
     */
    private $items = null;

    /**
     * Undocumented function
     *
     * @param string $query
     * @param string $queryCount
     * @param string $classMapping
     * @param PDO|null $pdo
     * @param integer $perPage
     */
    public function __construct(string $query, string $queryCount, string $classMapping, ?PDO $pdo = null, int $perPage = 12)
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->classMapping = $classMapping;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->perPage = $perPage;
    }

    /**
     * Undocumented function
     *
     * @return array
     */
    public function getItems(): array {

        if(is_null($this->items)) {

            $this->currentPage = URL::getPositiveInt('page', 1);

            $this->count = (int)$this->pdo->query($this->queryCount)->fetch(PDO::FETCH_NUM)[0];

            $this->pages = $this->count >= $this->perPage ? ceil($this->count / $this->perPage) : 1;

            URL::hasRequestUrlPage($this->pages, 'page');

            $offset = $this->perPage * ($this->currentPage - 1);

            $this->items = $this->pdo->query($this->query." LIMIT {$this->perPage} OFFSET $offset")->fetchAll(PDO::FETCH_CLASS, $this->classMapping);
        }
        return $this->items;
    }

    public function render (string $url): ?string {
        if ($this->pages < 2) {
            return null;
        }
        
        $html = "<nav aria-label='...'><ul class='pagination justify-content-center'><li class='page-item ";
        if($this->currentPage <= 1 ) {
            $html .= ' disabled';
        }
        $html .="'><a class='page-link' href=$url";
        if($this->currentPage > 2) {
            $html .= "?page=" . ($this->currentPage <= 1 ? 1 : $this->currentPage - 1);
        }
        $html .= ">Previous</a></li>";

        for($i = 1; $i <= $this->pages; $i++) {
            $html .= "<li class='page-item'><a class='page-link ".($this->currentPage !== $i ?: ' active " aria-current="page') ."' href='$url?page=$i'>$i</a></li>";
        }

        $html .= "<li class='page-item ";
        if($this->currentPage >= $this->pages ) {
            $html .= ' disabled';
        }
        $html .="'><a class='page-link' href=$url?page=";
        if($this->currentPage <= $this->pages) {
            $html .= $this->currentPage >= $this->pages ? $this->pages : $this->currentPage + 1;
        }
        $html .= ">Next</a></li></ul></nav>";
        return $html;
    }

}