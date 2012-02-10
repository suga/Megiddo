<?php
/**
 * Report class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 27/04/2010
 * Last revision : 09/04/2011
 */
class Report {

    /**
     * The exhibition begins from that point
     * @var $limit Integer
     */
    private $limit = 1;

    /**
     * The exhibit goes so far
     * @var $offset Integer
     */
    private $offset = 0;

    /**
     * Total Records
     * @var Integer
     */
    private $totalRecords = 0;

    /**
     * Total Pages
     * @var Integer
     */
    private $totalPages = 1;

    /**
     * @var $currentPage Integer
     */
    private $currentPage = 1;

    /**
     * The exhibition begins from that point
     * @param Integer $limit
     */
    public function setLimit($limit) {
        $this->limit = (int)$limit;
    }

    /**
     * Amount to be displayed per page
     * @param Integer $offset
     */
    public function setOffset($offset) {
        $this->offset = (int)$offset;
    }

    /**
     * Set Current Page
     * @param Integer $page
     */
    public function setCurrentPage($page) {
        if (empty($page) || $page == 0) {
            $page = 1;
        }
        $this->currentPage = (int)$page;
        $this->offset = ($this->currentPage - 1) * $this->limit;
    }

    /**
     * Gets the paged results
     * @param Object $obj
     * @return ArrayObject $return
     */
    public function getResults($obj) {
        if (!is_object($obj)) {
            return false;
        }
        
        $criteria = new Criteria();
        $criteria->addNotWhere();
        $criteria->setLimit($this->limit);
        $criteria->setOffset($this->offset);
        $return = $obj->doSelect($criteria);
        $this->totalRecords = count($return);
        return $return;
    }

    /**
     * Filter the results by finding informative
     * @param Array $textSearch
     * @param Object $obj
     * @return ArrayObject $return
     */
    public function getResultsSearch($textSearch, $obj) {
        if (!is_object($obj)) {
            return false;
        }
        
        $return = $obj->getSearch($textSearch, $this->limit, $this->offset);
        $this->totalRecords = $obj->getTotalRecordsSearch($textSearch);
        return $return;
    }

    /**
     * Returns the total number of pages
     * @return Integer  
     */
    public function getTotalPages($totalRecords) {
        $limit = $this->limit;
        if ($limit == 0) {
            $limit = 1;
        }
        return $this->totalPages = (int)ceil($totalRecords / $limit);
    }

    /**
     * Return the total records
     * @return Integer
     */
    public function getTotalRecords() {
        return $this->totalRecords;
    }

    /**
     * Checks if the table row of the report should be colored
     * @param Integer $key
     * @return Boolean
     */
    public static function weColor($key) {
        if ($key % 2 != 0) {
            return true;
        }
        return false;
    }

    /**
     * Return Current Page
     * @return Integer
     */
    public function getCurrentPage() {
        return $this->currentPage;
    }

    /**
     * Return Next Page
     * @return Integer
     */
    public function nextPage() {
        $nextPage = $this->currentPage + 1;
        if ($nextPage > $this->totalPages) {
            $nextPage = $this->totalPages;
        }
        
        return $nextPage;
    }

    /**
     * Return Previous Page
     * @return Integer
     */
    public function previousPage() {
        $previousPage = $this->currentPage - 1;
        
        if ($previousPage == 0) {
            $previousPage = $this->currentPage;
        }
        
        return $previousPage;
    }

}
