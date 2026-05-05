<div id="header" class="header navbar navbar-transparent navbar-fixed-top navbar-expand-lg">
			<!-- begin container -->
			<div class="container">
				<!--Parti logo -->
				<a href="home" class="navbar-brand">
					<span class="brand-logo"></span>
					<span class="brand-text">
						<span class="text-primary">Daaray</span> Technologie
					</span>
				</a>
				
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				
				<div class="collapse navbar-collapse" id="header-navbar">
					<ul class="nav navbar-nav navbar-right">
						<li class="nav-item dropdown">
							<a class="nav-link active" href="#home" data-click="scroll-to-target" data-scroll-target="#home">Accuel </a>
							
						</li>
						<li class="nav-item"><a class="nav-link" href="#about" data-click="scroll-to-target">A PROPOS</a></li>
						<li class="nav-item"><a class="nav-link" href="#team" data-click="scroll-to-target">EQUIPE</a></li>
						<li class="nav-item"><a class="nav-link" href="#service" data-click="scroll-to-target">SERVICES</a></li>
						<li class="nav-item"><a class="nav-link" href="#work" data-click="scroll-to-target">REALISATON</a></li>
						<li class="nav-item"><a class="nav-link" href="#client" data-click="scroll-to-target">TEMOIGNAGE</a></li>
						<li class="nav-item"><a class="nav-link" href="#pricing" data-click="scroll-to-target">PRICING</a></li>
						<li class="nav-item"><a class="nav-link" href="#contact" data-click="scroll-to-target">CONTACT</a></li>

						<?php  
						session_start();
						
						if (isset($_SESSION['email'])) :?>
						<li class="nav-item">
						<a class="nav-link" href="admin">
						<span class="brand-text">
						   Retour Vers <span class="text-primary">Amdin</span>
					   </span>
						</a>
					</li>
					<?php else : ?>
						<li class="nav-item"><a class="nav-link" href="login">CONNEXION</a></li>

					<?php endif?>
					</ul>
				</div>
			</div>
		</div>