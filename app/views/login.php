 <body>
     <script>
         document.getElementsByTagName('link')[0].disabled = true; 
         document.getElementsByTagName('link')[5].disabled = true; 
     </script>
    <div class="container ">
      <div class="d-flex justify-content-center ">
        <img src="<?php echo BASE_URL; ?>/asset/logo-75.png" height="75px" class="my-5" alt="">
        </div>
      
        <div class="d-flex justify-content-center ">
            <div class="card" style="box-shadow: 0 4px 12px rgb(0 0 0 / 15%); width: 352px;">
                <div class="card-body">
                  <h1 class="display-6 pb-3">Sign In</h1>
                    <h3>Shohug Enterprise!</h3>
                   <p align="center" style="color:#cc0000; font-weight: 600"><?php echo (isset($data['msg'])? $data['msg']:''); ?></p>
                  <form role="form" action="<?php echo BASE_URL; ?>main/loginVerify/" method="POST">
                    <div class="mb-3">
                      <label class="form-label">Username</label>
                      <input type="text" name="login" class="form-control form-control-lg" placeholder="Enter your username" value="<?php echo (isset($_SESSION['temp'])? $_SESSION['temp']:''); ?>" autofocus>
                    </div>
                    <div class="mb-3">
                      <label class="form-label">Password</label>
                      <input  name="password" type="password" value="" class="form-control form-control-lg" placeholder="Enter your password">
                    </div>
                    <a href="#" class="" style="text-decoration: solid; font-weight: 600;">Forgot Password?</a>
                    <div class="d-grid gap-2 mt-3 mb-3">
                      <button type="submit" class="btn btn-primary"  style="background-color: #0258ad; border-color: #0258ad;" type="button">Sign In</button>
                    </div>
                  </form>
                </div>
              </div>
        </div>
        
    </div>
</body>