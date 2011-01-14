
    /**
     * Save or edit the information in the Database
     * @return bollean
     */
    public function save() {
        $data = array(
                        [%fields%]);
        $sql = new Sql();
        
        $instance = self::retriveByPk($this->[%variable%]);
        $instance = $instance instanceof [%className%];
        
        if (is_null($this->[%variable%]) || !$instance) {
            $sql->insert($data, self::TABLE);
            $this->[%variable%] = $sql->lastRow(self::TABLE)->[%variableSQL%];
            [%fk%]
            return true;
        } else {
            $pk = array(
                            self::[%constant%] => $this->[%variable%]);
            
            return $sql->update($data, self::TABLE, $pk);
        }
    
    }