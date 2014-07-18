<?php
    include_once 'View/ViewDescriptor.php';
    include_once 'Control/InitialController.php';
    include_once 'Control/BuyerController.php';
    include_once 'Control/SellerController.php';

    FrontController::dispatch($_REQUEST);

    class FrontController{

        public static function dispatch($request){
		session_start();
            	if(isset($request["page"])){
                	switch($request["page"]){
                    	case "login":
                        	$controller=new InitialController();
                        	$controller->handleInput($request);
                        	break;
                    	case "buyer":
                        	$controller=new BuyerController();
                        	if(isset($_SESSION[InitialController::role]) && $_SESSION[InitialController::role]!=User::Buyer){
                        	    self::error403();
                        	}
                        	$controller->handleInput($request);
                        	break;
                    	case "seller":
                        	$controller=new SellerController();
                        	if(isset($_SESSION[InitialController::role]) && $_SESSION[InitialController::role]!=User::Seller){
                        	    self::error403();
                        	}
                        	$controller->handleInput($request);
                        	break;
                    	default:
                        	self::error404();
                        	break;
                	}
            	}else{
			$request["page"]="login";
                	$controller=new InitialController();
                        $controller->handleInput($request);
            	}
        }
        
        public static function error403() {
        
        header('HTTP/1.0 403 Forbidden');
        $titolo = "Accesso negato";
        $messaggio = "Non hai i diritti per accedere a questa pagina";
        $login = true;
        include_once('Error.php');
        exit();
        
        }
        
        public static function error404() {
        
        header('HTTP/1.0 404 Not Found');
        $titolo = "File non trovato!";
        $messaggio = "La pagina che hai richiesto non &egrave; disponibile";
        include_once('Error.php');
        exit();
        
        }
        
    }

?>
