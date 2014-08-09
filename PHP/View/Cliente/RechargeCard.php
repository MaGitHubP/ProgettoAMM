<?php
    if(isset($isOk) && $isOk==false){
	$isCodeOk=true;
    }
?>

<p id="main_p">Questo sito permette di collegarsi col proprio conto in banca per spostare i soldi nella carta di credito ricaricabile.</p>
<p id="main_p">Scegli quanti soldi vuoi aggiungere nella tua carta.</p>
<br/>

<form method="post" action="recharge" id="recharge">
    <input type="hidden" name="cmd" value="recharge"/>
    <input type="hidden" name="page" value="buyer"/>
    <label for="code">Codice carta:</label>
    <input type="text" name="code" id="code"/>
    <br/>
    <label for="plus_money">Ricarica €:</label>
    <input type="text" name="plus_money" id="plus_money"/>
    <br/>
    <input type="submit" value="Ricarica"/>
</form>
