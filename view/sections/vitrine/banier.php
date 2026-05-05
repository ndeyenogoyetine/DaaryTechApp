<div id="home" class="content has-bg home">
    <!-- begin content-bg -->
    <div class="content-bg" style="background-image: url(public/templates/templateVitrine/assets/img/bg/bg-home.jpg);" 
        data-paroller="true" 
        data-paroller-factor="0.5"
        data-paroller-factor-xs="0.25">
    </div>
    <!-- end content-bg -->
    <!-- begin container -->
    <div class="container home-content">
        <h1>Welcome to Daary Technologie</h1>
        <h3>L'innovation au Service de Votre Réussite Digitale</h3>
        <p>
           Spécialistes en développement web, mobile, design graphique et accompagnement digital, Nous transformons vos idées en solutions Technologie
           sur mesure.
           Faites le choix de l'excellence pour booster votre présence numérique.
        </p>
        <a href="https://www.youtube.com/@daaraytechnologie2900" target="_blank" class="btn btn-theme btn-primary">Caine youtube</a> 
        <a href="#" class="btn btn-theme btn-outline-white">Commencer</a><br />
        <br />
        <!-- ✅ CORRIGÉ : data-toggle et data-target pour Bootstrap 4 -->
        or <a href="#" data-toggle="modal" data-target="#modal-add-newsletter">subscribe</a> newsletter
    </div>
    <!-- end container -->
</div>


<!-- ================== Modal Add Newsletter ================== -->
<div class="modal fade" id="modal-add-newsletter" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">S'inscrire à la newsletter</h4>
                <!-- ✅ CORRIGÉ : data-dismiss pour Bootstrap 4 -->
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <form action="newsletterMainController" method="post" id="addNewsletterFrom">
                    
                    <!-- Email -->
                    <div class="form-group">
                        <label for="newsletter-email">Email</label>
                        <input type="email" name="newsletter-email" class="form-control" id="newsletter-email" placeholder="Entrez votre email" required>
                        <p class="error-message mt-2"></p>
                    </div>
                    
                    <!-- Soumission -->
                    <div style="display: flex; justify-content: center;">
                        <!-- ✅ CORRIGÉ : "S'inscrire" au lieu de "S'inscri" -->
                        <button type="submit" name="frmAddNewsletter" class="btn btn-primary fw-bold">S'inscrire</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>