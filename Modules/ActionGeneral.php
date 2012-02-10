<?php
/**
 * This is action is performed before any other action to make it possible to centralize certain actions as setagem culture and check login.
 * @author marco
 * @since 02/04/2010
 * Control template
 * Last revision : 02/04/2010
 * 
 */
class ActionGeneral extends Url {

	public function executeCulture(Content &$objContent){
		$objCulture = new Culture();
		$culture = $objCulture->checkCulture($this->getRequestParameter('isolang'));
		$objContent->getObjCulture()->setCulture($culture);
		$module = $this->getRequestParameter('module');
		$action = $this->getRequestParameter('action');
		$this->redirectIndoor($module,$action);
	}
}