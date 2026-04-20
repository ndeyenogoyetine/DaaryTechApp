  <!-- begin login -->
    <div class="login login-v1">
        <div class="login-container">

            <!-- Header -->
            <div class="login-header">
                <div class="brand">
                    <span class="logo"></span> <b>Connexion</b> 
                    <small>Bienvennie sur Daaray Technologie App</small>
                </div>
                <div class="icon">
                </div>
            </div>

            <!--  Form -->
            <div class="login-body">
                <div class="login-content">
                    <form action="UserMainController" method="post" id="loginForm" class="margin-bottom-0">
                        <!-- Email -->
                        <div class="form-group m-b-20">
                            <input type="email" id="email"  name="email" class="form-control form-control-lg inverse-mode" placeholder="Email Address" required />
                            <p class="error-message"></p>
                        </div>

                        <!-- Password -->
                        <div class="form-group m-b-20">
                            <input type="password" id="password"  name="password" class="form-control form-control-lg inverse-mode" placeholder="Password" required />
                             <p class="error-message"></p>

                        </div>

                        <!-- Remember Me -->
                        <div class="checkbox checkbox-css m-b-20">
                            <input type="checkbox" id="remember_checkbox" name="remember" />
                            <label for="remember_checkbox"> Remember Me</label>
                        </div>
                        <div class="login-buttons">
                            <button type="submit" id="btnSubmit"name="frmLogin" class="btn btn-success btn-block btn-lg"> Connexion</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>