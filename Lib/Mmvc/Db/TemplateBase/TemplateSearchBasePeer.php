
    /**
     * [%doc%]
     * Perform a search for the [%variable%]
     * @param [%type%] $[%variable%]
     * @return [%obj%]     
     */
    public function searchBy[%nameMethod%]($[%variable%]) {
        $this->criteria->add(self::[%constant%], $[%variable%]);
        return $this;
    }
