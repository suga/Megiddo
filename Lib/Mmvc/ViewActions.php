<?php
/**
 * ViewActions class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 12/02/2010
 * Page type that appears in the action
 * Last revision : 13/02/2010
 */
class ViewActions {

	const VIEW_NONE = 'NONE';
	const VIEW_ERROR = 'ERROR';
	const VIEW_SUCCESS = 'SUCCESS';
	
	/**
	 * When you do not want to display a template
	 * @return String
	 */
	public static function returnNone(){
		return VIEW_NONE;
	}
	
	/**
	 * View a template error
	 * @return String
	 */
    public static function returnError(){
        return VIEW_ERROR;
    }
	
	
}
