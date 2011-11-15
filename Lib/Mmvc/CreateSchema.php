<?php
/**
 * This class is responsible for creating Schema
 * @author Marco Antonio Sugamele
 * @since 19 fev 2011
 */
class CreateSchema {

    /**
     * @return array
     */
    private function mountSchema() {
        $sqlOrm = new SqlOrm();
        $tables = $sqlOrm->selectTables();
        $arrayTables = array();
        $arraySchema = array();
        foreach ($tables as $table) {
            $columns = $sqlOrm->selectType($table->tablename);
            $arraySchema['$doc$'] = 'Class ' . $this->returnClassName($table->tablename);
            foreach ($columns as $stdClass) {
                $pk = $sqlOrm->isPK($table->tablename, $stdClass->column_name);
                if (!$pk) {
                    
                    $arraySchema[$stdClass->column_name] = array(
                                    'doc' => 'Field', 
                                    'type' => $stdClass->data_type);
                    
                    $fk = $sqlOrm->isFK($table->tablename, $stdClass->column_name);
                    if (!$fk) {
                        $arraySchema[$stdClass->column_name] = array(
                                        'doc' => 'Field', 
                                        'type' => $stdClass->data_type);
                        continue;
                    }
                    
                    $tableFk = $sqlOrm->getTableFK($stdClass->column_name);
                    foreach ($tableFk as $stdFk) {
                        $arraySchema[$stdClass->column_name] = array(
                                        'doc' => 'Field', 
                                        'type' => 'fk', 
                                        'obj' => $this->returnClassName($stdFk->table_name));
                    }
                    continue;
                }
                $arraySchema[$stdClass->column_name] = array(
                                'doc' => 'Field', 
                                'type' => 'pk', 
                                'obj' => $this->returnClassName($table->tablename));
            }
            
            $arrayTables[$table->tablename] = $arraySchema;
            $arraySchema = array();
        }
        return $arrayTables;
    }

    /**
     * Generates the name of Class
     * @param string $table
     * @return String
     */
    private function returnClassName($table) {
        $class = '';
        $className = explode('_', $table);
        if (count($className) <= 1) {
            $class = ucfirst($className[0]);
        }
        
        if (count($className) > 1) {
            foreach ($className as $name) {
                $class .= ucfirst($name);
            }
        }
        return $class;
    }

    public function createSchema() {
        $dumper = new sfYamlDumper();
        $yaml = $dumper->dump($this->mountSchema(), 4);
        WriteToFile::writeContent($yaml, PATH_CONFIG, 'schemaTemp.yml');
    }
}
