
    /**
     * Checks if the [%doc%]  is valid
     * @param integer $[%variable%]
     * @return boolean
     */
    public function is[%nameMethod%]Valid($[%variable%] = null) {
        if (!is_integer($[%variable%])) {
            return false;
        }
        if (!empty($[%variable%])) {
            if (strlen($[%variable%]) > [%sizeMax%] || strlen($[%variable%]) < [%sizeMin%]) {
                return false;
            }
            return true;
        }
        
        if (strlen($this->[%variable%]) > [%sizeMax%] || strlen($this->[%variable%]) < [%sizeMin%]) {
            return false;
        }
        return true;
    }
    