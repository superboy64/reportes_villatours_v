
<link rel="stylesheet" href="<?php echo base_url(); ?>referencias/css/style_login.css">
<body>
    
    <div class="container">

        
        <div class="card card-container" style="background-color: #344372; color:#FEFEFE; background-color: rgba(54, 67, 113, 0.8); color:#414a6c;">
            <center><label style="background-color: #fff;-webkit-border-radius: 21px 28px;width: 254px;">
                <img id="profile-img" class="profile-img-card" style="width: 212px; height: 48px;" src="<?php echo base_url(); ?>referencias/img/villatours.png"/>
            </label></center>
            <!-- <img class="profile-img-card" src="//lh3.googleusercontent.com/-6V8xOA6M7BA/AAAAAAAAAAI/AAAAAAAAAAA/rzlHcD0KYwo/photo.jpg?sz=120" alt="" /> -->
            <p id="profile-name" class="profile-name-card"></p>
           
                <span id="reauth-email" class="reauth-email"></span>
                <input type="text" id="txt_usuario" name="txt_usuario" class="form-control" placeholder="Usuario" required autofocus>
                <br>
                <input type="password" id="txt_password" name="txt_password" class="form-control" placeholder="Contraseña" required>
                <div id="remember" class="checkbox">
                    <label style="color:#fff;">
                        <input type="checkbox" value="remember-me"> Recordarme
                    </label>
                </div>
                <button class="btn btn-lg btn-primary btn-block btn-signin" onclick="validar_usuario();">Sign in</button>
            
            <a href="#" class="forgot-password">
                Recuperar contraseña?
            </a>
        </div><!-- /card-container -->


    </div><!-- /container -->
    
    <div class="posted-by" style="background-color: #fff;-webkit-border-radius: 21px 28px;">Posted By: <a href="http://www.jquery2dotnet.com">www.villatours.com.mx/</a></div>

</body>

<script src="<?php echo base_url(); ?>referencias/js/script_login.js"></script>
