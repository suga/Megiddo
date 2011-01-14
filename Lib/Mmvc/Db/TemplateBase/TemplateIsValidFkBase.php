
    /**
     * Checks if the [%doc%] is valid
     * @param integer $[%variable%]
     * @return boolean
     */
    public function is[%nameMethod%]Valid($[%variable%] = null) {
        if (!empty($[%variable%])) {
            return is_integer($[%variable%]);
        }
        $obj = [%obj%]Base::retriveByPk($this->[%variable%]);
        return $obj instanceof [%obj%];
    }
    