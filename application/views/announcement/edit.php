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
                    <a href="#"><?= $this->lang->line('announ_bread') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('announ_create') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1><?= $this->lang->line('announ_create') ?></h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-md-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <?php echo form_open_multipart('announcement/save', 'class="" id="form" role="form" autocomplete="off"'); ?>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="announ_title">
                                <?= $this->lang->line('announ_title') ?>
                                <small class="text-warning"></small>
                            </label>
                            <input class="form-control hidden" type="text" id="announ_id" name="announ_id" value="<?= $announ[0]['announ_id'] ?>">
                            <input type="text" class="form-control" name="announ_title" id="announ_title" placeholder="<?= $this->lang->line('announ_title') ?>" value="<?= P($announ[0]['announ_title']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="announ_number">
                                <?= $this->lang->line('announ_number') ?>
                                <small class="text-warning"></small>
                            </label>
                            <input type="text" class="form-control" name="announ_number" id="announ_number" placeholder="<?= $this->lang->line('announ_number') ?>" value="<?= P($announ[0]['announ_number']) ?>" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="announ_date">
                                <?= $this->lang->line('announ_date') ?>
                                <small class="text-warning"></small>
                            </label>

                            <div class="input-group">
                                <span class="input-group-addon">
                                    <i class="ace-icon fa fa-calendar"></i>
                                </span>

                                <input class="form-control input-mask-phone date-picker" type="text" id="announ_date" name="announ_date" value="<?= date('d/m/Y', strtotime($announ[0]['announ_date'])) ?>" placeholder="dd/mm/yyyy" required>

                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="announ_subject">
                                <?= $this->lang->line('announ_subject') ?>
                                <small class="text-warning"></small>
                            </label>
                            <input type="text" class="form-control" name="announ_subject" id="announ_subject" placeholder="<?= $this->lang->line('announ_subject') ?>" value="<?= P($announ[0]['announ_subject']) ?>" required>
                        </div>
                    </div>
                    <?php
                    if ($this->session->userdata('logged_in')['role_id'] == 1) {
                    ?>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="school_id"><?= $this->lang->line('text_school') ?></label>
                                <br>
                                <select class="form-control select2" name="school_id" id="school_id" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                                    <option value=""><?= $this->lang->line('text_select_option') ?></option>
                                    <?php foreach ($schools as $school) { ?>
                                        <option value="<?= EncryptString($school['school_id']) ?>" <?= $announ[0]['school_id'] == $school['school_id'] ? 'selected' : ''; ?>><?= $school['school_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="announ_content">
                                <?= $this->lang->line('announ_content') ?>
                                <small class="text-warning"></small>
                            </label>
                            <textarea id="announ_content" class="autosize-transition form-control" name="announ_content" required><?= $announ[0]['announ_content'] ?></textarea>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <br>
                        <a class="btn btn-success add_button">
                            <i class="ace-icon fa fa-plus bigger-110"></i>
                            <?= $this->lang->line('announ_add_attach') ?>
                        </a>
                        <hr>
                        <div class="widget-body">
                            <div class="widget-main padding-8">
                                <?php if ($announAttachment) { ?>
                                    <ul class="ace-thumbnails clearfix center">
                                        <?php foreach ($announAttachment as $attch) {
                                            $multimediaArr = array('mp4', 'mkv', 'mov', 'avi', 'mpeg4', 'mp3');
                                            $ext = pathinfo($attch['aa_name'], PATHINFO_EXTENSION);
                                        ?>

                                            <li id="file_<?= $attch['aa_id'] ?>">
                                                <?php if (in_array($ext, $multimediaArr)) { ?>
                                                    <video width="150" height="150" controls>
                                                        <source src="<?= $attch['aa_dir'] ?>" type="video/mp4">
                                                        Your browser does not support the video tag.
                                                    </video>
                                                <?php } else if ($ext == "pdf") { ?>
                                                    <embed width="150" height="150" alt="150x150" src="<?= $attch['aa_dir'] ?>" />
                                                <?php } else { ?>
                                                    <a href="<?= $attch['aa_dir'] ?>" data-rel="colorbox" class="cboxElement">
                                                        <img width="150" height="150" alt="150x150" src="<?= $attch['aa_dir'] ?>">
                                                    </a>
                                                <?php } ?>
                                                <div class="tags">
                                                    <!-- <span class="label-holder">
                                                        <span class="label label-info"> <i class="ace-icon fa fa-upload"></i> <?= $this->lang->line('text_by') ?> <?= P($attch['user_username']) ?></span>
                                                    </span> -->
                                                </div>
                                                <div class="tools">
                                                    <a href="javascript:;" onclick="deleteAttach(<?= $attch['aa_id'] ?>)">
                                                        <i class="ace-icon fa fa-times red"></i>
                                                    </a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                    </ul>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="field_wrapper">

                        </div>
                    </div>
                    <hr>

                    <div class="col-md-12">
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
                    </div>

                    <div class="hr hr-24"></div>


                    <div class="space-24"></div>

                    <?php echo form_close(); ?>
                </div><!-- /.col -->
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
<script src="<?= base_url() ?>assets/plugins/ckfinder/ckfinder.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/jquery-ui.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.gritter.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-timepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-clockpicker.min.js"></script>
<!-- inline scripts related to this page -->

<script type="text/javascript">
    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = `<div class="col-md-6 files">
                            <a href="javascript:void(0);" class="remove_button">
                                <i class="ace-icon red fa fa-close bigger-110"></i>
                            </a>
                            <div class="col-xs-12">
                                <input class="file" name="files[]" type="file"/>
                            </div>
                        </div>`; //New input field html 
        var x = 1; //Initial field counter is 1

        //Once add button is clicked
        $(addButton).click(function() {
            //Check maximum number of input fields
            if (x < maxField) {
                x++; //Increment field counter
                $(wrapper).append(fieldHTML); //Add field html
                var whitelist_ext = ["jpeg", "jpg", "png", "gif", "bmp", "pdf", "mp3", "mp4", "doc", "docx", "xlc", "xlcx"];
                var whitelist_mime = ["image/jpg", "image/jpeg", "image/png", "image/gif", "image/bmp"];
                $('.file').ace_file_input({
                    style: 'well',
                    btn_choose: 'Drop files here or click to choose',
                    btn_change: null,
                    no_icon: 'ace-icon fa fa-cloud-upload',
                    droppable: true,
                    'allowExt': whitelist_ext,
                    // 'allowMime': whitelist_mime,
                    thumbnail: 'small' //large | fit
                        //,icon_remove:null//set null, to hide remove/reset button
                        /**,before_change:function(files, dropped) {
                        	//Check an example below
                        	//or examples/file-upload.html
                        	return true;
                        }*/
                        /**,before_remove : function() {
                        	return true;
                        }*/
                        ,
                    preview_error: function(filename, error_code) {
                        //name of the file that failed
                        //error_code values
                        //1 = 'FILE_LOAD_FAILED',
                        //2 = 'IMAGE_LOAD_FAILED',
                        //3 = 'THUMBNAIL_FAILED'
                        //alert(error_code);
                    }

                }).on('change', function() {
                    //console.log($(this).data('ace_input_files'));
                    //console.log($(this).data('ace_input_method'));
                });
            }
        });

        //Once remove button is clicked
        $(wrapper).on('click', '.remove_button', function(e) {
            e.preventDefault();
            $(this).parent('div').remove(); //Remove field html
            x--; //Decrement field counter
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function() {
        var editor = CKEDITOR.replace('announ_content');
        CKFinder.setupCKEditor(editor);
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
            clearBtn: true,
            endDate: "today",
            maxDate: new Date()
        });
        $('.clockpicker').clockpicker({
            donetext: 'Done'
        });
    })
</script>

<script type="text/javascript">
    jQuery(function($) {

        //select2 location element
        $('.select2').css('min-width', '400px').select2({});

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

        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('announ_approve_text_create') ?>",
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
                                title: 'Success!',
                                text: response.message,
                            }).then(function() {
                                window.location = "<?= base_url('announcement') ?>";
                            });
                        } else {
                            Toast.fire({
                                icon: 'error',
                                title: response.message
                            })

                        }

                    },
                    error: function(xhr, status, error) {
                        //console.log(xhr);
                        Toast.fire({
                            icon: 'error',
                            title: response.message
                        })
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        })

    }));

    function deleteAttach(id) {
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('warning_delete_attach') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('announcement/deleteAttach') ?>',
                    type: 'POST',
                    data: {
                        fileId: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            })
                            $("#file_" + id).remove();
                        } else {
                            $.gritter.add({
                                title: 'Gagal Submit Form!',
                                text: response.message,
                                class_name: 'gritter-error gritter-light'
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        //console.log(xhr);
                        $.gritter.add({
                            title: 'Something Wrong',
                            text: xhr.statusText,
                            class_name: 'gritter-error gritter-light'
                        });
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        })
    }
</script>