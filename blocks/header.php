<header>
    <nav class="navbar navbar-expand-lg  position-fixed w-100 <?php
    if (array_key_exists("headear",$_GET)) {
        echo ('nav-bleu');
    }
    ?>">
        <div class="container-fluid">
            <a class="navbar-brand" href="index.php">
                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="120px" height="30px" viewBox="0 0 120 30" version="1.1" class="injected-svg js-svg-inject">
                    <!-- Generator: Sketch 49.1 (51147) - http://www.bohemiancoding.com/sketch -->
                    <title>Logos / F1-logo red</title>
                    <desc>Created with Sketch.</desc>
                    <defs>
                        <path d="M101.086812,30 L101.711812,30 L101.711812,27.106875 L101.722437,27.106875 L102.761812,30 L103.302437,30 L104.341812,27.106875 L104.352437,27.106875 L104.352437,30 L104.977437,30 L104.977437,26.25125 L104.063687,26.25125 L103.055562,29.18625 L103.044937,29.18625 L102.011187,26.25125 L101.086812,26.25125 L101.086812,30 Z M97.6274375,26.818125 L98.8136875,26.818125 L98.8136875,30 L99.4699375,30 L99.4699375,26.818125 L100.661812,26.818125 L100.661812,26.25125 L97.6274375,26.25125 L97.6274375,26.818125 Z M89.9999375,30 L119.999937,0 L101.943687,0 L71.9443125,30 L89.9999375,30 Z M85.6986875,13.065 L49.3818125,13.065 C38.3136875,13.065 36.3768125,13.651875 31.6361875,18.3925 C27.2024375,22.82625 20.0005625,30 20.0005625,30 L35.7324375,30 L39.4855625,26.246875 C41.9530625,23.779375 43.2255625,23.52375 48.4068125,23.52375 L75.2405625,23.52375 L85.6986875,13.065 Z M31.1518125,16.253125 C27.8774375,19.3425 20.7530625,26.263125 16.9130625,30 L-6.25e-05,30 C-6.25e-05,30 13.5524375,16.486875 21.0849375,9.0725 C28.8455625,1.685 32.7143125,0 46.9486875,0 L98.7643125,0 L87.5449375,11.21875 L48.0011875,11.21875 C37.9993125,11.21875 35.7518125,11.911875 31.1518125,16.253125 Z" id="path-1"/>
                    </defs>
                    <g id="Logos-/-F1-logo-red" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd">
                        <g id="Page-1">
                            <mask id="mask-2" fill="white">
                                <use xlink:href="#path-1"/>
                            </mask>
                            <use id="Fill-1" fill="white" xlink:href="#path-1"/>
                        </g>
                    </g>
                </svg>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-between" id="navbarNavDropdown">
                <ul class="navbar-nav">
                    <div class="navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle no-border ps-0 <?php
                                if(!array_key_exists("user",$_SESSION)){
                                    echo("disabled");
                                }
                                ?>" data-bs-toggle="dropdown" aria-expanded="false">
                                    Menu Admin
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <?php
                                    if(array_key_exists("user",$_SESSION)) {
                                        echo('<li><a class="text-decoration-none d-flex flex-column dropdown-item" href="admin.php">Ajouter un membre</a></li>
                                              <li><a class="dropdown-item" href="destroy.php">Se déconnecter</a></li>');
                                    }
                                    ?>
                                </ul>
                            </li>
                        </ul
                    </div>
                    <div class="navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle no-border ps-0" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filtré par poste
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php?postes=Attaquant">Attaquant</a>
                                    </li>
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php?postes=Défenseur">Défenseur</a>
                                    </li>
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php?postes=Gardien">Gardien</a>
                                    </li>
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php?postes=Milieu">Milieu</a>
                                    </li>
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php">Pas de Filtre</a>
                                    </li>
                                </ul>
                            </li>
                        </ul
                    </div>
                    <div class="navbar-collapse" id="navbarNavDarkDropdown">
                        <ul class="navbar-nav">
                            <li class="nav-item dropdown">
                                <button class="btn btn-dark dropdown-toggle no-border ps-0" data-bs-toggle="dropdown" aria-expanded="false">
                                    Filtré par age
                                </button>
                                <ul class="dropdown-menu dropdown-menu-dark">
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php?ages=DESC">DESC</a>
                                    </li>
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php?ages=ASC">ASC</a>
                                    </li>
                                    <li>
                                        <a class="text-decoration-none d-flex flex-column dropdown-item" href="index.php">Pas de Filtre</a>
                                    </li>
                                </ul>
                            </li>
                        </ul
                    </div>
                </ul>
                <ul class="navbar-nav align-items-lg-end">
                    <li class="nav-item text-lg-center text-start d-flex align-items-center">
                        <?php
                        if(array_key_exists("user",$_SESSION)) {
                            echo ('<a class="nav-link btn-ajouter" href="admin.php">Ajouter un membre</a>
                               <img src="assets/charles-leclerc-ferrari-1.jpg" alt="">');

                        }else {
                            echo ('<svg width="46" height="46" fill="#fff" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                     <path d="M12 6c1.1 0 2 .9 2 2s-.9 2-2 2-2-.9-2-2 .9-2 2-2Zm0 10c2.7 0 5.8 1.29 6 2H6c.23-.72 3.31-2 6-2Zm0-12C9.79 4 8 5.79 8 8s1.79 4 4 4 4-1.79 4-4-1.79-4-4-4Zm0 10c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4Z"></path>
                                    </svg><a class="nav-link" href="connection.php?headear=blue">Me connecter</a>');
                        }
                        ?>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</header>
