
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
 
        return $this->[%objLower%];
    }
    