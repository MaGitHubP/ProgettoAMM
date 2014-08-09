<?php
    if(isset($wrong_date) && $wrong_date==true){
	echo "Errore:La data che hai selezionato non esiste o contiene elementi che non sono interi.\n";
	$wrong_date=false;
    }
    if(isset($wrong_price) && $wrong_price==true){
	echo "Errore:Il prezzo che hai selezionato non &egrave un float.";
	$wrong_price=false;
    }
?>

<p id="main_p">Metti nel form qui sotto i dati e le informazioni del videogioco che vuoi aggiungere.</p>
<br/>

<form method="post" action="add" id="add_game">
    <input type="hidden" name="cmd" value="add"/>
    <input type="hidden" name="page" value="seller"/>
    <label for="title">Titolo:</label>
    <input type="text" name="title" id="title"/>
    <br/>
    <label for="genre">Genere:</label>
    <select name="genre" id="genre">
        <option value="Avventura">Adventure</option>
        <option value="Azione">Azione</option>
        <option value="Picchiaduro">Picchiaduro</option>
        <option value="Platform">Platform</option>
        <option value="Puzzle">Puzzle Game</option>
        <option value="RPG">RPG</option>
        <option value="Simulazione">Simulazione</option>
        <option value="Sparatutto">Sparatutto</option>
        <option value="Sportivo">Sportivi</option>
        <option value="Strategia">Strategici</option>
        <option value="Horror">Survival Horror</option>
    </select>
    <br/>
    <label for="console">Piattafroma:</label>
    <select name="console" id="console">
        <option value="GameBoy">Game Boy</option>
        <option value="GBA">Game Boy Advance</option>
        <option value="GameCube">Game Cube</option>
        <option value="3DS">Nintendo 3DS</option>
        <option value="N64">Nintendo 64</option>
        <option value="NDS">Nintendo DS</option>
        <option value="PC">PC</option>
        <option value="PSX">PlayStation 1</option>
        <option value="PS2">PlayStation 2</option>
        <option value="PS3">PlayStation 3</option>
        <option value="PS4">PlayStation 4</option>
        <option value="PSVita">PS Vita</option>
        <option value="PSP">PSP</option>
        <option value="XBox">XBox</option>
        <option value="X360">XBox 360</option>
        <option value="XOne">XBox One</option>
        <option value="Wii">Wii</option>
        <option value="WiiU">Wii U</option>
    </select>
    <br/>
    <label for="relase_date">Data di uscita:</label>
    <select name="r_d_day" id="relase_date">
	<option value="00">TBA</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
	<option value="12">12</option>
	<option value="13">13</option>
	<option value="14">14</option>
	<option value="15">15</option>
	<option value="16">16</option>
	<option value="17">17</option>
	<option value="18">18</option>
	<option value="19">19</option>
	<option value="20">20</option>
	<option value="21">21</option>
	<option value="22">22</option>
	<option value="23">23</option>
	<option value="24">24</option>
	<option value="25">25</option>
	<option value="26">26</option>
	<option value="27">27</option>
	<option value="28">28</option>
	<option value="29">29</option>
	<option value="30">30</option>
	<option value="31">31</option>
    </select>
    <select name="r_d_month" id="relase_date">
        <option value="00">TBA</option>
        <option value="01">01</option>
        <option value="02">02</option>
        <option value="03">03</option>
        <option value="04">04</option>
        <option value="05">05</option>
        <option value="06">06</option>
        <option value="07">07</option>
        <option value="08">08</option>
        <option value="09">09</option>
        <option value="10">10</option>
        <option value="11">11</option>
	<option value="12">12</option>
    </select>
    <input type="text" name="r_d_year" id="relase_date"/>
    <br/>
    <label for="price">Prezzo:</label>
    <input type="text" name="price" id="price"/>
    <br/>
    <label for="cover">Cover:</label>
    <input type="file" name="cover" id="cover"/>
    <br/>
    <input type="submit" value="Aggiungi!"/>
</form>
