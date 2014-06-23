<!DOCTYPE html >

<html>
    <head>
        <meta http-equiv="content-type" content="text/html; charset=utf-8" />
        <title>Esercizi Form PHP</title>
        <link href="CSS_2.css" rel="stylesheet" type="text/css" media="screen" />

    </head>

	<body>
		<h1>Task 1</h1>
		<?php
			if(isset($_REQUEST["a"]) && isset($_REQUEST["b"]) && isset($_REQUEST["c"])){
				$intFiltro_a=filter_var($_REQUEST["a"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
				$intFiltro_b=filter_var($_REQUEST["b"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE);
				$flag=false;

				if(!isset($intFiltro_a) || !isset($intFiltro_b)){
					echo "Errore:Inserisci dei numeri negli operandi.\n";
					$flag=true;
				}
				
				if($_REQUEST["c"]=="/" && $_REQUEST["b"]==0){
					echo "Errore:Imposibile fare una divisione per 0.\n";
					$flag=true;
				}

				switch($_REQUEST["c"]){
					case "+":
						$risultato=$_REQUEST["a"] + $_REQUEST["b"];
					break;
					case "-":
						$risultato=$_REQUEST["a"] - $_REQUEST["b"];
					break;
					case "*":
						$risultato=$_REQUEST["a"] * $_REQUEST["b"];
					break;
					case "/":
						if($_REQUEST["b"]!=0){
							$risultato=$_REQUEST["a"] / $_REQUEST["b"];
						}
					break;
					default:
						echo "Inserisci un operatore.\n";
					break;
				}
				if($flag==true){
					$risultato=null;
				}
			}
		?>

		<form method="post" action="EsercFormPHP.php">
			<label for="operuno">Primo operando</label>
			<input type="text" name="a" id="operuno" value="<?php if(isset($_REQUEST["a"])){echo $_REQUEST["a"];}else{echo 0;}?>" />
			<br />
			<p>
			<label for="addizione">+</label>
			<input type="radio" name="c" id="addizione" value="+" />
			<br />
			<label for="sottrazione">-</label>
			<input type="radio" name="c" id="sottrazione" value="-" />
			<br />
			<label for="moltiplicazione">*</label>
			<input type="radio" name="c" id="moltiplicazione" value="*" />
			<br />
			<label for="divisione">/</label>
			<input type="radio" name="c" id="divisione" value="/" />
			<br />
			</p>
			<label for="operdue">Secondo operando</label>
			<input type="text" name="b" id="operdue" value="<?php if(isset($_REQUEST["b"])){echo $_REQUEST["b"];}else{echo 0;}?>" />
			<br />

			<br/>
			<input type="submit" value="Submit"/>
			<br />
		</form>

		<?php
			if(isset($risultato)){
					
				$a=$_REQUEST["a"];
				$b=$_REQUEST["b"];
				$c=$_REQUEST["c"];
				echo "$a $c $b = $risultato\n";
			}
		?>

		<hr/>

		<h1>Task 2</h1>

		<?php
			if(isset($_REQUEST["nMit"]) && isset($_REQUEST["coMit"]) && isset($_REQUEST["inMit"]) && isset($_REQUEST["NCMit"]) && isset($_REQUEST["nDes"]) && isset($_REQUEST["coDes"]) && isset($_REQUEST["inDes"]) && isset($_REQUEST["NCDes"]) && isset($_REQUEST["CAP"]) && isset($_REQUEST["lun"]) && isset($_REQUEST["lar"]) && isset($_REQUEST["prf"]) && isset($_REQUEST["peso"])){
				$flag2=false;
				$spedito=null;

				if(!filter_var($_REQUEST["NCMit"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) || !filter_var($_REQUEST["NCDes"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE)){
					echo "I numeri civici devono essere numeri, senza lettere o altri simboli.\n";
					$flag2=true;
				}
				if(!filter_var($_REQUEST["CAP"], FILTER_VALIDATE_REGEXP, array('options'=>array('regexp'=>'/[0-9]{5}/')))){
					echo "Il CAP deve essere composto esattamente da 5 numeri.\n";
					$flag2=true;
				}
				if(!filter_var($_REQUEST["lun"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) || !filter_var($_REQUEST["lar"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) || !filter_var($_REQUEST["prf"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE) || !filter_var($_REQUEST["peso"], FILTER_VALIDATE_INT, FILTER_NULL_ON_FAILURE)){
					echo "Lunghezza, larghezza, profondit&agrave; e peso devono essere interi.\n";
					$flag2=true;
				}
				if($_REQUEST["lun"]>=50 || $_REQUEST["lar"]>=50 || $_REQUEST["prf"]>=50){
					echo "Il pacco &egrave; troppo grosso.Ognuna delle sue dimensioni devono essere inferiori a 50 cm.\n";
					$flag2=true;
				}
				if($_REQUEST["peso"]>=15){
					echo "Il pacco &egrave; troppo pesante.Deve pesare meno di 15 kg.\n";
					$flag2=true;
				}

				if($flag2==false){
					$spedito=true;
				}
			}else{
				echo "Riempi tutti i campi.\n";
			}
		?>

		<form method="post" action="EsercFormPHP.php">
			<h3>Mittente</h3>
			<label for="nomeMittente">Nome:</label>
			<input type="text" name="nMit" id="nomeMittente" value="<?php if(isset($_REQUEST["nMit"])){echo $_REQUEST["nMit"];}else{echo "Inserisci nome...";}?>" />
			<br />
			<label for="cognomeMittente">Cognome:</label>
			<input type="text" name="coMit" id="cognomeMittente" value="<?php if(isset($_REQUEST["coMit"])){echo $_REQUEST["coMit"];}else{echo "Inserisci cognome...";}?>" />
			<br/>
			<label for="indirizzoMittente">Indirizzo:</label>
			<input type="text" name="inMit" id="indirizzoMittente" value="<?php if(isset($_REQUEST["inMit"])){echo $_REQUEST["inMit"];}else{echo "Inserisci indirizzo...";}?>" />
			<br />
			<label for="numeroCivicoMit">Numero civico dell'indirizzo:</label>
			<input type="text" name="NCMit" id="numeroCivicoMit" value="<?php if(isset($_REQUEST["NCMit"])){echo $_REQUEST["NCMit"];}else{echo "Inserisci numero civico...";}?>" />
			<br />

			<h3>Destinatario</h3>
			<label for="nomeDestinatario">Nome:</label>
			<input type="text" name="nDes" id="nomeDestinatario" value="<?php if(isset($_REQUEST["nDes"])){echo $_REQUEST["nDes"];}else{echo "Inserisci nome...";}?>" />
			<br />
			<label for="cognomeDestinatario">Cognome:</label>
			<input type="text" name="coDes" id="cognomeDestinatario" value="<?php if(isset($_REQUEST["coDes"])){echo $_REQUEST["coDes"];}else{echo "Inserisci cognome...";}?>" />
			<br/>
			<label for="indirizzoDestinatario">Indirizzo:</label>
			<input type="text" name="inDes" id="indirizzoDestinatario" value="<?php if(isset($_REQUEST["inDes"])){echo $_REQUEST["inDes"];}else{echo "Inserisci indirizzo...";}?>" />
			<br />
			<label for="numeroCivicoDes">Numero civico dell'indirizzo:</label>
			<input type="text" name="NCDes" id="numeroCivicoDes" value="<?php if(isset($_REQUEST["NCDes"])){echo $_REQUEST["NCDes"];}else{echo "Inserisci numero civico...";}?>" />
			<br />
			<label for="CAP">CAP:</label>
			<input type="text" name="CAP" id="CAP" value="<?php if(isset($_REQUEST["CAP"])){echo $_REQUEST["CAP"];}else{echo "Inserisci CAP...";}?>" />
			<br />

			<h3>Pacco</h3>
			<label for="lunghezza">Lunghezza(in cm):</label>
			<input type="text" name="lun" id="lunghezza" value="<?php if(isset($_REQUEST["lun"])){echo $_REQUEST["lun"];}else{echo "Lunghezza...";}?>" />
			<br />
			<label for="larghezza">Larghezza(in cm):</label>
			<input type="text" name="lar" id="larghezza" value="<?php if(isset($_REQUEST["lar"])){echo $_REQUEST["lar"];}else{echo "Larghezza...";}?>" />
			<br/>
			<label for="profondità">Profondit&agrave;(in cm):</label>
			<input type="text" name="prf" id="profondità" value="<?php if(isset($_REQUEST["prf"])){echo $_REQUEST["prf"];}else{echo "Profondit&agrave;...";}?>" />
			<br />
			<label for="peso">Peso(in kg):</label>
			<input type="text" name="peso" id="peso" value="<?php if(isset($_REQUEST["peso"])){echo $_REQUEST["peso"];}else{echo "Peso...";}?>" />
			<br />

			<br/>
			<input type="submit" value="Submit"/>
			<br />
		</form>

		<?php
			if(isset($spedito)){
				$nM=$_REQUEST["nMit"];
				$cM=$_REQUEST["coMit"];
				$iM=$_REQUEST["inMit"];
				$ncM=$_REQUEST["NCMit"];
				$nD=$_REQUEST["nDes"];
				$cD=$_REQUEST["coDes"];
				$iD=$_REQUEST["inDes"];
				$ncD=$_REQUEST["NCDes"];
				$cap=$_REQUEST["CAP"];
				$lu=$_REQUEST["lun"];
				$la=$_REQUEST["lar"];
				$pr=$_REQUEST["prf"];
				$pe=$_REQUEST["peso"];

				echo "Il pacco &egrave; stato spedito!Mittente:$nM $cM da $iM $ncM.Destinatario:$nD $cD di $iD $ncD, CAP:$cap.Il pacco &egrave; di dimensioni $lu x $la x $pr cm e pesa $pe kg.";
			}
		?>

		<hr/>

		<h1>Task 3</h1>

		<?php
			session_start();
			if(isset($_REQUEST["ok"])){
				$_SESSION["SOn"]=true;
				$_SESSION["visite"]=1;
			}else if(isset($_REQUEST["basta"])){
				$_SESSION=array();

				if(session_id()!="" || isset($_COOKIE[session_name()])){
					setcookie(session_name(), '', time()-2592000, '/');
				}

				session_destroy();
			}
		?>

		<?php
			if(isset($_SESSION["SOn"]) && $_SESSION["SOn"]){ ?>
				<?php
					if(isset($_SESSION["visite"])){
						if($_SESSION["visite"]==25){
							echo "Grazie per aver visitato questo sito!";
							$_SESSION["visite"]=1;
						}else{
							$_SESSION["visite"]+=1;
						}
					}else{
						$_SESSION["visite"]=1;
					}
				?>

				<p>Numero di visite: <?= $_SESSION["visite"] ?></p>
				<br/>
				<form method="post" action="EsercFormPHP.php">
					<input type="submit" name="basta" value="Finisci sessione"/>
				</form>
			<?php
			}else{ ?>
				<form method="post" action="EsercFormPHP.php">
					<input type="submit" name="ok" value="Inizia sessione"/>
				</form>
			<?php
			}
		?>

		<hr/>

		<h1>Task 4</h1>

		<p>Scegli il tuo colore preferito.</p>

		<form method="post" action="Color.php">
		<p>
			<label for="red">Rosso</label>
			<input type="radio" id="red" name="colore" value="red"/>
			<br/>
			<label for="blue">Blu</label>
			<input type="radio" id="blue" name="colore" value="blue"/>
			<br/>
			<label for="yellow">Giallo</label>
			<input type="radio" id="yellow" name="colore" value="yellow"/>
			<br/>
			<label for="green">Verde</label>
			<input type="radio" id="green" name="colore" value="green"/>
			<br/>
			<label for="white">Bianco</label>
			<input type="radio" id="white" name="colore" value="white"/>
			<br/>
			<label for="black">Nero</label>
			<input type="radio" id="black" name="colore" value="black"/>
			<br/>
			<label for="pink">Rosa</label>
			<input type="radio" id="pink" name="colore" value="pink"/>
			<br/>
			<label for="orange">Arancione</label>
			<input type="radio" id="orange" name="colore" value="orange"/>
			<br/>

			<br/>
			<input type="submit" name="colora" value="Submit"/>
			<br />
		</p>
		</form>
		
	</body>
</html>
