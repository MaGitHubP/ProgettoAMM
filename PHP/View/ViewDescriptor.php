<?php
    class ViewDescriptor{
        //Identificatori
        private $title;
        private $header;
	private $log;
	private $bar;
	private $content;
	private $page;
	private $subPage;
	private $errorMsg;
        const get='get';
        const post='post';
        //Costruttore
        public function __construct() {
            
        }
        //Metodi

	//La variabile title rappresenta il titolo della pagina.
        public function setTitle($title){
            $this->title=$title;
        }
        public function getTitle(){
            return $this->title;
        }
	//La variabile header contiene il menù da mostrare nell'header del Main.
        public function setHeader($header){
            $this->header=$header;
        }
        public function getHeader(){
            return $this->header;
        }
	//La variabile log contiene il form del login o logout da mostrare nel Nav del Main.
	public function setLog($log){
	    $this->log=$log;
	}
	public function getLog(){
	    return $this->log;
	}
	//La variabile bar contiene la Left Bar da mostrare nel Main.
	public function setLeftBar($bar){
	    $this->bar=$bar;
	}
	public function getLeftBar(){
	    return $this->bar;
	}
	//La variabile content contiene il contenuto del Main(Scusa il gioco di parole...).
	public function setContent($content){
	    $this->content=$content;
	}
	public function getContent(){
	    return $this->content;
	}
	/*La variabile page viene usata soprattutto come valore del parametro 
	 *$request["page"], e quindi serve per far capire al programma se si 
	 *sta visitando il sito sotto il ruolo di utente anonimo, di compratore 
	 *o di venditore.*/
	public function setPage($page){
		$this->page=$page;
	}
	public function getPage(){
		return $this->page;
	}
	/*La variabile subPage viene usata come valore degli switch nei content 
	 *delle varie pagine, in modo da mostrare le eventuali sottopagine.*/
	public function setSubPage($subPage){
		$this->subPage=$subPage;
	}
	public function getSubPage(){
		return $this->subPage;
	}
	/*La variabile errorMsg contiene un messaggio di errore.Viene mostrato nel caso ci 
	 *fosse qualche problema.*/
	public function setErrorMessage($msg){
		$this->errorMsg=$msg;
	}
	public function getErrorMessage(){
		return $this->errorMsg;
	}
    }
?>
