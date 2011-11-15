
    /**
     * Checks if the [%doc%]  is valid
     * @param integer $[%variable%]
     * @return boolean
     */
    public function is[%nameMethod%]Valid($[%variable%] = null) {
        if (!empty($[%variable%]) && !is_numeric($[%variable%])) {
            return false;
        }
       
        return true;
    }
    