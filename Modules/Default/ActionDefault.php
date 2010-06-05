<?php
/**
 * ActionDefault class
 * @author Marco Antonio Sugamele <marco@iaol.com.br>
 * @since 12/02/2010
 * Control template
 * Last revision : 13/02/2010
 * Module: Default
 */
class ActionDefault extends Url {

    public function executeIndex(Content &$objContent) {
    	$objContent->getObjTemplate()->setLayoutPersonalite('Test','Test');
    	//$objContent->getObjTemplate()->setLayout('Red');
    	//$objContent->getObjTemplate()->setLayout('Redkkk');
        $log = new Log();
        $this->var1 = $log->retriveByPk(1);
        $this->var2 = $log->retriveByDate('2010-02-15');
        $this->var3 = $log->retriveByError(0);
        $this->var4 = $log->getLog();
        $this->var5 = $this->getRequestParameter('número');
        $this->var6 = $this->getRequestParameter('oba');
        $this->var7 = $objContent->getAttribute('teste');
        $this->var8 = $objContent->getFlush('teste');
        //$objContent->setAttribute('teste', null);
        $this->var9 = $objContent->getAttribute('teste');
        $this->var10 = $objContent->getFlush('teste');
        $this->culture = $objContent->getObjCulture()->getCulture();
        //$this->forward('Default','Index', $objContent);
    

    //return ViewActions::VIEW_ERROR;
    

    //$this->redirectIndoor('Default','Teste',array('número'=>'777'));
    

    //return ViewActions::VIEW_NONE;
    // $this->redirect('www.google.com.br');
    

    /* @var $tag Tag */
    //        $tag = Tag::retriveByPk('cachorro','en_US');
    //        var_dump($tag);
    //        var_dump($tag->getI18n());
    
    }

    public function executeTeste(Content &$objContent) {
        $objContent->getObjTemplate()->setLayout('Red');
        $objEmail = new Phpmailer();
        $body = "Olá mundo.";
        //$objEmail->IsSendmail();
        $objEmail->MsgHTML("Ola Mundo");
        $objEmail->AddAddress("marco@iaol.com.br");
        $objEmail->SetFrom("marco@iaol.com.br");
        $objEmail->Subject = "OKOKO";
        
        if (!$objEmail->Send()) {
            $log = new Log();
            $log->setLog((__FILE__), "Mailer Error: " . $objEmail->ErrorInfo);
            $this->var2 = "Mailer Error: " . $objEmail->ErrorInfo;
        }
        
        $this->var1 = $this->getRequestParameter('número') * 20;
        $this->var2 = "Success!!";
        
        $this->forward1 = $this->getRequestParameter('número');
        $this->forward2 = $this->getRequestParameter('oba');
        $this->link = Headers::linkTo('Default', 'Index', array('culture' => $objContent->getObjCulture()->getCulture()));
        var_dump(Headers::linkToCss('Default', 'estilos.css'));
    }

    public function executeMyTest() {
        echo "Teste de sem layout";
        I18nXml::create('pt_BR');
        I18nXml::create('en_US');
        I18nXml::read('pt_BR');
        return ViewActions::VIEW_NONE;
    }

    public function preExecute() {//echo '123 <br>';
}

    public function endExecute() {
        echo '<br>321';
    }

    public function executeAttribute(Content &$objContent) {
        $objContent->setAttribute('teste', 'HAHA!!!');
        $objContent->setFlush('teste', '12334343430');
        //$this->forward('Default','Index');
        $this->redirectIndoor('Default', 'Index');
        return ViewActions::VIEW_NONE;
    }
    
    public function executeYml(){
    	// EXP: 01
    	$yaml = new sfYamlParser();
    	$value = $yaml->parse(file_get_contents('/home/marco/public_html/mmvc/trunk/Config/Default/config.yml'));
    	var_dump($value);
    	
    	// EXP: 02
    	var_dump(sfYaml::load(Headers::linkToYml('Default','config.yml')));
    	return ViewActions::VIEW_NONE;
    }
}

?>