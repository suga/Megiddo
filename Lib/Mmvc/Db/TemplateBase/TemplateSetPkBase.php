
    /**
     * @param integer $[%variable%]
     * @param boolean $setObject
     * @return boolean
     */
    public function set[%nameMethod%]($[%variable%], $setObject = true) {       
        $this->[%variable%] = (int)$[%variable%];
        if (!$setObject) {
            return true;
        }
    }

    /**
     * Adds object [%obj%]
     * @param [%obj%] $[%objLower%]
     * @param Sql $instance
     */
    public function set[%obj%]([%obj%] $[%objLower%], $instance = null) {
        if(!$instance instanceof Sql){
    		$instance = $this->instanceSql();
        }
        $this->[%objLower%] = $[%objLower%];
        $this->set[%nameMethod%]($[%objLower%]->get[%nameMethod%](), $instance);
    }
    