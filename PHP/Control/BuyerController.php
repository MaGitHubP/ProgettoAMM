<?php
    include_once 'InitialController.php';
    include_once basename(__DIR__) . '/../Model/User.php';
    include_once basename(__DIR__) . '/../Model/UserFactory.php';
    
    /*Questa classe gestisce le pagine del compratore, e le sue  
     *modifiche dei dati.Il metodo handleInput gestisce i vari 
     *input dell'utente compratore.*/
    class BuyerController extends InitialController{
        
        public function __construct() {
            parent::__construct();
        }
        
	/*Questo metodo prende come parametro un input del compratore e lo gestisce.*/
        public function handleInput(&$request){
            $view=new ViewDescriptor();
            
            $view->setPage($request["page"]);
            
	    //Se l'utente non è loggato, mostra la pagina del login.
	    if(!$this->isLogged()){
		$this->showInitialPage($view);
	    }else{
		$usFac=new UserFactory();
		$user = $usFac->IdLoadUser($_SESSION[InitialController::user], $_SESSION[InitialController::role]);

                if(isset($request["subpage"])){
                    switch($request["subpage"]){
                        case "see":
                            $genre="all";
			    $console="all";
			    $this->searchGames($view, $genre, $console);
                            break;
                        case "recharge":
                            $view->setSubPage("recharge");
                            break;
                        case "cart":
                            $view->setSubPage("cart");
                            break;
                        default:
                            $view->setSubPage("home");
                            break;
                    }
                }
                
            	if(isset($request["cmd"])){
                	switch($request["cmd"]){
                    	case "logout":
                        	$this->logout($view);
                        	break;
			case "search":
                        	$genre=$request["genre"];
                        	$console=$request["console"];
                        	$this->searchGames($view, $genre, $console);
                        	break;
                    	default:
                        	$this->showHomeUser($view);
                	}
            	}else{
			$usFac=new UserFactory();
			$user = $usFac->IdLoadUser($_SESSION[InitialController::user], $_SESSION[InitialController::role]);
                	$this->showHomeUser($view);
            	}
            }
	    require basename(__DIR__) . '/../View/Main.php';
        }

	public function searchGames($view, $genre, $console){
                
                $view->setSubPage("see");
		$this->showHomeUser($view);
        }
        
    }
?>
