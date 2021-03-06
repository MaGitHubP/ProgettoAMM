<?php
    	if(isset($confirm) && $confirm==true){	
	    $confirm=false;	?>
	    <p>Inserisci il codice della tua carta per confermare l'acquisto.</p>
	    <form method="post" action="buy">
		<input type="hidden" name="cmd" value="buy"/>
    		<input type="hidden" name="page" value="buyer"/>
		<input type="hidden" name="id_videogame" value="<?= $id_videogame ?>"/>
		<input type="hidden" name="genre" value="<?= $genre ?>"/>
		<input type="hidden" name="console" value="<?= $console ?>"/>
		<input type="hidden" name="price" value="<?= $price ?>"/>
    		<label for="code">Codice carta:</label>
    		<input type="text" name="code" id="code"/>
		<input type="submit" value="Acquista"/>
	    </form>
<?php   }else{

		/*Se ci sono problemi di "compatibilità" di spazi tra URL rewriting e nomi dei campi 
	 	 *nel database, faccio gli opportuni aggiornamenti.*/
		if(!isset($research_name)){
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
	        }

		if(isset($isOk) && $isOk!=true){
		    $isOk=true;
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
		$this->showInitialPage($view);
                return null;
            }else{
                //Nessun errore, procedo con le query.Prima ricavo il numero totale dei risultati.
		if(isset($research_name)){
		    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.title LIKE \"%$name_game%\"";
		}else if($genre!="all" && $console!="all"){
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.genre=\"$genre\" AND videogame.console=\"$console\"";
                }else if($genre=="all" && $console!="all"){
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.console=\"$console\"";
                }else if($genre!="all" && $console=="all"){
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.genre=\"$genre\"";
                }else{
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1";
                }
	    
                $result=$mysqli->query($query);
		
                if($mysqli->errno>0){
                    //Errore nell'esecuzione della query.
                    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error ", 0);
                }else{
		    $total_result=$result->num_rows;
		}

		//Adesso mostro i risultati, eventualmente dividendoli in più pagine.
		if(isset($research_name)){
		    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.title LIKE \"%$name_game%\" LIMIT $limit_index, 4";
		}else if($genre!="all" && $console!="all"){
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.genre=\"$genre\" AND videogame.console=\"$console\" LIMIT $limit_index, 4";
                }else if($genre=="all" && $console!="all"){
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.console=\"$console\" LIMIT $limit_index, 4";
                }else if($genre!="all" && $console=="all"){
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 AND videogame.genre=\"$genre\" LIMIT $limit_index, 4";
                }else{
                    $query="SELECT videogame.id, title, genre, console, relase_date, price, cover FROM videogame JOIN user ON videogame.owner=user.id WHERE user.id=1 LIMIT $limit_index, 4";
                }
	    
                $result=$mysqli->query($query);
		
                if($mysqli->errno>0){
                    //Errore nell'esecuzione della query.
                    error_log("Errore nell'esecuzione della query $mysqli->errno : $mysqli->error ", 0);
                }else{
		    $result_games=$limit_index+$result->num_rows;	?>
                    <p id="results">Ci sono <?= $result->num_rows ?> su <?= $total_result ?> risultati(da <?= $limit_index ?> a <?= $result_games ?>):</p>

            <?php   echo "<ul>\n";
                    while($row=$result->fetch_row()){
                        echo "<li class=\"lineVG\">";	?>
                        <img title="Cover" alt="Cover <?= $row[1] ?>" src="../Images/Boxart/<?= $row[6] ?>" id="game_cover">
			<p id="game_title"><b>Titolo:</b> <?= $row[1] ?></p>
		    	<p id="game_genre"><b>Genere:</b> <?= $row[2] ?></p>
		    	<p id="game_console"><b>Piattaforma:</b> <?= $row[3] ?></p>
		    	<p id="game_date"><b>Data di uscita:</b> <?= $row[4] ?></p>
		    	<p id="game_price"><b>Prezzo:</b> <?= $row[5] ?></p>
                        <form method="post" action="purchase">
			    <input type="hidden" name="cmd" value="confirmPurchase"/>
			    <input type="hidden" name="page" value="buyer"/>
                            <input type="hidden" name="id_videogame" value="<?= $row[0] ?>"/>
                            <input type="hidden" name="genre" value="<?= $genre ?>"/>
                            <input type="hidden" name="console" value="<?= $console ?>"/>
                            <input type="hidden" name="price" value="<?= $row[5] ?>"/>
                            <input type="submit" value="Aggiungi al carrello"/>
		    	</form>
            <?php	echo "</li>";
                    }
                    echo "</n>\n";

                }   ?>
                   
		<!--Qui gestisco i link per andare avanti o indietro nella lista.
		    Devo distinguere il caso in cui faccio una ricerca per nome o per genere/piattaforma.-->     
<?php		if(isset($research_name)){
	            if($limit_index!=0){	
		    	$limit_back=$limit_index-4;	?>
		    	<a href="buyer?cmd=search&research_name=true&namesearch=<?= $name_game ?>&limit_index=<?= $limit_back ?>" id="prev">Indietro</a>
    <?php           }
		    $offset=$limit_index+4;
		    if(($offset) < $total_result){
		        $limit_front=$offset;	?>
                        <a href="buyer?cmd=search&research_name=true&namesearch=<?= $name_game ?>&limit_index=<?= $limit_front ?>" id="next">Avanti</a>
    <?php           }
    		}else{
	            if($limit_index!=0){	
		        $limit_back=$limit_index-4;	?>
		        <a href="buyer?cmd=search&genre=<?= $genre ?>&console=<?= $console ?>&limit_index=<?= $limit_back ?>" id="prev">Indietro</a>
    <?php           }
		    $offset=$limit_index+4;
		    if(($offset) < $total_result){
		        $limit_front=$offset;	?>
                        <a href="buyer?cmd=search&genre=<?= $genre ?>&console=<?= $console ?>&limit_index=<?= $limit_front ?>" id="next">Avanti</a>
    <?php           }
    		}
    
            }
    }?>
