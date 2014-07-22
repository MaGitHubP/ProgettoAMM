<?php
    include_once 'ViewDescriptor.php';
    include_once basename(__DIR__) . '/../Settings.php';
?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
	<title><?= $view->getTitle() ?></title>
	<base href="<?= Settings::getApplicationPath() ?>PHP/index.php?page=<?= $view->getPage() ?>"/>
        <meta name="keywords" contents="Progetto di AMM."/>
        <meta name="description" contents="Sito per comprare e vendere videogiochi."/>
        <link href="../CSS/ProjectCSS.css" rel="stylesheet" type="text/css" media="screen" />
        
    </head>
    <body>
	<!--$view è una variabile che contiene un oggetto di classe ViewDescriptor.
	    ViewDescriptor contiene i vari "pezzi di codice" del sito, diversi per 
	    ogni ruolo dell'utente.Infatti l'interfaccia di una pagina web cambia 
	    se si è venditori, compratori o utenti non autenticati.-->
        <div id="page">
            <header>
                <!-- Qui viene posizionato l'header(Header.php).  -->
                <div class="header">
		    <div id="menu">
                        <?php
                            $header=$view->getHeader();
                            require "$header";
                        ?>
		    </div>

		    <div class="social">
                        <ul>
                            <li id="facebook"><a href="https://www.facebook.com">facebook</a></li>
                            <li id="twitter"><a href="https://twitter.com/">twitter</a></li>
                            <li id="youtube"><a href="http://www.youtube.com/">youtube</a></li>
                        </ul>
		    </div>
                </div>
                
                <!-- Qui viene posizionato il nav(Nav.php).  -->
                <div class="nav">
                    <div id="logo"><h1>GiochiAMMo</h1></div>
                    <div id="search">
                        <form method="post" action="search">
			    <input type="hidden" name="cmd" value="search"/>
			    <input type="hidden" name="page" value="<?= $view->getPage() ?>"/>
                            <label for="searchlist1">Genere</label>
                            <select name="genre" id="searchlist1">
                                <option value="all">All</option>
                                <option value="adventure">Adventure</option>
                                <option value="action">Azione</option>
                                <option value="fighting">Picchiaduro</option>
                                <option value="platform">Platform</option>
                                <option value="puzzle">Puzzle Game</option>
                                <option value="rpg">RPG</option>
                                <option value="simulation">Simulazione</option>
                                <option value="fps">Sparatutto</option>
                                <option value="sport">Sportivi</option>
                                <option value="strategy">Strategici</option>
                                <option value="horror">Survival Horror</option>
                            </select>
                            <label for="searchlist2">Piattaforma</label>
                            <select name="console" id="searchlist2">
                                <option value="all">All</option>
                                <option value="gb">Game Boy</option>
                                <option value="gba">Game Boy Advance</option>
                                <option value="gc">Game Cube</option>
                                <option value="3ds">Nintendo 3DS</option>
                                <option value="n64">Nintendo 64</option>
                                <option value="nds">Nintendo DS</option>
                                <option value="pc">PC</option>
                                <option value="psx">PlayStation 1</option>
                                <option value="ps2">PlayStation 2</option>
                                <option value="ps3">PlayStation 3</option>
                                <option value="ps4">PlayStation 4</option>
                                <option value="psvita">PS Vita</option>
                                <option value="psp">PSP</option>
                                <option value="xbox">XBox</option>
                                <option value="x360">XBox 360</option>
                                <option value="xone">XBox One</option>
                                <option value="wii">Wii</option>
                                <option value="wiiu">Wii U</option>
                            </select>
                            <input type="submit" value="Search"/>
                        </form>
                    </div>
                    <div id="log">
                        <?php
                            $log=$view->getLog();
                            require "$log";
                        ?>
                    </div>
                </div>
            </header>

	    <!--Qui viene posizionato la sidebar sinistra.-->
	    <div class="leftbar">
		<?php
		    $leftBar=$view->getLeftBar();
		    require "$leftBar";
		?>
	    </div>

	    <!--Qui viene posizionato il content.-->
	    <div class="content">
		<?php
                if ($view->getErrorMessage() != null) {
                ?>
                    <div class="error">
                        <div>
                            <?=
                            $view->getErrorMessage();
                            ?>
                        </div>
                    </div>
                <?php
                }
                ?>

	        <div id="boxcontent">
		    <?php
		        $content=$view->getContent();
		        require "$content";
		    ?>
		</div>
	    </div>

	    <div class="clear"></div>
            
            <!--Qui viene posizionato il footer.-->
	    <footer>
                <div class="footer">
                    <p>Nome:Mauro - Cognome:Pisano - Matricola:48406</p>
                
                    <ul>
                        <li id="facebook"><a href="www.facebook.com">facebook</a></li>
                        <li id="twitter"><a href="https://twitter.com/">twitter</a></li>
                        <li id="youtube"><a href="http://www.youtube.com/">youtube</a></li>
                    </ul>
                </div>
	    </footer>
        </div>
    </body>
</html>
