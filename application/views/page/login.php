<!DOCTYPE html>
<!--[if IE 8]>
<html lang="en" class="ie8 no-js"> <![endif]-->
<!--[if IE 9]>
<html lang="en" class="ie9 no-js"> <![endif]-->
<!--[if !IE]><!-->
<html lang="en">
<!--<![endif]-->
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <title>CadProETC</title>
    <link rel='stylesheet' href='//fonts.googleapis.com/css?family=Roboto:100%2C100italic%2C300%2C300italic%2C400%2Citalic%2C500%2C500italic%2C700%2C700italic%2C900%2C900italic|Roboto+Slab:100%2C300%2C400%2C700&#038;subset=greek-ext%2Cgreek%2Ccyrillic-ext%2Clatin-ext%2Clatin%2Cvietnamese%2Ccyrillic'
          type='text/css' media='all'/>

    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/libraries/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/libraries/font-awesome/css/font-awesome.min.css">
    
    <link media="all" type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>assets/vendor/core/css/login.css">
</head>
    <body class=" login " style=" background-image: url(../HaukiemPN/assets/vendor/core/img/4.jpg); ">
        <div class="container-fluid">
            <div class="row">
                <div class="faded-bg animated"></div>
                <div class="hidden-xs col-sm-7 col-md-8">
                    <div class="clearfix">
                        <div class="col-sm-12 col-md-10 col-md-offset-2">
                            <div class="logo-title-container">
                                <div class="copy animated fadeIn">
                                    <h1>CadProETC - Hậu kiểm</h1>
                                    <p>Copyright 2022 © CadPro. Version: <span>1.0</span></p>
                                    <div class="copyright">
                                    </div>
                                </div>
                            </div> <!-- .logo-title-container -->
                        </div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-5 col-md-4 login-sidebar">
                    <div class="login-container">
                        <p>Sign In Below:</p>
                        <form action="<?php echo base_url(); ?>login" method="POST">
                            <?php if(validation_errors()) { ?>
                                <div class="alert alert-danger">
                                    <strong><?php echo strip_tags(validation_errors()); ?></strong>
                                </div>
                            <?php } ?>
                            <div class="form-group" id="emailGroup">
                                <label>Username</label>
                                <input class="form-control" placeholder="Username" name="username" type="text" value="">
                            </div>

                            <div class="form-group" id="passwordGroup">
                                <label>Password</label>
                                <input class="form-control" placeholder="Password" name="password" type="password" value="">
                            </div>
                            <div>
                                <label>
                                    <input class="hrv-checkbox" checked="checked" name="remember" type="checkbox" value="1"> Remember me?
                                </label>
                            </div>
                            <br>

                            <button type="submit" class="btn btn-block login-button">
                                <span class="signin">Sign in</span>
                            </button>
                            <div class="clearfix"></div>

                            <br>

                        </form>

                        <div style="clear:both"></div>

                    </div> <!-- .login-container -->

                </div> <!-- .login-sidebar -->
            </div> <!-- .row -->
        </div>
    </body>
</html>
