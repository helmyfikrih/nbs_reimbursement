<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#"><?= $this->lang->line('home_title') ?></a>
                </li>
                <li>
                    <a href="#"><?= $this->lang->line('users_title') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('users_edit') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1><?= $this->lang->line('users_edit') ?></h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <?php echo form_open_multipart('user/save', 'class="form-horizontal" id="form" role="form"'); ?>
                    <div class="col-xs-6">
                        <div>
                            <label for="notulensi_date">
                                <?= $this->lang->line('profile_username') ?> :
                                <small class="text-warning"></small>
                            </label>

                            <input class="form-control" type="text" id="user_username" name="user_username" placeholder="EX: helmy" required>
                            <input class="form-control hidden" type="text" id="user_id" name="user_id" value="<?= $userDetail[0]['user_id'] ?>" required>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('text_password') ?> :
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <input class="form-control" type="text" id="user_password" name="user_password" placeholder="<?= $this->lang->line('users_text_leave_empty_password') ?> ">
                        </div>
                    </div>

                    <div class="col-xs-6">
                        <hr>
                        <div>
                            <label for="notulensi_date">
                                <?= $this->lang->line('profile_full_name') ?> :
                                <small class="text-warning"></small>
                            </label>

                            <input class="form-control" type="text" id="user_full_name" name="user_full_name" placeholder="EX: Helmy Fikri Husein" required>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <hr>
                        <div>
                            <label for="form-field-mask-2">
                                NIK / NIP / NIS <small style="color: blue;">
                                    (<?= $this->lang->line('users_text_use_username_if_not') ?>)
                                </small>:
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <input class="form-control" type="text" id="user_nik" name="user_nik" placeholder="Ex: 132431232423" required>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <hr>
                        <div>
                            <label for="notulensi_date">
                                <?= $this->lang->line('profile_birth_place') ?> :
                                <small class="text-warning"></small>
                            </label>

                            <input class="form-control" type="text" id="user_place_birth" name="user_place_birth" placeholder="EX: Jakarta" required>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <hr>
                        <div>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('profile_birth_date') ?> :
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <input class="form-control date-picker" type="text" id="user_date_birth" name="user_date_birth" placeholder="dd/mm/yyyy" required>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('profile_address') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <textarea class="autosize-transition form-control" type="text" id="user_address" name="user_address" placeholder="Ex: Jl. Kayu Manis III RT 06/02 No.41 Pd.Cabe Udik." required></textarea>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('profile_phone') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <input class="form-control" type="text" id="user_telp" name="user_telp" placeholder="EX: 089630467886" required>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('text_email') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <input class="form-control" type="email" id="user_email" name="user_email" placeholder="Ex: helmyfikrih@gmail.com" required>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('text_status') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <select class="select2 form-control" name="user_status" id="user_status" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                            <option value=""> </option>
                            <option value="1"><?= $this->lang->line('users_status_active') ?></option>
                            <option value="0"><?= $this->lang->line('users_status_inactive') ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('text_role') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <select class="select2 form-control" name="user_role" id="user_role" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                            <option value=""> </option>
                            <?php foreach ($dataRole as $role) {
                                $roleId = $role['role_id'];
                                $roleName = $role['role_name'];
                                echo "<option value='$roleId'>$roleName</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('text_designation') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <select class="select2 form-control" name="user_position" id="user_position" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                            <option value=""> </option>
                            <?php foreach ($dataDesignation as $designation) {
                                $designationId = $designation['designation_id'];
                                $designationName = $designation['designation_name'];
                                echo "<option value='$designationId'>$designationName</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('text_teacher') ?> <?= $this->lang->line('text_subject') ?>:
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <select class="select2 form-control" name="user_mapel" id="user_mapel" data-placeholder="<?= $this->lang->line('text_select_option') ?>">
                            <option value=""></option>
                            <?php foreach ($dataSubject as $subject) {
                                $subjectId = $subject['subject_id'];
                                $subjectName = $subject['subject_name'];
                                echo "<option value='$subjectId'>$subjectName</option>";
                            } ?>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="col-xs-6">
                        <hr>
                        <div>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('profile_gender') ?> :
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <div class="radio">
                                <label>
                                    <input name="user_sex" value="L" id="L" type="radio" class="ace">
                                    <span class="lbl"> <?= $this->lang->line('text_male') ?></span>
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input name="user_sex" value="P" id="P" type="radio" class="ace">
                                    <span class="lbl"> <?= $this->lang->line('text_female') ?></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div>
                            <hr>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('text_school') ?> :
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <select class="select2 form-control" name="user_school" id="user_school" data-placeholder="...">
                                <option value="">- <?= $this->lang->line('text_school') ?> : -</option>
                                <?php foreach ($dataSchools as $school) {
                                    $schoolId = $school['school_id'];
                                    $schoolName = $school['school_name'];
                                    $schoolNsm = $school['school_nsm'];
                                    echo "<option value='$schoolId'> $schoolNsm - $schoolName</option>";
                                } ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12">
                    <hr>
                    <div>
                        <div class="clearfix form-actions">
                            <div class="col-md-offset-3 col-md-9">
                                <button class="btn btn-info" type="submit">
                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                    Submit
                                </button>
                                &nbsp; &nbsp; &nbsp;
                                <button class="btn" type="reset">
                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                    Reset
                                </button>
                                &nbsp; &nbsp; &nbsp;
                                <button class="btn btn-success" onclick="window.history.go(-1); return false;">
                                    <i class="ace-icon fa fa-arrow-left bigger-110"></i>
                                    Cancel
                                </button>
                            </div>
                        </div>

                        <div class="hr hr-24"></div>


                        <div class="space-24"></div>

                        <?php echo form_close(); ?>
                    </div><!-- /.col -->
                </div>

            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->

<!-- page specific plugin scripts -->
<script src="<?= base_url() ?>assets/js/tree.min.js"></script>
<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?= base_url() ?>assets/js/holder.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.gritter.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-clockpicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/moment.min.js"></script>
<script src="<?= base_url() ?>assets/js/daterangepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-colorpicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.knob.min.js"></script>
<script src="<?= base_url() ?>assets/js/autosize.min.js"></script>

<!-- ace scripts -->
<script src="<?= base_url() ?>assets/js/ace-elements.min.js"></script>
<script src="<?= base_url() ?>assets/js/ace.min.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
    $(document).ready(function() {
        $('#user_role').change(function() {
            var selectedText = $("#user_role option:selected").html();
            if ((selectedText.indexOf("Guru") >= 0) || selectedText.indexOf("guru") >= 0) {
                $("#user_mapel").attr("disabled", false);
            } else {
                $("#user_mapel").val('');
                $('#user_mapel').trigger('change');
                $("#user_mapel").attr("disabled", true);
            }
        });
        autosize($('textarea[class*=autosize]'));
        // Set Form
        $('#user_username').val('<?= $userDetail[0]['user_username'] ? $userDetail[0]['user_username'] : 'Tidak Ada' ?>');
        $('#user_full_name').val('<?= $userDetail[0]['ud_full_name'] ? $userDetail[0]['ud_full_name'] : 'Tidak Ada' ?>');
        $('#user_nik').val('<?= $userDetail[0]['ud_nik'] ? $userDetail[0]['ud_nik'] : 'Tidak Ada' ?>');
        $('#user_place_birth').val('<?= $userDetail[0]['ud_birth_place'] ? $userDetail[0]['ud_birth_place'] : 'Tidak Ada' ?>');
        $('#user_date_birth').val('<?= $userDetail[0]['ud_birth_date'] ? date('d/m/Y', strtotime($userDetail[0]['ud_birth_date'])) : 'Tidak Ada' ?>');
        $('#user_address').val(`<?= $userDetail[0]['ud_address'] ? $userDetail[0]['ud_address'] : 'Tidak Ada' ?>`);
        $('#user_telp').val('<?= $userDetail[0]['ud_phone'] ? $userDetail[0]['ud_phone'] : 'Tidak Ada' ?>');
        $('#user_email').val('<?= $userDetail[0]['user_email'] ? $userDetail[0]['user_email'] : 'Tidak Ada' ?>');
        $('#user_status').val('<?= $userDetail[0]['user_status'] ? $userDetail[0]['user_status'] : 'Tidak Ada' ?>');
        $('#user_role').val('<?= $userDetail[0]['role_id'] ? $userDetail[0]['role_id'] : 'Tidak Ada' ?>');
        $('#user_position').val('<?= $userDetail[0]['designation_id'] ? $userDetail[0]['designation_id'] : 'Tidak Ada' ?>');
        $('#user_mapel').val('<?= $userDetail[0]['subject_id'] ? $userDetail[0]['subject_id'] : '' ?>');
        $('#user_school').val('<?= $userDetail[0]['school_id'] ? $userDetail[0]['school_id'] : '' ?>');
        $('#user_school').trigger('change');
        $('#user_mapel').trigger('change');
        $('#user_role').trigger('change');
        if ('<?= $userDetail[0]['ud_gender'] ?>' == 'L') {
            $('#L').prop("checked", true);
        } else if ('<?= $userDetail[0]['ud_gender'] ?>' == 'P') {
            $('#P').prop("checked", true);
        } else {
            $('#L').prop("checked", false);
            $('#P').prop("checked", false);
        }
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        //override dialog's title function to allow for HTML titles
        $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            _title: function(title) {
                var $title = this.options.title || '&nbsp;'
                if (("title_html" in this.options) && this.options.title_html == true)
                    title.html($title);
                else title.text($title);
            }
        }));
        $('.date-picker').datepicker({
            format: 'dd/mm/yyyy',
            todayHighlight: true,
            autoclose: true,
            clearBtn: true
        });


    })
