<?php
/**
 * Sql class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 13/02/2010
 * Class responsible for mount Sql
 * Last revision : 02/05/2010 
 */
class Sql {

    /**
     * 
     * @var PDO
     */
    private $pdo;

    /**
     * 
     * @var string $table
     */
    private $table;
    
    const SELECT = "SELECT";
    const SELECT_FROM = "FROM";
    const INSERT = "INSERT INTO";
    const VALUES = "VALUES";
    const UPDATE = "UPDATE";
    const SET = "SET";
    const WHERE = "WHERE";
    const DELETE = "DELETE FROM";

    /**
     * Initializes the class and instantiates the object PDO
     */
    public function __construct() {
        $this->pdo = new PDO(DNS, USER_DB, PASSWORD_DB);
    }

    /**
     * Make a select the database
     * @param Criteria $criteria
     * @param string $table
     * @param bollean $limitOne
     * @return bollean
     */
    public function select(Criteria $criteria, $table, $limitOne = false) {
        if ($limitOne) {
            $criteria->setLimit(1);
        } else {
            $stdClass = new ArrayObject();
        }
        if (empty($table)) {
            return false;
        }
        $this->table = $table;
        
        try {
            $this->pdo->beginTransaction();
            $execute = $this->pdo->prepare($this->mountSqlSelect($criteria));
            $execute->execute();
            $this->pdo->commit();
            if ($execute->rowCount() == 0) {
                return false;
            }
            if ($limitOne) {
                $stdClass = $execute->fetch(PDO::FETCH_OBJ);
            } else {
                for ($i = 0; $i < $execute->rowCount(); $i++) {
                    $stdClass[] = $execute->fetch(PDO::FETCH_OBJ);
                }
            }
            return $stdClass;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * make a insert the database
     * @param array $array
     * @param string $table
     * @return bollean
     */
    public function insert(array $array, $table) {
        if (empty($array) || empty($table)) {
            return false;
        }
        
        $this->table = $table;
        
        return $this->executePdo($this->mountSqlInsert($array));
    }

    /**
     * make a update the database
     * @param array $array
     * @param string $table
     * @param array $pk
     * @return bollean
     */
    public function update(array $array, $table, array $pk) {
        if (empty($array) || empty($table) || empty($pk)) {
            return false;
        }
        
        $this->table = $table;
        
        return $this->executePdo($this->mountSqlUpdate($array, $pk));
    }

    /**
     * Deletes the information from the database
     * @param string $table
     * @param array $pk
     * @return bollean
     */
    public function delete($table, array $pk) {
        if (empty($table) || empty($pk)) {
            return false;
        }
        
        $this->table = $table;
        
        return $this->executePdo($this->mountSqlDelete($pk));
    }

    /**
     * Mount the Query select
     * @param Criteria $criteria
     * @return string
     */
    private function mountSqlSelect(Criteria $criteria) {
        return self::SELECT . " * " . self::SELECT_FROM . " " . $this->table . $criteria->get();
    }

    /**
     * Mount the Query insert
     * @param array $array
     * @return string
     */
    private function mountSqlInsert(array $array) {
        if (empty($array)) {
            return false;
        }
        $mountFields = "(";
        $mountValues = "(";
        foreach ($array as $field => $value) {
            if (!is_null($value)) {
                $mountFields .= $field . ",";
                $mountValues .= "'$value'" . ",";
            }
        }
        $mountFields = preg_replace("/,$/i", "", $mountFields);
        $mountValues = preg_replace("/,$/i", "", $mountValues);
        $mountFields .= ")";
        $mountValues .= ")";
        
        return self::INSERT . " " . $this->table . " " . $mountFields . " " . self::VALUES . " " . $mountValues;
    
    }

    /**
     * Mount the Query update
     * @param array $array
     * @param array $pk
     * @return string
     */
    private function mountSqlUpdate(array $array, array $pk) {
        if (empty($array) || empty($pk)) {
            return false;
        }
        
        $mountFields = " ";
        foreach ($array as $field => $value) {
            if (!is_null($value)) {
                $mountFields .= $field . " = '$value'" . ",";
            }
        }
        $mountFields = preg_replace("/,$/i", "", $mountFields);
        $mountFields .= " ";
        
        foreach ($pk as $field => $value) {
            $fieldWhere = $field;
            $valueWhere = $value;
        }
        
        return self::UPDATE . " " . $this->table . " " . self::SET . $mountFields . " " . self::WHERE . " " . $fieldWhere . " = " . "\"$valueWhere\"";
    
    }

    /**
     * Mount the Query delete
     * @param array $pk
     * @return string
     */
    private function mountSqlDelete(array $pk) {
        if (empty($pk)) {
            return false;
        }
        
        foreach ($pk as $field => $value) {
            $fieldWhere = $field;
            $valueWhere = $value;
        }
        
        return self::DELETE . " " . $this->table . " " . self::WHERE . " " . $fieldWhere . " = " . "\"$valueWhere\"";
    }

    /**
     * Constructs query to count records from the table
     */
    private function mountCount($criteria = null) {
        if (!is_null($criteria) && !$criteria instanceof Criteria) {
            return false;
        }
        $criteria = is_null($criteria) ? '' : $criteria->get();
        return self::SELECT . " count(*) as totalRecords " . self::SELECT_FROM . " " . $this->table . $criteria;
    }

    /**
     * Returns the number of records in the table
     * @param String $table
     */
    public function count($table, $criteria = null) {
        if (empty($table)) {
            return false;
        }
        $this->table = $table;
        
        try {
            $this->pdo->beginTransaction();
            $execute = $this->pdo->prepare($this->mountCount($criteria));
            $execute->execute();
            $this->pdo->commit();
            if ($execute->rowCount() == 0) {
                return false;
            }
            
            $stdClass = $execute->fetch(PDO::FETCH_OBJ);
            
            return $stdClass;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * Running SQL commands through pdo
     * @param string $query
     */
    private function executePdo($query) {
        try {
            $this->pdo->beginTransaction();
            $execute = $this->pdo->prepare($query);
            $execute->execute();
            $this->pdo->commit();
            return true;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }
}
