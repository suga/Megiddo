
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
        if (!empty($this->[%variable%])) {
            $this->[%objLower%] = self::retriveByPk($this->[%variable%]);
        }
 
        if (!empty($this->[%variableFk%])) {
            $this->[%objLowerFk%] = [%objFk%]Base::retriveByPk($this->[%variableFk%]);
        }
        
        return $this->[%objLower%];
    }
    