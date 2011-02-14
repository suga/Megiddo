
    /**
     * Set the [%doc%]
     * @param [%type%] $[%variable%]
     * @param Boolean $useFormat
     * @param String $format 
     */
    public function set[%nameMethod%]($[%variable%], $useFormat = false, $format = 'Y-m-d', $delimiter = '/') {
    	if($useFormat) {
    		$[%variable%] = str_replace($delimiter, '-', $[%variable%]);
    		$arrayDate = explode('-', $[%variable%]);
    		$[%variable%] = date($format, mktime(0,0,0,$arrayDate[1],$arrayDate[0],$arrayDate[2]));    		
    	}
    	       
        $this->[%variable%] =  $[%variable%];        
    }