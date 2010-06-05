<?php
/**
 * Headers class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 16/05/2010
 * Read through the template
 * Last revision : 16/05/2010
 */
class TemplateRead {

    private $pathTemplate;

    private $pathLayout;

    private $templateContent;

    private $templateContentLayout;

    private $templateMerge;

    /**
     * Set the path of the template
     * @param String $pathTemplate
     */
    public function setPathTemplate($pathTemplate) {
        if (!$this->checkFilesExists($pathTemplate)) {
            return false;
        }
        $this->pathTemplate = $pathTemplate;
    }

    /**
     * Takes the path of the template
     * @return String
     */
    public function getPathTemplate() {
        return $this->pathTemplate;
    }

    /**
     * Set the path of the layout
     * @param String $pathLayout
     */
    public function setPathLayout($pathLayout) {
        if (!$this->checkFilesExists($pathLayout)) {
            return false;
        }
        $this->pathLayout = $pathLayout;
    }

    /**
     * Takes the path of the layout
     * @return String
     */
    public function getPathLayout() {
        return $this->pathLayout;
    }

    /**
     * Sets the template content
     * @param String $content
     */
    private function setContentTemplate($content) {
        $this->templateContent = $content;
    }

    /**
     * Sets the layout content
     * @param String $content
     */
    private function setContentLayout($content) {
        $this->templateContentLayout = $content;
    }

    /**
     * takes the contents of the template
     * @return String
     */
    private function getContentTemplate() {
        if (empty($this->templateContent)) {
            return null;
        }
        return $this->templateContent;
    }

    /**
     * takes the contents of the layout
     * @return String
     */
    private function getContentLayout() {
        if (empty($this->templateContentLayout)) {
            return null;
        }
        return $this->templateContentLayout;
    }

    /**
     * Checks the file exists and
     * @param String $file
     */
    public function checkFilesExists($file) {
        $url = new Url();
        $module = $url->getModule();
        if (is_null($file) || $module == 'General') {
            return false;
        }
        if (!is_file($file)) {
            $log = new Log();
            $log->setLog((__FILE__), 'Unable to get the contents of the template because it does not exist. -> ' . $file, true);
            return false;
        }
        return true;
    }

    /**
     * Grab the contents of the template
     * @param $pathTemplate
     */
    public function getContentFromTemplate($pathTemplate = null, $var = null) {
        
        if (!$this->checkFilesExists($pathTemplate)) {
            return null;
        }
        
        $this->setPathTemplate($pathTemplate);
        
        ob_start();
        require $pathTemplate;
        $this->setContentTemplate(ob_get_contents());
        ob_end_clean();
        
        return $this->getContentTemplate();
    }

    /**
     * Grab the contents of the layout
     * @param $pathTemplate
     */
    public function getContentFromLayout($pathLayout = null, $var = null) {
        
        if (!$this->checkFilesExists($pathLayout)) {
            return null;
        }
        
        $this->setPathLayout($pathLayout);
        
        ob_start();
        require $pathLayout;
        $this->setContentLayout(ob_get_contents());
        ob_end_clean();
        
        return $this->getContentLayout();
    }

    /**
     * Perform the merge of contents
     */
    public function getContentFromMerge() {
        $contetTemplate = $this->templateContent;
        $contetLayout = $this->templateContentLayout;
        if (empty($contetLayout)) {
            return $this->templateContent;
        } else {
            $contentMerge = str_replace("{CONTENT}", $contetTemplate, $contetLayout);
            return $contentMerge;
        }
    }
}