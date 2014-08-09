<?php
include_once 'RBarGames.php';

class RBarGamesFactory{

	public static function &getGamesList(){

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
				    $this->showInitialPage($view);
				    return null;
	    		    }else{
			    	    /*Non c'è nessun errore.*/
			    	    $query="SELECT * FROM videogame WHERE owner=1";
			    	    $result=$mysqli->query($query);

				    if($mysqli->errno > 0){
			    	    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error, 0");
			    	    return null;
			 	    }
				    
				    $games= array();
				    $i=0;
				    while($row=$result->fetch_row()){
				    	$games[]= new RBarGames();
					$games[$i]->setId($i);
					$games[$i]->setTitle($row[1]);
					$games[$i]->setCover($row[6]);
					$i+=1;
				    }

				    $mysqli->close();
				    return $games;
			    }

	}

}
?>
