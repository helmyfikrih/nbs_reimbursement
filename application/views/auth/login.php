<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <meta charset="utf-8" />
    <title>Login Page - <?= $system['application_name'] ?></title>
    <link id="logo_icon" rel="shortcut icon" type="image/png" href="<?= base_url() ?>assets/images/icon/<?= $system['logo_icon'] ?>?x=<?= time() ?>" />
    <meta name="description" content="User login page" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />

    <!-- bootstrap & fontawesome -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="<?= base_url() ?>assets/font-awesome/4.5.0/css/font-awesome.min.css" />


    <link rel="stylesheet" href="<?= base_url() ?>assets/css/select2.min.css" />

    <!-- text fonts -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/fonts.googleapis.com.css" />

    <!-- ace styles -->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ace.min.css" />

    <!--[if lte IE 9]>
			<link rel="stylesheet" href="assets/css/ace-part2.min.css" />
		<![endif]-->
    <link rel="stylesheet" href="<?= base_url() ?>assets/css/ace-rtl.min.css" />

    <!--[if lte IE 9]>
		  <link rel="stylesheet" href="assets/css/ace-ie.min.css" />
		<![endif]-->

    <!-- HTML5shiv and Respond.js for IE8 to support HTML5 elements and media queries -->

    <!--[if lte IE 8]>
		<script src="assets/js/html5shiv.min.js"></script>
		<script src="assets/js/respond.min.js"></script>
        <![endif]-->

    <style>
        .swal2-popup {
            font-size: 1.6rem !important;
        }
    </style>
</head>

