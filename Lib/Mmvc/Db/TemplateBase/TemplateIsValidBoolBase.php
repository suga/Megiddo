
    /**
     * Checks if the [%doc%]  is valid
     * @param bool $[%variable%]
     * @return boolean
     */
    public function is[%nameMethod%]Valid($[%variable%] = null) {
        if (!empty($[%variable%])) {
            return is_bool($[%variable%]);
        }
        
        return is_bool($this->[%variable%]);
        
    }
    