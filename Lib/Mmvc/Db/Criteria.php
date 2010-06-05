<?php
/**
 * Criteria class
 * @author Otavio Luiz Carvalho <otaviolcarvalho@gmail.com>
 *
 * @since 03/01/2009
 * last revision 01/05/2010
 */
class Criteria {

    private $strWhere;

    private $join;

    private $orderBy;

    private $limit;

    private $offset;
    const EQUAL = '=';
    const GREATER_THAN = '>';
    const LESS_THAN = '<';
    const GREATER_EQUAL = '>=';
    const LESS_EQUAL = '<=';
    const NOT_EQUAL = "!=";
    const LIKE = 'LIKE';
    const NOT_LIKE = 'NOT LIKE';
    const ORDER_BY_DESC = 'DESC';
    const ORDER_BY_ASC = 'ASC';
    const INNER_JOIN = 'INNER JOIN';
    const LEFT_JOIN = 'LEFT JOIN';
    const RIGHT_JOIN = 'RIGHT JOIN';
    const OUTER_JOIN = 'OUTER JOIN';
    const JOIN_ON = 'ON';
    const COLUMN_TYPE = 1;
    private $modColumns = array();

    public function __construct() {
        $this->join = new ArrayObject();
    }

    /**
     * Mount the clausule where together(like,not like,>,<,>=,<=)
     * @param string $field - campo
     * @param string $value - valor
     * @param CriteriaCondition $condition - tipo da clausula
     *
     */
    public function add($field,$value,$condition = null,$type = null){
        $str = $this->getCondition($field, $value,$condition,$type);
        $str = ' AND ' . $str;

       $this->isWhere($str);
    }
        /**
     * Get teh condition and moutn the string
     * @param string $field - campo
     * @param string $value - valor
     * @param CriteriaCondition $condition - tipo da clausula>
     */
    private function getCondition($field,$value,$condition = null,$type = null){

        $condition = strtoupper($condition);
        // check type
        if(is_string($value) && $type != self::COLUMN_TYPE){
            $value = "'" . $value . "'";
        }
        switch($condition){
            case null:
            case self::EQUAL:
                $str = $field . self::EQUAL . $value;
                break;
            case Criteria::GREATER_THAN://maior que
                $str = $field .' '. self::GREATER_THAN .' '. $value ;
                break;
            case Criteria::LESS_THAN://menor que
                 $str = $field .' '. self::LESS_THAN .' '. $value ;
                break;
            case Criteria::GREATER_EQUAL://maior igual que
                 $str = $field .' '. self::GREATER_EQUAL .' '. $value ;
                break;
            case Criteria::LESS_EQUAL://menor igual que
                $str = $field .' '. self::LESS_EQUAL .' '. $value ;
                break;
            case Criteria::NOT_EQUAL:
                $str = $field .' '. self::NOT_EQUAL .' '. $value ;
                break;
             case Criteria::LIKE:
                $str = $field .' '. self::LIKE .' '. $value ;
                break;    
            default:
                $str = $field .' '. self::EQUAL .' '. $value ;
                break;
        }
        return $str;
    }
    /**
     * Mount the clausule or
     * @param string $field - campo
     * @param string $value - valor
     * @param CriteriaCondition $condition - tipo da clausula
     *
     */
    public function addOR($field,$value,$condition = null,$type=null){
        $str = $this->getCondition($field, $value,$condition,$type);
        $str = ' OR ' . $str;

       $this->isWhere($str);
    }
    /**
     * Add Order by
     * @param string $field
     */
    public function addOrderBy($field, $order) {
        $order = strtoupper($order);
        $order = $order != Criteria::ORDER_BY_ASC && $order != Criteria::ORDER_BY_DESC ? '' : $order;
        $this->orderBy = ' ORDER BY ' . $field . ' ' . $order;
    }

    /**
     * Add join(simples with where)
     * @todo usar as clausulas mais corretas para pode se usar left join etc
     * @param string $field
     * @param string $field2
     */
    public function addJoin($field, $field2) {
        /** @var $join ArrayObject **/
        $str = ' ' . self::JOIN_ON . ' ' . $field . self::EQUAL . ' ' . $field2;
        $actualJoinArray = $this->join->offsetGet($this->join->count() - 1);
        
        $onArrayObject = $actualJoinArray['join'][1];
        $onArrayObject->append($str);
    
    }

