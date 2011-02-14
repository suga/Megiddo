
    /**
     * get the [%variable%]
     * @param Boolean $useFormat
     * @param String $format
     * @return String
     */
    public function get[%nameMethod%]( $useFormat = false, $format = 'd/m/Y') {
    	if($useFormat) {
    		$arrayDate = explode('-', $this->[%variable%]);
    		return $this->[%variable%] = date($format, mktime(0,0,0,$arrayDate[1],$arrayDate[2],$arrayDate[0]));
    	}else {
    		return $this->[%variable%];
    	}
    		
    }
    