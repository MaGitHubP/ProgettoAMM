<?php	if(isset($modify) && $modify==true){
		$modify=false;	?>
		<p id="main_p">Fai la modifica nel form qui sotto.</p>
		<form method="post" action="modify" id="modify_info">
		    <input type="hidden" name="cmd" value="modifyInfo">
		    <input type="hidden" name="page" value="seller">
		    <input type="hidden" name="info" value="<?= $info ?>">
		    <label for="newinfo">Modifica:</label>
		    <input type="text" name="newInfo" id="newinfo" value="<?= $info ?>"/>
		    <input type="submit" value="Modifica"/>
		</form>
<?php
}else{	
	if(isset($isOk) && $isOk==false){
	    $isOk=true;
	}	?>

	<p id="main_p">Informazioni su di te:</p>

	<div id="info">
	    <table>
		<col class="odd"/>
		<col class="even"/>

		<tr>
	    	    <th>Ruolo:</th>
		    <td><?php if($user->getRole()==1){echo "Venditore";}else{echo "Compratore";} ?></td>
	    	</tr>
		<tr>
	    	    <th>Nome:</th>
		    <td><?= $user->getName() ?></td>
		    <td><a href="seller?cmd=modify&info=name">Modifica</a></td>
	    	</tr>
		<tr>
	    	    <th>Cognome:</th>
		    <td><?= $user->getSurname() ?></td>
		    <td><a href="seller?cmd=modify&info=surname">Modifica</a></td>
	    	</tr>
		<tr>
	    	    <th>Username:</th>
		    <td><?= $user->getUsername() ?></td>
		    <td><a href="seller?cmd=modify&info=username">Modifica</a></td>
	    	</tr>
		<tr>
	    	    <th>Citt&agrave:</th>
		    <td><?= $user->getCity() ?></td>
		    <td><a href="seller?cmd=modify&info=city">Modifica</a></td>
	    	</tr>
		<tr>
	    	    <th>Indirizzo:</th>
		    <td><?= $user->getAddress() ?></td>
		    <td><a href="seller?cmd=modify&info=address">Modifica</a></td>
	    	</tr>
		<tr>
	    	    <th>Email:</th>
		    <td><?= $user->getEmail() ?></td>
		    <td><a href="seller?cmd=modify&info=email">Modifica</a></td>
	    	</tr>
	
	    </table>
	</div>
<?php }	?>
