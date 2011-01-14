
    /**
     * @param integer $[%variable%]
     * @throws InvalidsArguments
     */
    public function set[%nameMethod%]($[%variable%]) {
        $this->[%variable%] = (int)$[%variable%];
        $obj = [%obj%]Base::retriveByPk($[%variable%]);
        if ($obj instanceof [%obj%]) {
            $this->[%objLower%] = $obj;
        }        
    }

    /**
     * Adds object [%obj%]
     * @param [%obj%] $[%objLower%]
     */
    public function set[%obj%]([%obj%] $[%objLower%]) {
        $this->[%objLower%] = $[%objLower%];
        $this->set[%nameMethod%]($[%objLower%]->get[%nameMethod%]());
    }
    