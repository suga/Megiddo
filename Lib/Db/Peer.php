<?php
/**
 * Class responsible for the control of repositories
 * @author Marco Antonio Sugamele
 * @version 01 Ago 2010
 */
interface Peer {

    /**
     * Constructor of the class must instantiate the Criteria
     */
    public function __construct();
    
    /**
     * Only returns a search result
     * @return Object
     */
    public function get();
    
    /**
     * Returns all search results
     * @return ArrayObject
     */
    public function findAll();

    /**
     * Returns the amount of results
     */
    public function amountResults();

    /**
     * Clears the search memory
     */
    public function clear();
    
    /**
     * Sort results in ascending order
     * @param string $field
     */
    public function orderByAsc($field);
    
    /**
     * Sort results in descending order
     * @param string $field
     */
    public function orderByDesc($field);
}
