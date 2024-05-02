<?php
include_once "config/config.class.php";

$Conf = new stdClass(); // Objet vide

$Conf->DBHost = Config::$DBHost ?? "localhost";
$Conf->DBName = Config::$DBName ?? "mydatabase";
$Conf->DBUser = Config::$DBUser ?? "root";
$Conf->DBPwd = Config::$DBPwd ?? "root";

$Conf->titreOnglet = Config::TITREONGLET;
$Conf->nomSite = Config::NOMSITE;

$uriParts = parse_url($_SERVER['REQUEST_URI']);

if (isset($uriParts['query'])) {
    // Divisez les paramètres de la chaîne de requête en un tableau associatif
    parse_str($uriParts['query'], $queryParams);

    // Supprimez la variable lang si elle existe
    unset($queryParams['lang']);

    // Réassemblez les paramètres de la chaîne de requête sans la variable lang
    $queryString = http_build_query($queryParams);

    // Reconstruire l'URI sans la variable lang
    if (!empty($queryString)) {
        $lienActuel = $uriParts['path'] . '?' . $queryString . '&';
    } else {
        $lienActuel = $uriParts['path'] . '?';
    }
} else {
    $lienActuel = $uriParts['path'] . '?';
}


if (isset($_SESSION['admin'])) {
    $Conf->menu = '<nav role="navigation" id="navig">
                        <div id="menuToggle">
                            <input type="checkbox" />
                            <span></span>
                            <span></span>
                            <span></span>
                            <ul id="menu">
                                <li class="sur cote">
                                    <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                                    </svg>
                                    <a href="index.php?action=reservationAdmin" class="menu0"></a>
                                </li>
                                <li class="sur cote">
                                    <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                                    </svg>
                                    <a href="index.php?action=aventuresAdmin" class="menu1"></a>
                                </li>
                                <li class="sur cote">
                                    <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                                    </svg>
                                    <a href="index.php?action=cadeauxAdmin" class="menu2"></a>
                                </li>
                                <li class="sur cote">
                                    <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                                    </svg>
                                    <a href="index.php?action=infoGenAdmin" class="menu3"></a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                    <a href="index.php?action=acceuilAdmin" class="logo"><img src="img/Kaiserstuhl-Escape-v1.png" id="logo_header"></a>
                    <div>
                        <div class="sur">
                            <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                            </svg>
                            <a href="index.php?action=reservationAdmin" class="menu0"></a>
                        </div>
                        <div class="sur">
                            <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                            </svg>
                            <a href="index.php?action=aventuresAdmin" class="menu1"></a>
                        </div>
                        <div class="sur">
                            <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                            </svg>
                            <a href="index.php?action=cadeauxAdmin" class="menu2"></a>
                        </div>
                        <div class="sur">
                            <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                            </svg>
                            <a href="index.php?action=infoGenAdmin" class="menu3"></a>
                        </div>
                        <nav id="choixlang">
                            <a href="' . $lienActuel . 'lang=de" id="lg1" class="langue" data-langue="de">DE</a>
                            <a href="' . $lienActuel . 'lang=en" data-langue="en">EN <img class="Picone" src="img/fleche.svg"></a>
                            <a href="' . $lienActuel . 'lang=fr" class="langue"  data-langue="fr">FR</a>
                        </nav>
                        <a href="index.php?action=login"><img class="icone" src="img/compte.svg"></a>
                    </div>';

    $Conf->footer = '<a href="index.php?action=acceuilAdmin" class="logo"><img src="img/Kaiserstuhl-Escape-v1.png" class="logo"></a>
                        <section>
        <h4 class="footitre1"></h4>
        <p class="ftexte1"></p>
    </section><section>
    <h4 class="footitre2"></h4>
    <a href="#" class="ftexte2"></a>
    <a href="index.php?action=contact" class="ftexte3"></a>
    <a href="index.php?action=mentleg" class="ftexte4"></a>
    <a href="index.php?action=confidentiality" class="ftexte5"></a>
    <a href="index.php?action=cgv" class="ftexte6"></a>
</section>
<section>
    <h4 class="footitre3"></h4>
    <a href="#" class="ftexte7"></a>
    <a href="index.php?action=FAQ" class="ftexte8"></a>
    <a href="index.php?action=aventures" class="ftexte9"></a>
    <a href="index.php?action=cadeaux" class="ftexte10"></a>
    <a href="#" class="ftexte11"></a>
    </section>';
} else if (isset($_SESSION['membre'])) {
    $Conf->menu = '<nav role="navigation" id="navig">
    <div id="menuToggle">
        <input type="checkbox" />
        <span></span>
        <span></span>
        <span></span>
        <ul id="menu">
            <li class="sur cote">
                <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                </svg>
                <a href="index.php?action=aventures" class="menu1"></a>
            </li>
            <li class="sur cote">
                <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                </svg>
                <a href="index.php?action=cadeaux" class="menu2"></a>
            </li>
            <li class="sur cote">
                <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                </svg>
                <a href="index.php?action=contact" class="menu3"></a>
            </li>
        </ul>
    </div>
</nav>
<a href="index.php" class="logo"><img src="img/Kaiserstuhl-Escape-v1.png" id="logo_header"></a>
<div>
    <div class="sur">
        <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
        </svg>
        <a href="index.php?action=aventures" class="menu1"></a>
    </div>
    <div class="sur">
        <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
        </svg>
        <a href="index.php?action=cadeaux" class="menu2"></a>
    </div>
    <div class="sur">
        <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
            <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
        </svg>
        <a href="index.php?action=contact" class="menu3"></a>
    </div>
    <nav id="choixlang">
        <a href="' . $lienActuel . 'lang=de" id="lg1" class="langue" data-langue="de">DE</a>
        <a href="' . $lienActuel . 'lang=en" data-langue="en">EN <img class="Picone" src="img/fleche.svg"></a>
        <a href="' . $lienActuel . 'lang=fr" class="langue"  data-langue="fr">FR</a>
    </nav>
    <a href="index.php?action=acceuilMembre"><img class="icone" src="img/compte.svg"></a>
</div>';

    $Conf->footer = '<a href="index.php?action=acceuilMembre" class="logo"><img src="img/Kaiserstuhl-Escape-v1.png" class="logo"></a>
    <section>
        <h4 class="footitre1"></h4>
        <p class="ftexte1"></p>
    </section><section>
    <h4 class="footitre2"></h4>
    <a href="#" class="ftexte2"></a>
    <a href="index.php?action=contact" class="ftexte3"></a>
    <a href="index.php?action=mentleg" class="ftexte4"></a>
    <a href="index.php?action=confidentiality" class="ftexte5"></a>
    <a href="index.php?action=cgv" class="ftexte6"></a>
</section>
<section>
    <h4 class="footitre3"></h4>
    <a href="#" class="ftexte7"></a>
    <a href="index.php?action=FAQ" class="ftexte8"></a>
    <a href="index.php?action=aventures" class="ftexte9"></a>
    <a href="index.php?action=cadeaux" class="ftexte10"></a>
    <a href="#" class="ftexte11"></a>
    </section>';
} else {
    $Conf->menu = '<nav role="navigation" id="navig">
                    <div id="menuToggle">
                        <input type="checkbox" />
                        <span></span>
                        <span></span>
                        <span></span>
                        <ul id="menu">
                            <li class="sur cote">
                                <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                                </svg>
                                <a href="index.php?action=aventures" class="menu1"></a>
                            </li>
                            <li class="sur cote">
                                <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                                </svg>
                                <a href="index.php?action=cadeaux" class="menu2"></a>
                            </li>
                            <li class="sur cote">
                                <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                                </svg>
                                <a href="index.php?action=contact" class="menu3"></a>
                            </li>
                        </ul>
                    </div>
                </nav>
                <a href="index.php" class="logo"><img src="img/Kaiserstuhl-Escape-v1.png" id="logo_header"></a>
                <div>
                    <div class="sur">
                        <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                        </svg>
                        <a href="index.php?action=aventures" class="menu1"></a>
                    </div>
                    <div class="sur">
                        <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                        </svg>
                        <a href="index.php?action=cadeaux" class="menu2"></a>
                    </div>
                    <div class="sur">
                        <svg width="70" height="5" viewBox="0 0 51 5" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <line y1="2.5" x2="70" y2="2.5" stroke="#FFAE00" stroke-width="5"/>
                        </svg>
                        <a href="index.php?action=contact" class="menu3"></a>
                    </div>
                    <nav id="choixlang">
                        <a href="' . $lienActuel . 'lang=de" id="lg1" class="langue" data-langue="de">DE</a>
                        <a href="' . $lienActuel . 'lang=en" data-langue="en">EN <img class="Picone" src="img/fleche.svg"></a>
                        <a href="' . $lienActuel . 'lang=fr" class="langue"  data-langue="fr">FR</a>
                    </nav>
                    <a href="index.php?action=login"><img class="icone" src="img/compte.svg"></a>
                </div>';

    $Conf->footer = '<a href="index.php?action=acceuilAdmin" class="logo"><img src="img/Kaiserstuhl-Escape-v1.png" class="logo"></a>
                        <section>
        <h4 class="footitre1"></h4>
        <p class="ftexte1"></p>
    </section><section>
    <h4 class="footitre2"></h4>
    <a href="#" class="ftexte2"></a>
    <a href="index.php?action=contact" class="ftexte3"></a>
    <a href="index.php?action=mentleg" class="ftexte4"></a>
    <a href="index.php?action=confidentiality" class="ftexte5"></a>
    <a href="index.php?action=cgv" class="ftexte6"></a>
</section>
<section>
    <h4 class="footitre3"></h4>
    <a href="#" class="ftexte7"></a>
    <a href="index.php?action=FAQ" class="ftexte8"></a>
    <a href="index.php?action=aventures" class="ftexte9"></a>
    <a href="index.php?action=cadeaux" class="ftexte10"></a>
    <a href="#" class="ftexte11"></a>
    </section>';
}
