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
                    <a href="#"><?= $this->lang->line('text_settings') ?></a>
                </li>
                <li>
                    <a href="#"><?= $this->lang->line('text_master_data') ?></a>
                </li>
                <li>
                    <a href="#"><?= $this->lang->line('school_title') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('school_edit') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1><?= $this->lang->line('school_edit') ?> </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <?php echo form_open_multipart('schools/save', 'class="form-horizontal" id="form" role="form"'); ?>
                    <div class="col-xs-6">
                        <div>
                            <label for="notulensi_date">
                                <?= $this->lang->line('school_name') ?> :
                                <small class="text-warning"></small>
                            </label>

                            <input class="form-control" type="text" id="school_name" name="school_name" placeholder="EX: Madrasah Aliyah 4 Jakarta" value="<?php echo P($schoolDetail[0]['school_name']) ?>" required>
                            <input class="form-control hidden" type="text" id="school_id" name="school_id" value="<?= $schoolDetail[0]['school_id'] ?>" required>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <div>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('school_nsm') ?> :
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <input class="form-control" type="text" id="school_nsm" name="school_nsm" placeholder="Ex: 1114093000027" value="<?php echo P($schoolDetail[0]['school_nsm']) ?>" required>
                            <input class="form-control hidden" type="text" id="school_nsm_before" name="school_nsm_before" placeholder="Ex: 1114093000027" value="<?php echo P($schoolDetail[0]['school_nsm']) ?>" required>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <hr>
                        <div>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('school_type') ?> :
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <select class="select2 form-control" name="school_type" id="school_type" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                                <?php
                                $type = $schoolDetail[0]['school_type'];
                                ?>
                                <option value=""></option>
                                <option value="NEGERI" <?= $type === 'NEGERI' ? 'selected' : '' ?>>NEGERI </option>
                                <option value="SWASTA" <?= $type === 'SWASTA' ? 'selected' : '' ?>> SWASTA</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-6">
                        <hr>
                        <div>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('school_phone') ?> :
                                <!-- <small class="text-warning">(999) 999-9999</small> -->
                            </label>

                            <input class="form-control" type="number" id="school_phone" name="school_phone" placeholder="EX: 0212323232" value="<?php echo P($schoolDetail[0]['school_phone']) ?>" required>
                        </div>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('school_address') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <textarea class="autosize-transition form-control" type="text" id="school_address" name="school_address" placeholder="Ex: Jl. Kayu Manis III RT 06/02 No.41 Pd.Cabe Udik." required><?php echo P($schoolDetail[0]['school_nsm']) ?></textarea>
                    </div>
                </div>
                <div class="col-xs-6">
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('school_status') ?> :
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <select class="select2 form-control" name="school_status" id="school_status" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                            <option value=""> - Pilih Status - </option>
                            <option value="1" <?= $schoolDetail[0]['school_status'] === '1' ? 'selected' : '' ?>><?= $this->lang->line('school_status_active') ?></option>
                            <option value="0" <?= $schoolDetail[0]['school_status'] === '0' ? 'selected' : '' ?>><?= $this->lang->line('school_status_inactive') ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12">
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
    <script src="<?= base_url() ?>assets/js/chosen.jquery.min.js"></script>
    <script src="<?= base_url() ?>assets/js/spinbox.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/js/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/js/daterangepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-datetimepicker.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-colorpicker.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.knob.min.js"></script>
    <script src="<?= base_url() ?>assets/js/autosize.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.inputlimiter.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.maskedinput.min.js"></script>
    <script src="<?= base_url() ?>assets/js/bootstrap-tag.min.js"></script>

    <!-- ace scripts -->
    <script src="<?= base_url() ?>assets/js/ace-elements.min.js"></script>
    <script src="<?= base_url() ?>assets/js/ace.min.js"></script>
    <!-- inline scripts related to this page -->
    <script type="text/javascript">
        $(document).ready(function() {
            autosize($('textarea[class*=autosize]'));
            $('.date-picker').datepicker({
                format: 'mm/dd/yyyy',
                todayHighlight: true,
                autoclose: true,
                clearBtn: true
            });
            $('.clockpicker').clockpicker({
                donetext: 'Done'
            });

        })
    </script>

    <script type="text/javascript">
        jQuery(function($) {

            //select2 location element
            $('.select2').css('min-width', '150px').select2({
                // allowClear: true
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
            var oldSchool_nsm = '<?= $schoolDetail[0]['school_nsm'] ?>';
            var curSchool_nsm = $("#school_nsm").val()
            var check_nsm = function() {
                var school_nsm = null;
                $.ajax({
                    'type': "POST",
                    'global': true,
                    'async': false,
                    'dataType': 'JSON',
                    'data': {
                        school_nsm: curSchool_nsm
                    },
                    'url': "<?= base_url('schools/check_nsm') ?>",
                    'success': function(data) {
                        school_nsm = data;
                    }
                });
                return school_nsm;
            }();
            if ((check_nsm.isExist) && (oldSchool_nsm != curSchool_nsm)) {
                Toast.fire({
                    icon: 'warning',
                    title: "<?= $this->lang->line('school_warning_nsm_exist') ?>"
                })
                return;
            }
            Swal.fire({
                title: '<?= $this->lang->line('warning_approval') ?>',
                text: "<?= $this->lang->line('school_warning_submit') ?>.",
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
                                    window.location = "<?= base_url('schools') ?>";
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