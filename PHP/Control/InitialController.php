<?php
    include_once basename(__DIR__) . '/../View/ViewDescriptor.php';
    include_once basename(__DIR__) . '/../Model/User.php';
    include_once basename(__DIR__) . '/../Model/UserFactory.php';
    
    /*Questa classe gestisce le pagine "iniziali", cioè quelle in cui 
     *viene richiesto il login.Il metodo handleInput gestisce i vari 
     *input dell'utente.*/
    class InitialController{
        
	const user='user';
	const role='role';
        
        public function __construct() {
            
        }

        /*Questo metodo prende come parametro un input dell'utente e lo gestisce.*/
        public function handleInput(&$request){
            $view=new ViewDescriptor();
            
            $view->setPage($request["page"]);
            
            if(isset($request["subpage"])){
                switch($request["subpage"]){
                    case "see":
                        $genre="all";
			$console="all";
			$this->searchGames($view, $genre, $console);
                        break;
                    default:
                        $view->setSubPage("home");
                        break;
                }
            }
            
            if(isset($request["cmd"])){
                switch($request["cmd"]){
                    case "login":
                        if(isset($request["username"])){
                            $username=$request["username"];
                        }else{
                            $username='';
                        }
                        if(isset($request["password"])){
                            $password=$request["password"];
                        }else{
                            $password='';
                        }
                        $this->login($view, $username, $password);
                        break;
                    case "search":
                        $genre=$request["genre"];
                        $console=$request["console"];
                        $this->searchGames($view, $genre, $console);
                        break;
                    default:
                        $this->showInitialPage($view);
                }
            }else{
                $this->showInitialPage($view);
            }
            require basename(__DIR__) . '/../View/Main.php';
        }
        
	/*Questo metodo gestisce il login dell'utente.*/
        public function login($view, $username, $password){
		$usFac=new UserFactory();
		$user=$usFac->carica($username, $password);	//Da modificare.
		if(isset($user)){
			$_SESSION[self::user] = $user->getId();
            		$_SESSION[self::role] = $user->getRole();
			$this->showHomeUser($view);
		}else{
			$view->setErrorMessage("Errore:Username o password errata");
            		$this->showInitialPage($view);
		}
	}

	/*Questo metodo gestisce il logout.*/
	public function logout($view){
		//Resetto $_SESSION con un array vuoto.
        	$_SESSION = array();
        	//Termino la validita' del cookie di sessione
        	if (session_id() != '' || isset($_COOKIE[session_name()])) {
            	//Imposto il termine di validita' al mese scorso
            	setcookie(session_name(), '', time() - 2592000, '/');
        	}
        	//Distruggo il file di sessione
        	session_destroy();
        	$this->showInitialPage($view);
	}

	/*Questo metodo ritorna true se l'utente è loggato, false altrimenti.*/
	public function isLogged(){
		return isset($_SESSION) && array_key_exists(self::user, $_SESSION);
	}

	/*Questo metodo setta le variabili del ViewDescriptor in modo da mostrare 
	 *la pagina per gli utenti non loggati.*/
	public function showInitialPage($view){
		$view->setTitle("GiochiAMMO.com - Benvenuto");
		$view->setHeader(basename(__DIR__) . '/../View/Login/Header.php');
		$view->setLog(basename(__DIR__) . '/../View/Login/Nav.php');
		$view->setLeftBar(basename(__DIR__) . '/../View/Login/LeftBar.php');
		$view->setContent(basename(__DIR__) . '/../View/Login/Content.php');
		$view->setPage("login");
	}
	
	/*Questo metodo verifica il ruolo dell'utente loggato e chiama il metodo 
	 *showHomeBuyer se è un compratore, oppure showHomeSeller se è un venditore.*/
	public function showHomeUser($view){
		$usFac=new UserFactory();
		$user=$usFac->IdLoadUser($_SESSION[self::user], $_SESSION[self::role]);
		switch($user->getRole()){
			case User::Buyer:
				$this->showHomeBuyer($view);
				break;
			case User::Seller:
				$this->showHomeSeller($view);
				break;
		}
	}
	
	/*Questo metodo setta le variabili del ViewDescriptor in modo da mostrare 
	 *la pagina per gli utenti loggati come compratori.*/
	public function showHomeBuyer($view){
		$view->setTitle("GiochiAMMO.com - Compra videogiochi");
		$view->setHeader(basename(__DIR__) . '/../View/Cliente/Header.php');
		$view->setLog(basename(__DIR__) . '/../View/Cliente/Nav.php');
		$view->setLeftBar(basename(__DIR__) . '/../View/Cliente/LeftBar.php');
		$view->setContent(basename(__DIR__) . '/../View/Cliente/Content.php');
		$view->setPage("buyer");
	}

	/*Questo metodo setta le variabili del ViewDescriptor in modo da mostrare 
	 *la pagina per gli utenti loggati come venditori.*/
	public function showHomeSeller($view){
		$view->setTitle("GiochiAMMO.com - Vendi videogiochi");
		$view->setHeader(basename(__DIR__) . '/../View/Venditore/Header.php');
		$view->setLog(basename(__DIR__) . '/../View/Venditore/Nav.php');
		$view->setLeftBar(basename(__DIR__) . '/../View/Venditore/LeftBar.php');
		$view->setContent(basename(__DIR__) . '/../View/Venditore/Content.php');
		$view->setPage("seller");
	}
        
        public function searchGames($view, $genre, $console){
                
                $view->setSubPage("see");
		$this->showInitialPage($view);
        }
    }
?>
