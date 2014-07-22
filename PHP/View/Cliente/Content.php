<?php
    switch($view->getSubPage()){
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
    
<p>Benvenuto, <strong>Mauro</strong>!</p>
<p>Attualmente hai n€ a disposizione, e hai n prodotti nel carrello.</p>
<p>Scegli cosa fare fra le possibilità elencate qui sotto.</p>

<ul class="panel">
    <li><a href="buyer?subpage=see&genre=all&console=all" id="see">Visualizza merce</a></li>
    <li><a href="buyer?subpage=recharge" id="recharge">Ricarica</a></li>
    <li><a href="buyer?subpage=cart" id="cart">Carrello</a></li>
</ul>

<?php
    break;
    }
?>