<body class="login-layout">
    <div class="main-container">
        <div class="main-content">
            <div class="row">
                <div class="col-sm-10 col-sm-offset-1">
                    <div class="login-container">
                        <div class="center">
                            <h1>
                                <img id="logo_header" src='<?= base_url("assets/images/icon/$system[logo_header]?x=") . time() ?>' style="width:50px;">
                                <!-- <span class="red">Ace</span> -->
                                <span class="white" id="id-text2"><?= $system['application_name'] ?></span>
                            </h1>
                            <!-- <h4 class="blue" id="id-company-text">&copy; Company Name</h4> -->
                        </div>

                        <div class="space-6"></div>

                        <div class="position-relative">
                            <div id="login-box" class="login-box visible widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header blue lighter bigger">
                                            <i class="ace-icon fa fa-key green"></i>
                                            Login
                                        </h4>

                                        <div class="space-6"></div>
                                        <?php
                                        if (isset($_GET['w'])) {
                                            echo '
                                            <div class="alert alert-block alert-danger">
                                            <button type="button" class="close" data-dismiss="alert">
                                                <i class="ace-icon fa fa-times"></i>
                                            </button>

                                            <i class="ace-icon fa fa-close red"></i>
                                            ' . $message . '
                                            </div>';
                                        }
                                        ?>

                                        <?php echo form_open_multipart('auth/verify', 'autocomplete="off"'); ?>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" class="form-control" placeholder="Username Or E-mail" name="username" />
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" class="form-control" placeholder="Password" name="password" />
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                            </label>

                                            <div class="space"></div>

                                            <div class="clearfix">
                                                <label class="inline" id="resendEmail">
                                                    <a href="#" data-target="#resend-box"><span class="lbl">Re-send E-mail Verifcation</span></a>
                                                </label>

                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-primary">
                                                    <i class="ace-icon fa fa-key"></i>
                                                    <span class="bigger-110">Login</span>
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </fieldset>
                                        </form>

                                        <!-- <div class="social-or-login center">
                                            <span class="bigger-110">Or Login Using</span>
                                        </div>

                                        <div class="space-6"></div>

                                        <div class="social-login center">
                                            <a class="btn btn-primary">
                                                <i class="ace-icon fa fa-facebook"></i>
                                            </a>

                                            <a class="btn btn-info">
                                                <i class="ace-icon fa fa-twitter"></i>
                                            </a>

                                            <a class="btn btn-danger">
                                                <i class="ace-icon fa fa-google-plus"></i>
                                            </a>
                                        </div> -->
                                    </div><!-- /.widget-main -->

                                    <div class="toolbar clearfix">
                                        <div>
                                            <a href="#" data-target="#forgot-box" class="forgot-password-link">
                                                <i class="ace-icon fa fa-arrow-left"></i>
                                                I forgot my password
                                            </a>
                                        </div>

                                        <div>
                                            <a href="#" data-target="#signup-box" class="user-signup-link">
                                                I want to register
                                                <i class="ace-icon fa fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.login-box -->

                            <div id="resend-box" class="forgot-box widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header red lighter bigger">
                                            <i class="ace-icon fa fa-envelope"></i>
                                            Retrieve E-mail Verification
                                        </h4>

                                        <div class="space-6"></div>
                                        <p>
                                            Enter your email to receive instructions
                                        </p>

                                        <?php echo form_open_multipart('auth/register/resendEmailVerify', 'id="resendEmailVerify" role="resendEmailVerify" autocomplete="off"'); ?>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="email" name="email" class="form-control" placeholder="Email" required />
                                                    <i class="ace-icon fa fa-envelope"></i>
                                                </span>
                                            </label>

                                            <div class="clearfix">
                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                    <i class="ace-icon fa fa-send"></i>
                                                    <span class="bigger-110">Send Me!</span>
                                                </button>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close(); ?>
                                    </div><!-- /.widget-main -->

                                    <div class="toolbar center">
                                        <a href="#" data-target="#login-box" class="back-to-login-link">
                                            Back to login
                                            <i class="ace-icon fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.forgot-box -->

                            <div id="forgot-box" class="forgot-box widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header red lighter bigger">
                                            <i class="ace-icon fa fa-key"></i>
                                            Reset Password
                                        </h4>

                                        <div class="space-6"></div>
                                        <p>
                                            Enter your email to receive instructions
                                        </p>

                                        <?php echo form_open_multipart('auth/verify/sendForgetPassword', 'id="forgotPassword" role="forgotPassword" autocomplete="off"'); ?>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="email" name="email" class="form-control" placeholder="Email" required />
                                                    <i class="ace-icon fa fa-envelope"></i>
                                                </span>
                                            </label>

                                            <div class="clearfix">
                                                <button type="submit" class="width-35 pull-right btn btn-sm btn-danger">
                                                    <i class="ace-icon fa fa-send"></i>
                                                    <span class="bigger-110">Send Me!</span>
                                                </button>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close(); ?>
                                    </div><!-- /.widget-main -->

                                    <div class="toolbar center">
                                        <a href="#" data-target="#login-box" class="back-to-login-link">
                                            Back to login
                                            <i class="ace-icon fa fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.forgot-box -->

                            <div id="signup-box" class="signup-box widget-box no-border">
                                <div class="widget-body">
                                    <div class="widget-main">
                                        <h4 class="header green lighter bigger">
                                            <i class="ace-icon fa fa-user blue"></i>
                                            New User Registration
                                        </h4>

                                        <div class="space-6"></div>
                                        <p> Enter your details to begin: </p>

                                        <?php echo form_open_multipart('auth/register', 'id="registForm" role="registForm" autocomplete="off"'); ?>
                                        <fieldset>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" name="fullName" class="form-control" placeholder="Full Name" required />
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="email" name="email" class="form-control" placeholder="Email" required />
                                                    <i class="ace-icon fa fa-envelope"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="text" name="username" class="form-control" placeholder="Username" required />
                                                    <i class="ace-icon fa fa-user"></i>
                                                </span>
                                            </label>
                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <select type="text" id="school" name="school" class="form-control select2" style="width: 100%" placeholder="Pilih Sekolah" required>
                                                        <option value="">-- Pilih Sekolah --</option>
                                                        <?php foreach ($schools as $school) { ?>
                                                            <option value="<?= $school['school_id'] ?>"><?= $school['school_nsm'] ?> - <?= $school['school_name'] ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </span>
                                            </label>
                                            <?php if ($system['active_register_role'] == 1) { ?>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <select type="text" id="role" name="role" class="form-control" placeholder="role" required>
                                                            <option value="">-- Pilih Role --</option>
                                                            <?php foreach ($userRole as $role) { ?>
                                                                <option value="<?= $role['role_id'] ?>"><?= $role['role_name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                        <i class="ace-icon fa fa-key"></i>
                                                    </span>
                                                </label>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <select type="text" id="subject" name="subject" class="form-control select2" style="width: 100%" placeholder="Pilih Sekolah" disabled>
                                                            <option value="">-- Pilih Mapel --</option>
                                                            <?php foreach ($subjects as $subject) { ?>
                                                                <option value="<?= $subject['subject_id'] ?>"><?= $subject['subject_name'] ?></option>
                                                            <?php } ?>
                                                        </select>
                                                    </span>
                                                </label>
                                                <label class="block clearfix">
                                                    <span class="block input-icon input-icon-right">
                                                        <input type="text" name="nip" class="form-control" placeholder="NIP atau NIS atau NIK" required />
                                                        <i class="ace-icon fa fa-key"></i>
                                                    </span>
                                                </label>
                                            <?php } ?>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" name="password" class="form-control pwd" placeholder="Password" required />
                                                    <i class="ace-icon fa fa-lock"></i>
                                                </span>
                                            </label>

                                            <label class="block clearfix">
                                                <span class="block input-icon input-icon-right">
                                                    <input type="password" name="confirmPassword" class="form-control pwd" placeholder="Repeat password" required />
                                                    <i class="ace-icon fa fa-retweet"></i>
                                                </span>
                                            </label>

                                            <label class="block">
                                                <input type="checkbox" id="showPassword" class="ace" value="1" />
                                                <span class="lbl">
                                                    Show Password
                                                </span>
                                            </label>

                                            <label class="block">
                                                <input type="checkbox" name="agreement" class="ace" value="1" required />
                                                <span class="lbl">
                                                    I accept the
                                                    <a href="#">User Agreement</a>
                                                </span>
                                            </label>

                                            <div class="space-24"></div>

                                            <div class="clearfix">
                                                <button type="reset" class="width-30 pull-left btn btn-sm">
                                                    <i class="ace-icon fa fa-refresh"></i>
                                                    <span class="bigger-110">Reset</span>
                                                </button>

                                                <button type="submit" class="width-65 pull-right btn btn-sm btn-success">
                                                    <span class="bigger-110">Register</span>

                                                    <i class="ace-icon fa fa-arrow-right icon-on-right"></i>
                                                </button>
                                            </div>
                                        </fieldset>
                                        <?php echo form_close(); ?>
                                    </div>

                                    <div class="toolbar center">
                                        <a href="#" data-target="#login-box" class="back-to-login-link">
                                            <i class="ace-icon fa fa-arrow-left"></i>
                                            Back to login
                                        </a>
                                    </div>
                                </div><!-- /.widget-body -->
                            </div><!-- /.signup-box -->
                        </div><!-- /.position-relative -->

                        <!-- <div class="navbar-fixed-top align-right">
                            <br />
                            &nbsp;
                            <a id="btn-login-dark" href="#">Dark</a>
                            &nbsp;
                            <span class="blue">/</span>
                            &nbsp;
                            <a id="btn-login-blur" href="#">Blur</a>
                            &nbsp;
                            <span class="blue">/</span>
                            &nbsp;
                            <a id="btn-login-light" href="#">Light</a>
                            &nbsp; &nbsp; &nbsp;
                        </div> -->
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.main-content -->
    </div><!-- /.main-container -->

    <!-- basic scripts -->

    <!--[if !IE]> -->
    <script src="<?= base_url() ?>assets/js/jquery-2.1.4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9"></script>
    <script src="<?= base_url('assets/js/jquery.blockUI.js'); ?>"></script>
    <script src="<?= base_url() ?>assets/js/select2.min.js"></script>
    <!-- <![endif]-->

    <!--[if IE]>
<script src="assets/js/jquery-1.11.3.min.js"></script>
<![endif]-->
    <script type="text/javascript">
        if ('ontouchstart' in document.documentElement) document.write("<script src='<?= base_url() ?>assets/js/jquery.mobile.custom.min.js'>" + "<" + "/script>");
    </script>

    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(".select2").select2({
            width: 'resolve' // need to override the changed default
        });

        $('#role').change(function() {
            var selectedText = $("#role option:selected").html();

            if ((selectedText.indexOf("Guru") >= 0) || selectedText.indexOf("guru") >= 0) {
                $("#subject").attr("disabled", false);
                $("#subject").attr("required", true);
            } else {
                $("#subject").val('');
                $('#subject').trigger('change');
                $("#subject").attr("disabled", true);
            }
        });

        var switchStatus = false;
        $("#showPassword").on('change', function() {
            if ($(this).is(':checked')) {
                switchStatus = $(this).is(':checked');
                $('.pwd').attr('type', 'text');
                console.log(switchStatus);
            } else {
                switchStatus = $(this).is(':checked');
                $('.pwd').attr('type', 'password');
                console.log(switchStatus);
            }
        });
        const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            onOpen: (toast) => {
                toast.addEventListener('mouseenter', Swal.stopTimer)
                toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
        })

        $(document).ajaxStart(function() {
            $(document).ajaxStart($.blockUI({
                global: false,
                message: 'Loading...',
                css: {
                    border: 'none',
                    padding: '5px',
                    backgroundColor: '#000',
                    '-webkit-border-radius': '10px',
                    '-moz-border-radius': '10px',
                    opacity: .6,
                    color: '#fff'
                }

            })).ajaxStop($.unblockUI);
        });
        jQuery(function($) {
            $(document).on('click', '.toolbar a[data-target]', function(e) {
                var target = $(this).data('target');
                $('.widget-box.visible').removeClass('visible'); //hide others
                $(target).addClass('visible'); //show target
            });
        });

        jQuery(function($) {
            $('#resendEmail').on('click', 'a[data-target]', function(e) {
                var target = $(this).data('target');
                $('.widget-box.visible').removeClass('visible'); //hide others
                $(target).addClass('visible'); //show target
            });
        });



        //you don't need this, just used for changing background
        jQuery(function($) {
            $('#btn-login-dark').on('click', function(e) {
                $('body').attr('class', 'login-layout');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
            });
            $('#btn-login-light').on('click', function(e) {
                $('body').attr('class', 'login-layout light-login');
                $('#id-text2').attr('class', 'grey');
                $('#id-company-text').attr('class', 'blue');

                e.preventDefault();
            });
            $('#btn-login-blur').on('click', function(e) {
                $('body').attr('class', 'login-layout blur-login');
                $('#id-text2').attr('class', 'white');
                $('#id-company-text').attr('class', 'light-blue');

                e.preventDefault();
            });

        });
    </script>
    <script>
        $('#registForm').on('submit', (function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Email yang digunakan adalah email untuk melakukan verifikasi.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.value) {
                    var myForm = $("#registForm")[0];
                    $.ajax({
                        url: $(myForm).attr('action'),
                        type: 'POST',
                        data: new FormData(myForm),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            response = jQuery.parseJSON(JSON.stringify(data));
                            if (response.is_success === true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message,
                                });
                                myForm.reset('');
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: response.message,
                                })
                            }

                        },
                        error: function(xhr, status, error) {
                            //console.log(xhr);
                            Toast.fire({
                                icon: 'error',
                                title: xhr.statusText,
                                text: "Something Wrong"
                            })
                        },
                        timeout: 300000 // sets timeout to 5 minutes
                    });
                }
            })

        }));
    </script>
    <script>
        $('#forgotPassword').on('submit', (function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Email yang digunakan adalah email yang terdaftar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.value) {
                    var myForm = $("#forgotPassword")[0];
                    $.ajax({
                        url: $(myForm).attr('action'),
                        type: 'POST',
                        data: new FormData(myForm),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            response = jQuery.parseJSON(JSON.stringify(data));
                            if (response.is_success === true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message,
                                });
                                myForm.reset('');
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: response.message,
                                })
                            }

                        },
                        error: function(xhr, status, error) {
                            //console.log(xhr);
                            Toast.fire({
                                icon: 'error',
                                title: xhr.statusText,
                                text: "Something Wrong"
                            })
                        },
                        timeout: 300000 // sets timeout to 5 minutes
                    });
                }
            })

        }));
    </script>
    <script>
        $('#resendEmailVerify').on('submit', (function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Apakah Anda Yakin?',
                text: "Email yang digunakan adalah email yang terdaftar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ya!'
            }).then((result) => {
                if (result.value) {
                    var myForm = $("#resendEmailVerify")[0];
                    $.ajax({
                        url: $(myForm).attr('action'),
                        type: 'POST',
                        data: new FormData(myForm),
                        contentType: false,
                        cache: false,
                        processData: false,
                        dataType: 'json',
                        success: function(data) {
                            response = jQuery.parseJSON(JSON.stringify(data));
                            if (response.is_success === true) {
                                Toast.fire({
                                    icon: 'success',
                                    title: response.message,
                                });
                                myForm.reset('');
                            } else {
                                Toast.fire({
                                    icon: 'warning',
                                    title: response.message,
                                })
                            }

                        },
                        error: function(xhr, status, error) {
                            //console.log(xhr);
                            Toast.fire({
                                icon: 'error',
                                title: xhr.statusText,
                                text: "Something Wrong"
                            })
                        },
                        timeout: 300000 // sets timeout to 5 minutes
                    });
                }
            })

        }));
    </script>
</body>

</html>