<?php
    switch($view->getSubPage()){
	case "profile":
	    include_once 'Profile.php';
	    break;
        case "see":
            include_once 'SeeGames.php';
            break;
        case "recharge":
            include_once 'RechargeCard.php';
            break;
        case "cart":
            include_once 'Cart.php';
            break;
        default:
?>
    
<p id="main_p">Benvenuto, <strong><?= $user->getUsername() ?></strong>!</p>
<p id="main_p">Attualmente hai <?= $user->getMoney() ?>€ a disposizione.</p>
<p id="main_p">Scegli cosa fare fra le possibilità elencate qui sotto.</p>

<ul class="panel">
    <li><a href="buyer?subpage=profile" id="profile">Profilo</a></li>
    <li><a href="buyer?subpage=see&genre=all&console=all&limit_index=0" id="see">Visualizza merce</a></li>
    <li><a href="buyer?subpage=recharge" id="recharge">Ricarica</a></li>
    <li><a href="buyer?subpage=cart&limit_index=0" id="cart">Carrello</a></li>
</ul>

<?php
    break;
    }
?>
