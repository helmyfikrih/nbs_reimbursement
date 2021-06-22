<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#"><?= $this->lang->line('home_title') ?></a>
                </li>
                <li>
                    <a href="#"><?= $this->lang->line('text_settings') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('sys_title') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="row">
                <div class="tabbable tabs-left">
                    <ul class="nav nav-tabs" id="myTab3">
                        <li class="active">
                            <a data-toggle="tab" href="#general">
                                <i class="pink ace-icon fa fa-tachometer bigger-110"></i>
                                <?= $this->lang->line('sys_general') ?>
                            </a>
                        </li>

                        <li>
                            <a data-toggle="tab" href="#systemLogo">
                                <i class="blue ace-icon fa fa-user bigger-110"></i>
                                <?= $this->lang->line('sys_logo') ?>
                            </a>
                        </li>
                        <li>
                            <a data-toggle="tab" href="#smtp">
                                <i class="blue ace-icon fa fa-envelope bigger-110"></i>
                                SMTP
                            </a>
                        </li>

                    </ul>

                    <div class="tab-content">
                        <div id="general" class="tab-pane in active">
                            <?php echo form_open_multipart('settings/saveGeneral', 'class="" id="generalForm" role="generalForm"'); ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_app_name') ?></label>
                                    <input class="form-control" placeholder="<?= $this->lang->line('sys_app_name') ?>" name="application_name" type="text" id="application_name" value="<?= $system["application_name"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_header_text') ?></label>
                                    <input class="form-control" placeholder="<?= $this->lang->line('sys_header_text') ?>" name="header_name" type="text" id="header_name" value="<?= $system["header_name"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_footer_text') ?></label>
                                    <input class="form-control" placeholder="<?= $this->lang->line('sys_footer_text') ?>" name="footer_text" type="text" id="footer_text" value="<?= $system["footer_text"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_footer_year') ?></label>
                                    <input class="form-control" placeholder="<?= $this->lang->line('sys_footer_year') ?>" name="footer_year" type="number" min="0" id="footer_year" value="<?= $system["footer_year"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_register_choose_role') ?></label>
                                    <br>
                                    <input name="registerRole" class="ace ace-switch ace-switch-2" type="checkbox" id="registerRole" <?= $system["active_register_role"] == 1 ? 'checked' : '' ?> />
                                    <span class="lbl"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_info') ?></label>
                                    <textarea class="form-control" placeholder="<?= $this->lang->line('sys_info') ?>" name="sys_info" type="text" id="sys_info"><?= P($system["sys_info"]) ?></textarea>
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="pull-right form-group">
                                    <button type="submit" class="btn btn-primary "> <i class="fa fa-check-square-o"></i> <?= $this->lang->line('text_save') ?> </button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div id="systemLogo" class="tab-pane">
                            <?php echo form_open_multipart('settings/saveLogo', 'class="" id="logoForm" role="logoForm"'); ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_logo_header') ?></label>
                                    <input class="form-control" placeholder="Application Name" name="logo_header" type="file" accept="image/*" id="logo_header">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name"><?= $this->lang->line('sys_logo_icon') ?></label>
                                    <input class="form-control" placeholder="Header Name" name="logo_icon" type="file" accept="image/*" id="logo_icon">
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="pull-right form-group">
                                    <button type="submit" class="btn btn-primary "> <i class="fa fa-check-square-o"></i> <?= $this->lang->line('text_save') ?> </button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>

                        <div id="smtp" class="tab-pane">
                            <?php echo form_open_multipart('settings/saveSMTP', 'class="" id="smtpForm" role="smtpForm"'); ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">SMTP HOST</label>
                                    <input class="form-control" placeholder="SMTP HOST" name="sys_smtp_host" type="text" id="sys_smtp_host" value="<?= $system["sys_smtp_host"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">SMTP USER</label>
                                    <input class="form-control" placeholder="SMTP USER" name="sys_smtp_user" type="text" id="sys_smtp_user" value="<?= $system["sys_smtp_user"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">SMTP PASSWORD</label>
                                    <input class="form-control" placeholder="SMTP PASSWORD" name="sys_smtp_pass" type="text" id="sys_smtp_pass" value="<?= DecryptString($system["sys_smtp_pass"]) ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">SMTP CRYPTO</label>
                                    <input class="form-control" placeholder="SMTP CRYPTO" name="sys_smtp_crypto" type="text" id="sys_smtp_crypto" value="<?= $system["sys_smtp_crypto"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">SMTP PORT</label>
                                    <input class="form-control" placeholder="SMTP PORT" name="sys_smtp_port" type="number" min="0" id="sys_smtp_port" value="<?= $system["sys_smtp_port"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">SMTP FROM</label>
                                    <input class="form-control" placeholder="SMTP FROM" name="sys_smtp_from" type="text" id="sys_smtp_from" value="<?= $system["sys_smtp_from"] ?>">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="company_name">SMTP ALIAS</label>
                                    <input class="form-control" placeholder="SMTP ALIAS" name="sys_smtp_alias" type="text" id="sys_smtp_alias" value="<?= $system["sys_smtp_alias"] ?>">
                                </div>
                            </div>
                            <div class="col-md-12 ">
                                <div class="pull-right form-group">
                                    <button type="submit" class="btn btn-primary "> <i class="fa fa-check-square-o"></i> <?= $this->lang->line('text_save') ?> </button>
                                </div>
                            </div>
                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div><!-- /.main-content -->

<script>
    var switchStatus = false;
    $("#registerRole").on('change', function() {
        if ($(this).is(':checked')) {
            switchStatus = $(this).is(':checked');
        } else {
            switchStatus = $(this).is(':checked');
        }
    });
</script>
<script>
    $('#generalForm').on('submit', (function(e) {
        e.preventDefault();
        var myForm = $("#generalForm")[0];
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

    }));
</script>
<script>
    $('#logoForm').on('submit', (function(e) {
        e.preventDefault();
        var myForm = $("#logoForm")[0];
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
                    d = new Date();
                    $(`#${response.imgType}`).attr("src", "assets/images/icon/" + response.imgName + "?x=" + d.getTime());
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

    }));
</script>
<script>
    $('#smtpForm').on('submit', (function(e) {
        e.preventDefault();
        var myForm = $("#smtpForm")[0];
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

    }));
</script>