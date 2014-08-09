<?php
    if(isset($signupError) && $signupError==true){
	$signupError=false;
    }
?>

<p id="main_p">Benvenuto!Inserisci i tuoi dati nel form qui sotto per iscriverti.</p>

<div id="form">
    <form method="post" action="sign_up">
    	<input type="hidden" name="cmd" value="sign_up"/>
	<input type="hidden" name="page" value="login"/>
	<input type="hidden" name="role" value="2"/>
	<table>
	    <tr>
    	    	<th><label for="username">Username:</label></th>
    	    	<td><input type="text" name="username" id="username"/></td>
	    </tr>
    	    <br/>
	    <tr>
    	    	<th><label for="password">Password:</label></th>
    	    	<td><input type="password" name="password" id="password"/></td>
	    </tr>
    	    <br/>
	    <tr>
	    	<th><label for="name">Nome:</label></th>
    	    	<td><input type="text" name="name" id="name"/></td>
	    </tr>
    	    <br/>
	    <tr>
	    	<th><label for="surname">Cognome:</label></th>
    	    	<td><input type="text" name="surname" id="surname"/></td>
	    </tr>
    	    <br/>
	    <tr>
	    	<th><label for="city">Città:</label></th>
    	    	<td><input type="text" name="city" id="city"/></td>
	    </tr>
    	    <br/>
	    <tr>
	    	<th><label for="address">Indirizzo:</label></th>
    	    	<td><input type="text" name="address" id="address"/></td>
	    </tr>
    	    <br/>
	    <tr>
	    	<th><label for="email">Email:</label></th>
    	    	<td><input type="text" name="email" id="email"/></td>
	    </tr>
    	    <br/>
	    <tr>
	    	<th><label for="code">Codice carta:</label></th>
    	    	<td><input type="text" name="code" id="code"/></td>
	    </tr>
    	    <br/>
	    <tr>
    	    	<td><input type="submit" name="login" value="Sign Up"/></td>
	    </tr>
	</table>
        
    </form>
</div>