    /**
     * Add a table for join (simple)
     * @todo adicionar left, right, inner, outer join
     * @param string $tableName
     */
    public function addJoinTable($tableName, $typeJoin = '') {
        
        $typeJoin = strtoupper($typeJoin);
        
        switch ($typeJoin) {
            case self::LEFT_JOIN :
                $strJoin = ' ' . self::LEFT_JOIN . ' ' . $tableName;
                break;
            case self::RIGHT_JOIN :
                $strJoin = ' ' . self::RIGHT_JOIN . ' ' . $tableName;
                break;
            case self::OUTER_JOIN :
                $strJoin = ' ' . self::OUTER_JOIN . ' ' . $tableName;
                break;
            default :
                $strJoin = ' ' . self::INNER_JOIN . ' ' . $tableName;
        }
        /** @var $this->join ArrayObject **/
        $join = array('join' => array($strJoin, new ArrayObject()));
        $this->join->append($join);
        return $this;
    }

    /**
     * Mount and verify the variables strWhere is null or not
     * to mount the criteria correctly
     * @param string $field
     * @param string $value
     */
    private function isWhere($strCondition) {
        if (empty($this->strWhere)) {
            $this->strWhere = 'WHERE ' . $strCondition;
        } else {
            $this->strWhere .= $strCondition;
        }
    }

    /**
     * Return the WHERE
     * @return string
     *
     */
    public function get() {
        $where = $this->dry($this->strWhere);
        $join = $this->mountJoin();
        $limitOffSet = $this->mountLimitOffset();
        
        return $join . ' ' . $where . $this->orderBy . $limitOffSet;
    }

    /**
     * Mount the limit and offset
     * @return string
     */
    private function mountLimitOffset() {
        $limitOffset = '';
        if ($this->limit)
            $limitOffset = " LIMIT $this->limit";
        
        if ($this->offset)
            $limitOffset .= " OFFSET $this->offset";
        
        return $limitOffset;
    }

    /**
     * Mount the JOIN
     * @return string
     */
    private function mountJoin() {
        
        $iterator = $this->join->getIterator();
        while ($iterator->valid()) {
            $on = null;
            
            $joinArray = $iterator->current();
            $join .= $joinArray['join'][0];
            
            $onArrayObject = $joinArray['join'][1];
            $iteratorOn = $onArrayObject->getIterator();
            while ($iteratorOn->valid()) {
                $on .= $iteratorOn->current();
                $iteratorOn->next();
            }
            $join .= $on;
            $iterator->next();
        }
        return $join;
    }

    /**
     * Removes possibles chars incorrect
     * @param string
     * @return string
     */
    private function dry($where){
        $where = preg_replace("/AND $|OR $/i","",$where) ;
        $where = preg_replace("/WHERE.*?(AND|OR)/i","WHERE ",$where) ;
        return $where;
    }
    
    /**
     *
     * @param int $limit
     */
    public function setLimit($limit = null) {
        if (!is_null($limit)) {
            $this->limit = (int)$limit;
        }
    }

    /**
     *
     * @param int $offset
     */
    public function setOffset($offset) {
        $this->offset = (int)$offset;
    }
    /**
     * Set columns one by one, for create custom querys
     * @param string $name
     */
    public function setColumn($name){
        $this->modColumns[] = $name;
    }
    public function getColumns(){
        return $this->modColumns;
    }
    /**
     * Clear all Criteria
     *
     */
    public function clear() {
        unset($this->strWhere);
        unset($this->join);
        
        $this->join = new ArrayObject();
    }

    /**
     * @author Marco Antonio Sugamele <marco@iaol.com.br>
     * Not one where
     */
    private function isNotWhere() {
        $this->strWhere = '';
    }

    /**
     * @author Marco Antonio Sugamele <marco@iaol.com.br>
     * When we do not need one where the query
     */
    public function addNotWhere() {
        $this->isNotWhere();
    }
}

//$criteria = new Criteria();
//$criteria->add('conta.nome', "otavio");
//$criteria->add('conta.preco', "10", Criteria::GREATER_EQUAL);
//
//$criteria->addJoinTable('usuarios',Criteria::RIGHT_JOIN);
//$criteria->addJoin('usuario.usu_time', 'time_codigo');
//$criteria->setLimit('10');
//$criteria->setOffset('5');
//print_r($criteria->get());


?>
