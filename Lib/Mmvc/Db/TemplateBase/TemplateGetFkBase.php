
    /**
     * get the [%variable%]
     * @return [%type%]
     */
    public function get[%nameMethod%]() {
        return $this->[%variable%];
    }
    
    /**
     * Get Object [%obj%]
     * @return [%obj%]
     */
    public function get[%obj%]() {
        if ($this->[%objLower%] instanceof [%obj%]) {
            return $this->[%objLower%];
        }
        
        if (!empty($this->[%variable%])) {
            $this->[%objLower%] = [%obj%]Base::retriveByPk($this->[%variable%]);
            return $this->[%objLower%];
        }
    }