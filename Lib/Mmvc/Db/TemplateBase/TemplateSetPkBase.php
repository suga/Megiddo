
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
        
        $obj = self::retriveByPk($[%variable%]);
        if (!$obj instanceof [%obj%] || !self::is[%nameMethod%]Valid()) {
            throw new InvalidsArguments((__FILE__), 'The [%obj%] ID (' . $[%variable%] . ') is invalid');
        }
        
        $this->[%objLower%] = $obj;
    }

    /**
     * Adds object [%obj%]
     * @param [%obj%] $[%objLower%]
     */
    public function set[%obj%]([%obj%] $[%objLower%]) {
        $this->[%objLower%] = $[%objLower%];
        $this->set[%nameMethod%]($[%objLower%]->get[%nameMethod%]());
    }
    