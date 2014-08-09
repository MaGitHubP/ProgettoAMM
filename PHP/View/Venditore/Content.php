<?php
    switch($view->getSubPage()){
	case "profile":
	    include_once 'Profile.php';
	    break;
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
    
<p id="main_p">Benvenuto, <strong><?= $user->getUsername() ?></strong>!</p>
<p id="main_p">Scegli cosa fare fra le possibilità elencate qui sotto.</p>

<ul class="panel">
    <li><a href="seller?subpage=profile" id="profile">Profilo</a></li>
    <li><a href="seller?subpage=see&genre=all&console=all&limit_index=0" id="see">Visualizza merce</a></li>
    <li><a href="seller?subpage=add" id="add">Aggiungi</a></li>
    <li><a href="seller?subpage=delete&limit_index=0" id="delete">Togli</a></li>
</ul>

<?php
    break;
    }
?>