</script>

<script type="text/javascript">
    jQuery(function($) {

        //select2 location element
        $('.select2').css('min-width', '150px').select2({
            allowClear: true
        });

        $('#toggle-result-format .btn').tooltip({
            container: 'body'
        }).on('click', function(e) {
            $(this).siblings().each(function() {
                $(this).removeClass($(this).attr('data-class')).addClass('btn-grey');
            });
            $(this).removeClass('btn-grey').addClass($(this).attr('data-class'));
        });
    });
</script>

<script>
    $('#form').on('submit', (function(e) {
        e.preventDefault();
        var oldUsername = '<?= $userDetail[0]['user_username'] ?>';
        var curUsername = $('#user_username').val();
        var checkUsername = function() {
            var username = null;
            $.ajax({
                'type': "POST",
                'global': true,
                'async': false,
                'dataType': 'JSON',
                'data': {
                    username: $("#user_username").val()
                },
                'url': "<?= base_url('user/checkUsername') ?>",
                'success': function(data) {
                    username = data;
                }
            });
            return username;
        }();
        if ((checkUsername.isExist) && (oldUsername != curUsername)) {
            Toast.fire({
                icon: 'warning',
                title: "<?= $this->lang->line('profile_warning_username_exist') ?>"
            })
            return;
        }
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('users_warning_save') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
        }).then((result) => {
            if (result.value) {
                var myForm = $("#form")[0];
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
                            Swal.fire({
                                icon: 'success',
                                title: '<?= $this->lang->line('text_success') ?>',
                                text: response.message,
                            }).then(function() {
                                window.location = "<?= base_url('user') ?>";
                            });
                        } else {
                            $.gritter.add({
                                title: '<?= $this->lang->line('text_failed') ?>',
                                text: response.message,
                                class_name: 'gritter-error gritter-light'
                            });

                        }

                    },
                    error: function(xhr, status, error) {
                        //console.log(xhr);
                        $.gritter.add({
                            title: '<?= $this->lang->line('text_error') ?>',
                            text: xhr.statusText,
                            class_name: 'gritter-error gritter-light'
                        });
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        })

    }));
</script>