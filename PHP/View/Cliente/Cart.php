<?php
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
	    //Nessun errore, procedo con le query.Prima ricavo il numero totale dei risultati.
	    $temp_id=$user->getId();
	    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=$temp_id";
	    
	    $result=$mysqli->query($query);
		
	    if($mysqli->errno>0){
		//Errore nell'esecuzione della query.
		error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error ", 0);
	    }else{
		$total_result=$result->num_rows;
	    }

	    //Adesso mostro i risultati, eventualmente dividendoli in più pagine.
	    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=$temp_id LIMIT $limit_index, 4";
	    
	    $result=$mysqli->query($query);
		
	    if($mysqli->errno>0){
		//Errore nell'esecuzione della query.
		error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error ", 0);
	    }else{
		$result_games=$limit_index+$result->num_rows;	?>
                <p id="results">Ci sono <?= $result->num_rows ?> su <?= $total_result ?> risultati(da <?= $limit_index ?> a <?= $result_games ?>):</p>

	<?php	echo "<ul>\n";
		while($row=$result->fetch_row()){
		    echo "<li class=\"lineVG\">";	?>
		    <img title="Cover" alt="Cover <?= $row[1] ?>" src="../Images/Boxart/<?= $row[6] ?>" id="game_cover">
		    <p id="game_title"><b>Titolo:</b> <?= $row[1] ?></p>
		    <p id="game_genre"><b>Genere:</b> <?= $row[2] ?></p>
		    <p id="game_console"><b>Piattaforma:</b> <?= $row[3] ?></p>
		    <p id="game_date"><b>Data di uscita:</b> <?= $row[4] ?></p>
		    <p id="game_price"><b>Prezzo:</b> <?= $row[5] ?></p>
		    <a href="buyer?cmd=refuse&id_videogame=<?= $row[0] ?>&price=<?= $row[5] ?>" class="deletegame">Elimina acquisto</a>
	<?php	    echo "</li>";
		}
		echo "</n>\n";

            }   ?>
           
	    <!--Qui gestisco i link per andare avanti o indietro nella lista.-->               
<?php       if($limit_index!=0){	
		$limit_back=$limit_index-4;	?>
		<a href="buyer?subpage=cart&limit_index=<?= $limit_back ?>" id="prev">Indietro</a>
<?php       }
	    $offset=$limit_index+4;
	    if(($offset) < $total_result){
		$limit_front=$offset;	?>
                <a href="buyer?subpage=cart&limit_index=<?= $limit_front ?>" id="next">Avanti</a>
<?php       }
        }?>
