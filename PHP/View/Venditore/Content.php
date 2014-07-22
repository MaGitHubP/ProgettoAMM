<?php
    switch($view->getSubPage()){
        case "see":
            include_once 'SeeGames.php';
            break;
        case "add":
            include_once 'AddGame.php';
            break;
        case "delete":
            include_once 'DeleteGames.php';
            break;
        default:
?>
    
<p>Benvenuto, <strong>Mauro</strong>!</p>
<p>Scegli cosa fare fra le possibilità elencate qui sotto.</p>

<ul class="panel">
    <li><a href="seller?subpage=see&genre=all&console=all" id="see">Visualizza merce</a></li>
    <li><a href="seller?subpage=add" id="add">Aggiungi</a></li>
    <li><a href="seller?subpage=delete" id="delete">Togli</a></li>
</ul>

<?php
    break;
    }
?>
