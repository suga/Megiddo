
    /**
     * @param integer $[%variable%]
     * @param Sql $instance
     * @throws InvalidsArguments
     */
    public function set[%nameMethod%]($[%variable%]) {    	
        $this->[%variable%] = (int)$[%variable%];                
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
    