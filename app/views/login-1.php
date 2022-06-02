<body>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
            <div class="login-panel">
            <h1 align="center" class="login-area">আমার Manager</h1>
                <h3 align="center"></h3>
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <h3 class="panel-title" align="center">Sign In</h3>
                    </div>
                    <div class="panel-body">
                    <p align="center" style="color:red"><?php echo (isset($data['msg'])? $data['msg']:''); ?></p>
                        <form role="form" action="<?php echo BASE_URL; ?>main/loginVerify/" method="POST">
                            <fieldset>
                                <div class="form-group">
                                    <input class="form-control" placeholder="E-mail or Phone or Username" name="login" type="text" value="<?php echo (isset($_SESSION['temp'])? $_SESSION['temp']:''); ?>" autofocus>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" placeholder="Password" id="password" name="password" type="password" value="">
                                    <!--<input class="form-control" placeholder="Password" id="passwordDummy" name="passwordDummy" type="text" value="">-->
                                </div>
                                <button class="btn btn-lg btn-primary btn-block">Sign In</button>
                                <br>
                                <p align="right"><a href="">Forget Password?</a></p>
                            </fieldset>
                        </form>
                        <?php $_SESSION['temp'] = ''; ?>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </div>
</body>