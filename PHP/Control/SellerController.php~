<?php
    include_once 'InitialController.php';
    include_once basename(__DIR__) . '/../Model/User.php';
    include_once basename(__DIR__) . '/../Model/UserFactory.php';
    include_once basename(__DIR__) . '/../Model/RBarGames.php';
    include_once basename(__DIR__) . '/../Model/RBarGamesFactory.php';
    
    /*Questa classe gestisce le pagine del venditore, e le sue  
     *modifiche dei dati.Il metodo handleInput gestisce i vari 
     *input dell'utente venditore.*/
    class SellerController extends InitialController{
        
        public function __construct() {
            parent::__construct();
        }
        
	/*Questo metodo prende come parametro un input del venditore e lo gestisce.*/
        public function handleInput(&$request){
            $view=new ViewDescriptor();

  	    $gamesList = RBarGamesFactory::getGamesList();
            $ajaxMode = false;
            
            $view->setPage($request["page"]);
            
	    //Se l'utente non è loggato, mostra la pagina del login.
            if(!$this->isLogged()){
		$this->showInitialPage($view);
	    }else{
		$usFac=new UserFactory();
		$user = $usFac->IdLoadUser($view, $_SESSION[InitialController::user], $_SESSION[InitialController::role]);
                
                if(isset($request["subpage"])){
                    switch($request["subpage"]){
			case "profile":
			    $view->setSubPage("profile");
			    break;
                        case "see":
                            $genre="all";
			    $console="all";
			    $limit_index=$request["limit_index"];
			    $this->searchGames($view);
                            break;
                        case "add":
                            $view->setSubPage("add");
                            break;
                        case "delete":
			    $limit_index=$request["limit_index"];
                            $view->setSubPage("delete");
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
				$game = $gamesList[0];
                        	break;
			case "modify":
				$info=$request["info"];
				$modify=true;

				$view->setSubPage("profile");
				$this->showHomeUser($view);
				break;
			case "modifyInfo":
				$info=$request["info"];
				$newInfo=$request["newInfo"];
				$isOk=$this->modifyInfo($view, $info, $newInfo, $user);
				if($isOk==false){
				    $modify=true;
				    $view->setSubPage("profile");
				}else{
				    //Qui ricarico l'user per rendere subito visibili le eventuali modifiche fatte all'username.
				    $user = $usFac->IdLoadUser($view, $_SESSION[InitialController::user], $_SESSION[InitialController::role]);
				}

				break;
			case "search":
                        	if(isset($request["research_name"])){
			    	    $research_name=$request["research_name"];
				    $name_game=$request["namesearch"];
				    //Do un valore alle due variabili genre e console per evitare gli errori di variabili non inizializzate.
				    $genre="set";
                            	    $console="set";
				}else{
				    $genre=$request["genre"];
                            	    $console=$request["console"];
				}

				$limit_index=$request["limit_index"];
				$this->searchGames($view);
                        	break;
			case "add":
				if(!isset($request["title"]) || !isset($request["r_d_year"]) || !isset($request["price"]) || !isset($request["cover"])){
				    $notFull=true;
				}

				$title=$request["title"];
				$genre=$request["genre"];
				$console=$request["console"];
				$r_d_day=$request["r_d_day"];
				$r_d_month=$request["r_d_month"];
				$r_d_year=$request["r_d_year"];
				$price=$request["price"];
				if(isset($request["cover"])){
				    $cover=$request["cover"];
				}

				$filter_int=filter_var($r_d_year, FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
				$filter_float=filter_var($price, FILTER_VALIDATE_FLOAT, FILTER_NULL_ON_FAILURE);
	    			if(!isset($filter_int)){
				    $wrong_date=true;
	    			}
				if(!isset($filter_float)){
				    $wrong_price=true;
				}

				if(($r_d_day==31) && ($r_d_month==02 || $r_d_month==04 || $r_d_month==06 || $r_d_month=="09" || $r_d_month==11)){
				    $wrong_date=true;
				}
				if(($r_d_day==30) && ($r_d_month==02)){
				    $wrong_date=true;
				}
				if(($r_d_day==29) && ($r_d_month==02) && ($r_d_year%4!=0)){
				    $wrong_date=true;
				}

				if(isset($notFull) && $notFull==true){
				    $view->setErrorMessage("Errore:Riempi tutti i campi.");
				    $this->showHomeUser($view);
				    $view->setSubPage("add");
				}else if(isset($wrong_date) && $wrong_date==true){
				    $this->showHomeUser($view);
				    $view->setSubPage("add");
				}else if(isset($wrong_price) && $wrong_price==true){
				    $this->showHomeUser($view);
				    $view->setSubPage("add");
				}else{
				    $this->addGame($view, $title, $genre, $console, $r_d_day, $r_d_month, $r_d_year, $price, $cover, $user);
				}

				break;
			case "delete":
			    $videogame_id=$request["videogame_id"];
			    $this->deleteGame($view, $videogame_id);
			    break;
			case "next":
			    $filter_int=filter_var($request["game_id"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

			    if(!isset($filter_int)){
			        $filter_int=0;
			    }
			    $filter_int++;
                    	    if ($filter_int >= 0 && $filter_int < count($gamesList)) {
                                $game = $gamesList[$filter_int];
                    	    }
                    	    $ajaxMode = true;

			    break;
		        case "prev":
			    $filter_int=filter_var($request["game_id"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);

			    if(!isset($filter_int)){
			        $filter_int=0;
			    }
			    $filter_int--;
                    	    if ($filter_int >= 0 && $filter_int < count($gamesList)) {
                                $game = $gamesList[$filter_int];
                    	    }
                    	    $ajaxMode = true;

			    break;
                    	default:
                        	$this->showHomeUser($view);
                	}
            	}else{
			$usFac=new UserFactory();
			$user = $usFac->IdLoadUser($view, $_SESSION[InitialController::user], $_SESSION[InitialController::role]);
                	$this->showHomeUser($view);
			$game = $gamesList[0];
            	}
            }
	    if($ajaxMode){
		header('Cache-Control: no-cache, must-revalidate');
		header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
		header('Content-type: application/json');

		$json = array();

		$json["id"] = $game->getId();
		$json["title"] = $game->getTitle();
		$json["cover"] = $game->getCover();

		echo json_encode($json);

	    }else{
		require basename(__DIR__) . '/../View/Main.php';
    	    }
        }

	public function searchGames($view){
                
                $view->setSubPage("see");
		$this->showHomeUser($view);
        }

	public function addGame($view, $title, $genre, $console, $r_d_day, $r_d_month, $r_d_year, $price, $cover, $user){
		/*Se ci sono problemi di "compatibilità" di spazi tra URL rewriting e nomi dei campi 
	 	 *nel database, faccio gli opportuni aggiornamenti.*/
		if($genre=="Puzzle"){
                    $genre="Puzzle Game";
                }else if($genre=="Horror"){
                    $genre="Survival Horror";
                }

                if($console=="GameBoy"){
                    $console="Game Boy";
                }else if($console=="GBA"){
                    $console="Game Boy Advance";
                }else if($console=="GameCube"){
                    $console="Game Cube";
                }else if($console=="3DS"){
                    $console="Nintendo 3DS";
                }else if($console=="N64"){
                    $console="Nintendo 64";
                }else if($console=="NDS"){
                    $console="Nintendo DS";
                }else if($console=="PSX"){
                    $console="PlayStation 1";
                }else if($console=="PS2"){
                    $console="PlayStation 2";
                }else if($console=="PS3"){
                    $console="PlayStation 3";
                }else if($console=="PS4"){
                    $console="PlayStation 4";
                }else if($console=="PSVita"){
                    $console="PS Vita";
                }else if($console=="X360"){
                    $console="XBox 360";
                }else if($console=="XOne"){
                    $console="XBox One";
                }else if($console=="WiiU"){
                    $console="Wii U";
                }

		$mysqli=new mysqli();
	    	$mysqli->connect(Settings::$db_host, 
			         Settings::$db_user, 
			         Settings::$db_password, 
			         Settings::$db_name);
	    	if($mysqli->connect_errno != 0){
			$idError=$mysqli->connect_errno;
			$msg=$mysqli->connect_error;
			error_log("Errore connessione $idError!$msg", 0);
			$view->setErrorMessage($msg);
			$mysqli->close();
			$this->showHomeUser($view);
			return null;
	    	}else{
			$temp_id=$user->getId();
			$query="INSERT INTO videogame (id, title, genre, console, relase_date, price, cover, owner) VALUES (default, \"$title\", \"$genre\", \"$console\", \"$r_d_year-$r_d_month-$r_d_day\", $price, \"$cover\", $temp_id)";

			$result=$mysqli->query($query);
			if($mysqli->errno > 0){
		    	    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
		    	    return null;
			}

			$mysqli->close();
		    	$this->showHomeUser($view);
		}
	}

	public function deleteGame($view, $videogame_id){
	        $mysqli=new mysqli();
	    	$mysqli->connect(Settings::$db_host, 
			         Settings::$db_user, 
			         Settings::$db_password, 
			         Settings::$db_name);
	    	if($mysqli->connect_errno != 0){
			$idError=$mysqli->connect_errno;
			$msg=$mysqli->connect_error;
			error_log("Errore connessione $idError!$msg", 0);
			$view->setErrorMessage($msg);
			$mysqli->close();
			$this->showHomeUser($view);
			return null;
	    	}else{
			$query="DELETE FROM videogame WHERE id=$videogame_id";

			$result=$mysqli->query($query);
			if($mysqli->errno > 0){
		    	    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
		    	    return null;
			}

			$mysqli->close();
		    	$this->showHomeUser($view);
		}
	}

	public function modifyInfo($view, $info, $newInfo, $user){
	    if($info=="email"){
		if(!filter_var($newInfo, FILTER_VALIDATE_EMAIL)){
		    $view->setErrorMessage("Errore:Digita un indirizzo email valido.\n");
		    $this->showHomeUser($view);
		    return false;
		}
	    }
	    
	    //Creo una variabile mysql.
            $mysqli=new mysqli();
	    $mysqli->connect(Settings::$db_host, 
			     Settings::$db_user, 
			     Settings::$db_password, 
			     Settings::$db_name);
	    if($mysqli->connect_errno != 0){
		$idError=$mysqli->connect_errno;
		$msg=$mysqli->connect_error;
		error_log("Errore connessione $idError!$msg", 0);
		$view->setErrorMessage($msg);
		$mysqli->close();
		$this->showHomeUser($view);
		return null;
	    }else{
		//Nessun Errore!Procedo con la modifica.
		$temp_id=$user->getId();
		$query="UPDATE user SET $info=\"$newInfo\" WHERE user.id=$temp_id";
		$result=$mysqli->query($query);

		if($mysqli->errno > 0){
		    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
		    return null;
		}

		$this->showHomeUser($view);
		return true;
	    }
	}
        
    }
?>
