<?php
/**
 * Base - [%doc%]
 * @author Mmvc - Base Criator
 * @version [%date%]
 */

class [%nameClass%] extends AbstractBase implements Base {

    /**
     * @var string
     */
    const TABLE = '[%table%]';    
    [%consts%]
    
 	/**
     * Instance Sql
     * @var Sql
     */
    private $instanceSql;
    
    /**
     * Instance Sql
     * @return Sql
     */
    protected function instanceSql() {
    	if(!$this->instanceSql instanceof Sql) {
    		$this->instanceSql = new Sql();
    	}
    	return $this->instanceSql;
    }
    
    [%privates%]
    
    [%sets%]
    
    [%gets%]
    
    /**
     * Returns information from the database
     * @param Criteria $criteria
     * @param Sql $instance
     * @return Array
     */
    public function doSelect(Criteria $criteria , $instance = null) {
    	if(!$instance instanceof Sql){
    		$instance = $this->instanceSql();
        }
        $stdClass = $instance->select($criteria, self::TABLE, false);
        return !$stdClass ? false : $this->ConvertingArrayObject($stdClass, $instance);
    }

    /**
     * Returns only one information database
     * @param Criteria $criteria
     * @param Sql $instance
     * @return ArrayObject
     */
    public function doSelectOne(Criteria $criteria, $instance = null) {
    	if(!$instance instanceof Sql){
    		$instance = $this->instanceSql();
        }
        $stdClass = $instance->select($criteria, self::TABLE, true);
        return !$stdClass ? false : $this->ConvertingObject($stdClass, $instance);
    }
    
    [%save%]
    
    [%delete%]
    
    [%ConvertingObject%]
    
    /**
     * Converts the object to the object class 
     * @param $arrayStdClass
     * @param Sql $instance
     * @return ArrayObject
     */
    private function ConvertingArrayObject(ArrayObject $arrayStdClass, $instance = null) {
    	if(!$instance instanceof Sql){
    		$instance = $this->instanceSql();
        }
    	$peer = new ArrayObject();
        foreach ($arrayStdClass as $key => $objStdClass) {
            $obj = $this->ConvertingObject($objStdClass, $instance);
            $peer[] = $obj;
        }
        return $peer;
    }
    
    
    [%retrive%]
    
    /**
     * Retrive total Records
     */
    public static function getTotalRecords($criteria = null) {
        $repository = new [%nameClassPeer%]();
    	$allResults = $repository->findAll();
        return $allResults->count();
    }
    
    [%validates%]
}    