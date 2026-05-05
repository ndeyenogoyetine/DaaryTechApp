<div id="contact" class="content bg-silver-lighter" data-scrollview="true">
			<div class="container">
				<h2 class="content-title">Contactez-nous</h2>
				
				<div class="row">
					<!--  Info de contacte -->
					<div class="col-lg-6" data-animation="true" data-animation-type="fadeInLeft">
						<h3>Si vous avez un projet dont vous souhaitez discuter, n'hésitez pas à nous contacter..</h3>
						<p>
							Daaray Technologie est une entreprise d'ingéniorie et de developpement informatique !
						</p>
						    <p>
							   <strong>Ndeye Nogoye Tine</strong><br />
								Dakar, Grand Mbao<br />
								En face du lycée de Mbao<br />
								78 536 77 97<br />
						   </p>
						<p>
							<span class="phone">76 695 95 46</span><br />
							<a href="mailto:hello@emailaddress.com" class="text-primary">ndeyenogoyetine03@gmail.com</a>
						</p>
					</div>
					 <!--  Formulaire -->
					<div class="col-lg-6 form-col" data-animation="true" data-animation-type="fadeInRight">
						<form action="ContactMainController" method="post" class="form-horizontal" id="contactFrm" >
							<!-- Nom -->
							<div class="form-group row m-b-15">
								<label class="col-form-label col-lg-3 text-lg-right" for="nom">Nom <span class="text-primary">*</span></label>
								<div class="col-lg-9">
									<input type="text" name="nom" id="nom" placeholder="Entrez votre nom" class="form-control" />
									<p class="error-message mt-2"></p>
								</div>
						  	</div>
							<!-- Email -->
							<div class="form-group row m-b-15">
								<label class="col-form-label col-lg-3 text-lg-right" for="email">Email <span class="text-primary" >*</span></label>
								<div class="col-lg-9">
									<input type="email"  name="email" id="email" placeholder="Entrez votre email" class="form-control" />
									<p class="error-message mt-2"></p>
								</div>
							</div>
							<!-- Sujet -->
							<div class="form-group row m-b-15">
								<label class="col-form-label col-lg-3 text-lg-right" for="sujet">Sujet <span class="text-primary">*</span></label>
								<div class="col-lg-9">
									<input type="text" name="sujet" id="sujet" placeholder="De quoi sagit-it ?" class="form-control" />
									<p class="error-message mt-2"></p>
								</div>
							</div>
							<!-- Message -->
							<div class="form-group row m-b-15">
								<label class="col-form-label col-lg-3 text-lg-right" for="message">Message <span class="text-primary">*</span></label>
								<div class="col-lg-9">
									<textarea name="message" id="message" placeholder="Laissez votre message..." class="form-control" rows="4"></textarea>
									<p class="error-message mt-2"></p>
								</div>
							</div>
							<div class="form-group row m-b-15">
								<label class="col-form-label col-lg-3 text-lg-right"></label>
								<div class="col-lg-9 text-left">
									<button type="submit" name="frmContact" class="btn btn-theme btn-primary btn-block">Envoyé le Message</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>