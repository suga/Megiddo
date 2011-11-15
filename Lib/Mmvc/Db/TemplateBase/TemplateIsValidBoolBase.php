
    /**
     * Checks if the [%doc%]  is valid
     * @param bool $[%variable%]
     * @return boolean
     */
    public function is[%nameMethod%]Valid($[%variable%] = null) {
        if (!empty($[%variable%])) {            
            if($[%variable%] !=0 || $[%variable%]!= 1){
            	return is_bool($[%variable%]);
            }
            return true;
        }
        
        return true;
        
    }
    