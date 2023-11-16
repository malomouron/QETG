 <!-- premier bandeau ordi -->
	<div id="bandeau" class="bandeau">
	        	<div id="img1">
	        		<img src="/quiz/commun/icon.png" alt="icon du site" id="img">
	        	</div>
	        	<div id="menu">
	        		<span class="lien-bandeau" >
	        			<a href="index.php" class="bandeau-span">Accueil</a>
	        		</span>
<?php
	if (isset($_SESSION['login'])) {
		echo '<span class="lien-bandeau" ><a class="bandeau-span" href="deconnexion.php">Déconnexion</a></span>';
	} else {
		echo '	<span class="lien-bandeau" ><a class="bandeau-span" href="identifier.php">S\'identifier</a></span>
				<span class="lien-bandeau" ><a class="bandeau-span" href="inscription.php">Créer un compte</a></span>';
	}
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		echo '<span class="lien-bandeau" ><a class="bandeau-span" href="admin.php">Administrateur</a></span>';
	}
	if (isset($_SESSION['login'])) {
		echo '<span class="lien-bandeau" ><a class="bandeau-span" href="profil.php"><img src="commun/bouton-profil.png" id="img-prof-ico" alt="bouton profil">Profil</a></span>';
	}
	include('aide.php');
?>
                    <span class="lien-bandeau" >
			                <a href="quiz_utilisateur.php" class="bandeau-span">Quiz utilisateur</a>
                    </span>
                    <span class="lien-bandeau" >
                        <a href="poster_quiz.php" class="bandeau-span">Poster des quiz</a>
                    </span>
                    <span class="lien-bandeau">
	        			<a href="lien-bandeau/" class="bandeau-span">À propos de</a>
	        		</span>
<?php
	if (isset($_SESSION['login'])) {
		echo'		<form style="margin-inline-end: -352px;width: 33%;" class="form-search-bis" action="search.php" method="get">
						<input class="index-input" type="text" name="search" placeholder="Recherche..." autocomplete="off" value="">
						<svg viewBox="0 0 512 512">
							<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
						</svg>
					</form>';
	} else {
		echo'		<form class="form-search-bis" action="search.php" method="get">
						<input class="index-input" type="text" name="search" placeholder="Recherche..." autocomplete="off" value="">
						<svg viewBox="0 0 512 512">
							<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
						</svg>
					</form>';
	}
?>
	        	</div>
	        </div>
			 <!-- deusiéme bandeau tablette -->
			<nav id="nav1" role="navigation">
				<div id="menuToggle">
					<input class="index-input"  id="menuToggle-input" type="checkbox" />
					<span></span>
					<span></span>
					<span></span>
					<ul id="menu-gg-burg">
					<form class="form-search-bis" action="search.php" method="get">
							<input class="index-input" type="text" name="search" placeholder="Recherche..." autocomplete="off" value="">
							<svg viewBox="0 0 512 512">
								<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
							</svg>
						</form>
<?php
	if (isset($_SESSION['login'])) {
		echo '<a href="deconnexion.php"><li>Déconnexion</li></a>';
	} else {
		echo '	<a href="identifier.php"><li>S\'identifier</li></a>
				<a href="inscription.php"><li>Créer un compte</li></a>';
	}
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		echo '<a href="admin.php"><li>Administrateur</li></a>';
	}
	if (isset($_SESSION['login'])) {
		echo '<a href="profil.php"><li><img src="commun/bouton-profil.png" id="img-prof-ico" alt="bouton profil">Profil</li></a>';
	}
?>
						<a href="../"><li>Accueil</li></a>
                        <a href="quiz_utilisateur.php"><li>Quiz utilisateur</li></a>
                        <a href="poster_quiz.php"><li>Poster des quiz</li></a>
                        <a href="/quiz/lien-bandeau/"><li>À propos de Quiz dans tout genre</li></a>
                        <a href="aide-page.php"><li>Aide</li></a>
					</ul>
				</div>
			</nav>
			 <!-- troisiéme bandeau Téléphone -->
			<nav id="nav2" role="navigation">
				<div id="menuToggle">
					<input class="index-input" id="menuToggle-input" type="checkbox" />
					<span></span>
					<span></span>
					<span></span>
					<ul id="menu-gg-burg">
						<form class="form-search-bis" action="search.php" method="get">
							<input class="index-input" type="text" name="search" placeholder="Recherche..." autocomplete="off" value="">
							<svg viewBox="0 0 512 512">
								<path fill="currentColor" d="M505 442.7L405.3 343c-4.5-4.5-10.6-7-17-7H372c27.6-35.3 44-79.7 44-128C416 93.1 322.9 0 208 0S0 93.1 0 208s93.1 208 208 208c48.3 0 92.7-16.4 128-44v16.3c0 6.4 2.5 12.5 7 17l99.7 99.7c9.4 9.4 24.6 9.4 33.9 0l28.3-28.3c9.4-9.4 9.4-24.6.1-34zM208 336c-70.7 0-128-57.2-128-128 0-70.7 57.2-128 128-128 70.7 0 128 57.2 128 128 0 70.7-57.2 128-128 128z"></path>
							</svg>
						</form>
<?php
	if (isset($_SESSION['login'])) {
		echo '<a href="deconnexion.php"><li>Déconnexion</li></a>';
	} else {
		echo '	<a href="identifier.php"><li>S\'identifier</li></a>
				<a href="inscription.php"><li>Créer un compte</li></a>';
	}
	if (isset($_SESSION['login']) && $_SESSION['admin'] == 1) {
		echo '<a href="admin.php"><li>Administrateur</li></a>';
	}
	if (isset($_SESSION['login'])) {
		echo '<a href="profil.php"><li><img src="commun/bouton-profil.png" id="img-prof-ico" alt="bouton profil">Profil</li></a>';
	}
?>
						<a href="../"><li>Accueil</li></a>
                        <a href="quiz_utilisateur.php"><li>Quiz utilisateur</li></a>
                        <a href="poster_quiz.php"><li>Poster des quiz</li></a>
                        <a href="/quiz/lien-bandeau/"><li>À propos de Quiz dans tout genre</li></a>
                        <a href="aide-page.php"><li>Aide</li></a>
					</ul>
				</div>
			</nav>