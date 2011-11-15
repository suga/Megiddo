<?php
/**
 * Sql ORM class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 18/02/2011
 * Class responsible for mount Sql for ORM
 */
class SqlOrm {

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
    const WHERE = "WHERE";
    const ORDER_BY = "ORDER BY";
    const ASC = "ASC";
    const DESC = "DESC";

    /**
     * Initializes the class and instantiates the object PDO
     */
    public function __construct() {
        try {
            $this->pdo = new PDO(DNS, USER_DB, PASSWORD_DB);
        } catch (PDOException $e) {
            echo $e->getMessage();
            exit();
        }
    }

    /**
     * Select tables
     * @return stdClass
     */
    public function selectTables() {
        return $this->select($this->mountSqlSelectTables());
    }

    /**
     * Select Type
     * @return stdClass
     */
    public function selectType($table) {
        if (empty($table)) {
            return false;
        }
        return $this->select($this->mountSqlSelectType($table));
    }

    public function isPK($table, $columnName) {
        if (empty($columnName)) {
            return false;
        }
        return $this->select($this->mountSqlSelectPk($table, $columnName));
    }

    public function isFK($table, $columnName) {
        if (empty($columnName)) {
            return false;
        }
        return $this->select($this->mountSqlSelectFk($table, $columnName));
    }

    public function getTableFK($columnNameFk) {
        if (empty($columnNameFk)) {
            return false;
        }
        return $this->select($this->mountSqlGetTableFk($columnNameFk));
    }

    /**
     * Make a selectTables the database
     * @param string $sql
     * @return stdClass
     */
    private function select($sql) {
        /* @var $stdClass ArrayObject */
        $stdClass = new ArrayObject();
        try {
            $this->pdo->beginTransaction();
            $execute = $this->pdo->prepare($sql);
            $execute->execute();
            $this->pdo->commit();
            
            if ($execute->rowCount() == 0) {
                return false;
            }
            
            for ($i = 0; $i < $execute->rowCount(); $i++) {
                $stdClass[] = $execute->fetch(PDO::FETCH_OBJ);
            }
            
            if ($stdClass->count() == 0) {
                return false;
            }
            
            return $stdClass;
        } catch (PDOException $e) {
            $this->pdo->rollBack();
            return false;
        }
    }

    /**
     * Mount the Query selectTables
     * @return string
     */
    private function mountSqlSelectTables() {
        return self::SELECT . " tablename " . self::SELECT_FROM . " pg_tables " . self::WHERE . " schemaname = 'public' AND tablename NOT IN('log','culture','tag','tag_i18n') ";
    }

    /**
     * Mount the Query selectType
     * @return string
     */
    private function mountSqlSelectType($table) {
        return self::SELECT . "  column_name,data_type  " . self::SELECT_FROM . "  information_schema.columns  " . self::WHERE . " table_name = '" . $table . "'  ";
    }

    /**
     * Mount the Query isPk
     * @return string
     */
    private function mountSqlSelectPk($table, $columnName) {
        if (empty($columnName) || empty($table)) {
            return false;
        }
        return self::SELECT . "  table_name  " . self::SELECT_FROM . " information_schema.key_column_usage  " . self::WHERE . " table_name = '" . $table . "' AND column_name = '" . $columnName . "' AND position_in_unique_constraint IS NULL  ";
    }

    /**
     * Mount the Query isPk
     * @return string
     */
    private function mountSqlSelectFk($table, $columnName) {
        if (empty($columnName) || empty($table)) {
            return false;
        }
        return self::SELECT . "  table_name  " . self::SELECT_FROM . " information_schema.key_column_usage  " . self::WHERE . " table_name = '" . $table . "' AND column_name = '" . $columnName . "' AND position_in_unique_constraint = '1'  ";
    }

    private function mountSqlGetTableFk($columnNameFk) {
        if (empty($columnNameFk)) {
            return false;
        }
        
        return self::SELECT . "  table_name  " . self::SELECT_FROM . " information_schema.key_column_usage  " . self::WHERE . " column_name = '" . $columnNameFk . "' AND position_in_unique_constraint IS NULL  ";
    }

}
