<?php
    switch($view->getSubPage()){
        case "see":
            include_once 'SeeGames.php';
            break;
        default:
?>
    
<p>Benvenuto!Dai un'occhiata ai videogiochi che offriamo.</p>
<ul class="panel">
    <li><a href="login?subpage=see&genre=all&console=all" id="see">Visualizza merce</a></li>
</ul>

<?php
    break;
    }
?>