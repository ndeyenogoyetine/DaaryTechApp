	<div id="sidebar" class="sidebar">
			<!-- begin sidebar scrollbar -->
			<div data-scrollbar="true" data-height="100%">
				<!-- begin sidebar user -->
				<ul class="nav">
					<li class="nav-profile">
						<a href="javascript:;" data-toggle="nav-profile">
							<div class="cover with-shadow"></div>
							<div class="image">
								<img src="public/images/users/<?= $photo ?>" alt="" />
							</div>
							<div class="info">
								<b class="caret pull-right"></b><?= $nom ?>
								<small><?= $email ?></small>
							</div>
						</a>
					</li>
					<li>
						<ul class="nav nav-profile">
							<li><a href="javascript:;"><i class="fa fa-cog"></i> Settings</a></li>
							<li><a href="javascript:;"><i class="fa fa-pencil-alt"></i> Send Feedback</a></li>
							<li><a href="javascript:;"><i class="fa fa-question-circle"></i> Helps</a></li>
						</ul>
					</li>
				</ul>
				<ul class="nav"><li class="nav-header">Navigation</li>
				<!-- Dashboaed -->
					<li class="has-sub active">
						<a href="javascript:;">
							<b class="caret"></b>
							<i class="fa fa-th-large"></i>
							<span>Dashboard</span>
						</a>
						<ul class="sub-menu">
							<li><a href="index.html">Dashboard</a></li>
						</ul>
					</li>
					<!-- profil -->
					<li class="has-sub">
						<a href="javascript:;">
							<span class="badge pull-right">10</span>
							<i class="fa fa-user-circle"></i>
							<span>Profil</span>
						</a>
					</li>
					<!-- service / Ra -->
					<li class="has-sub">
						<a href="listeServiceRea">
							<span class="badge pull-right">10</span>
							<i class="fa fa-cogs"></i>
							<span>Service / Réalisation</span>
						</a>
					</li>
					<!-- Contacts -->
					<li class="has-sub">
						<a href="listeContact">
							<span class="badge pull-right">10</span>
							<i class="fa fa-envelope"></i>
							<span>Contacts</span>
						</a>
					</li>
					<!-- Newsletter -->
					<li class="has-sub">
						<a href="listeNewsletter">
							<span class="badge pull-right">10</span>
							<i class="fa fa-envelope"></i>
							<span>Newsletter</span>
						</a>
					</li>
					<!-- user -->
					<li class="has-sub">
						<a href="listeUser">
							<span class="badge pull-right">10</span>
							<i class="fa fa-users"></i>
							<span>User</span>
						</a>
					</li>
					<!-- clients -->
					<li class="has-sub">
						<a href="javascript:;">
							<span class="badge pull-right">10</span>
							<i class="fa fa-user"></i>
							<span>Clients</span>
						</a>
					</li>
					
					<!-- Déconection -->
					<li class="has-sub">
						<a href="logout">
							<span class="badge pull-right">10</span>
							<i class="fa fa-sign-out-alt"></i>
							<span>Déconection</span>
						</a>
					</li>
					<li>
                        <a href="javascript:;" class="sidebar-minify-btn" data-click="sidebar-minify"> 
	                    <i class="fa fa-angle-double-left"></i></a>
					</li>
				</ul>
			</div>
		</div>
	<div class="sidebar-bg"></div>
