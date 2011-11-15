
    /**
     * Checks if the [%doc%]  is valid
     * @param String $[%variable%]
     * @return boolean
     */
    public function is[%nameMethod%]Valid($[%variable%] = null) {
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
    