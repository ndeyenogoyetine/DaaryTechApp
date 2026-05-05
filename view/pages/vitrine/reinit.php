    <!DOCTYPE html>
    <html lang="en">

    <!-- ================== Section head ================== -->
    <?php require_once("../../sections/login/head.php"); ?>

    <body class="pace-top">
        <!-- ================== Section Loader ================== -->
        <?php require_once("../../sections/login/loader.php"); ?>

       <?php 
        session_start();
        if (!isset($_SESSION['code'])) {  
        header("Location: reinitEmail?error=1&message=" . urlencode("Lien corompu") . "&title=" . urlencode("Accès Interdit !"));
        }
       ?>

        <div id="page-container" class="fade">

            <div class="login login-v1">
                <div class="login-container">

                    <!-- Header -->
                    <div class="login-header">
                        <div class="brand">
                            <span class="logo"></span> <b>Reinitialisation</b>
                            <small class="ml-5">Reinitialisation du mot de passe</small>
                        </div>
                        <div class="icon"></div>
                        <i class="fa fa-lock"></i>
                    </div>
        
                    <!-- Form -->
                    <div class="login-body"> 
                        <div class="login-content">
                            <form action="UserMainController" method="post" id="reinitPassWordForm" class="margin-bottom-0">

                            <!--  le nouveau mot de passe -->
                            <div class="form-group">
                                <label for="new_password"> Nouveau mot de passe</label>
                                <input type="password" name="new_password" class="form-control" id="new_password" placeholder=" Entrez le nouveau mot de passe " required>
                                <p class="error-message mt-2"></p>
                            </div>

                            <!--  Mot de passe de confirmation -->
                            <div class="form-group">
                                <label for="confirme_password">confirme le mot de passe actuel</label>
                                <input type="password" name="confirme_password" class="form-control" id="confirme_password" placeholder=" Confirmer le nouveau mot de passe " required>
                                <p class="error-message mt-2"></p>
                            </div>
                                <div class="login-buttons">
                                    <button type="submit" id="btnSubmitReinit" name="frmreinitPassWord" class="btn btn-success btn-block btn-lg">
                                        Confirmer
                                    </button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>

            <!-- ================== Section Config ================== -->
            <?php require_once("../../sections/login/config.php"); ?>

            <a href="javascript:" class="btn btn-icon btn-circle btn-success btn-scroll-to-top fade" data-click="scroll-top"><i class="fa fa-angle-up"></i></a>
        </div>
        <!-- ================== Section Javascript ================== -->
        <?php require_once("../../sections/login/script.php"); ?>
        <!-- ================== Section Message D'Ereur ================== -->
        <?php require_once("../../sections/admin/msgErrorSuccess.php"); ?>

    </body>

    </html>