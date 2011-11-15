<?php
/**
 * Repository - [%doc%]
 * @author Mmvc - Base Criator
 * @version [%date%]
 */
class [%nameClassPeer%] extends [%nameClassBase%] implements Peer {

    private  $criteria;

    public function __construct() {
        $this->criteria = new Criteria();
    }

    [%searchBy%]

    /**
     * Sort results in descending order
     * @param string $field
     */
    public function orderByDesc($field) {
        $this->criteria->addOrderBy($field, Criteria::ORDER_BY_DESC);
    }

    /**
     * Sort results in descending order
     * @param string $field
     */
    public function orderByAsc($field) {
        $this->criteria->addOrderBy($field, Criteria::ORDER_BY_ASC);
    }

    /**
     * Only returns a search result
     * @return [%obj%]
     */
    public function get() {
        return $this->doSelectOne($this->criteria);
    }

    /**
     * Returns all search results
     * @return ArrayObject
     */
    public function findAll() {
        return $this->doSelect($this->criteria);
    }

    /**
     * Returns the amount of results
     */
    public function amountResults() {
        $this->criteria->addNotWhere();
        return $this->getTotalRecords($this->criteria);
    }
    
    /**
     * @param integer $limit
     */
    public function setLimit($limit = null) {
    	$this->criteria->setLimit($limit);
    }
    
	/**
     *
     * @param integer $offset
     */
    public function setOffset($offset = null) {
        $this->criteria->setOffset ($offset);
    }

    /**
     * Clears the search memory
     */
    public function clear() {
        $this->criteria->clear();
    }
}
