
    /**
     * Checks if the [%doc%] is valid
     * @param integer $[%variable%]
     * @param Sql $instance
     * @return boolean
     */
    public function is[%nameMethod%]Valid($[%variable%] = null, $instance = null) {
        if(!$instance instanceof Sql){
    		$instance = $this->instanceSql();
        }
        if (!empty($[%variable%])) {
            return is_integer($[%variable%]);
        }
        $obj = self::retriveByPk($this->[%variable%], $instance);
        return $obj instanceof [%obj%];
    }
    