<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#">><?= $this->lang->line('home_title') ?></a>
                </li>
                <li>
                    <a href="#"><?= $this->lang->line('notulensi_title') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('notulensi_edit') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1><?= $noteData[0]['notulensi_code'] ?> </h1>
            </div><!-- /.page-header -->

            <!-- PAGE CONTENT BEGINS -->
            <?php echo form_open_multipart('notulensi/save', 'class="" id="form" role="form"'); ?>
            <input class="form-control hidden" type="text" id="notulensi_id" name="notulensi_id" value="<?= $noteData[0]['notulensi_id'] ?>">
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="notulensi_date">
                            <?= $this->lang->line('notulensi_agenda') ?>
                            <small class="text-warning"></small>
                        </label>
                        <input type="text" class="form-control" name="notulensi_agenda" id="notulensi_agenda" required value="<?= P($noteData[0]['notulensi_agenda']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="notulensi_date">
                            <?= $this->lang->line('notulensi_leader') ?>
                            <small class="text-warning"></small>
                        </label>
                        <input type="text" class="form-control" name="notulensi_leader" id="notulensi_leader" required value="<?= P($noteData[0]['notulensi_leader']) ?>">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="notulensi_date">
                            <?= $this->lang->line('notulensi_place') ?>
                            <small class="text-warning"></small>
                        </label>
                        <input type="text" class="form-control" name="notulensi_place" id="notulensi_place" required value="<?= P($noteData[0]['notulensi_place']) ?>">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="notulensi_date">
                            <?= $this->lang->line('notulensi_type') ?>
                            <small class="text-warning"></small>
                        </label>
                        <select class="form-control select2" name="notulensi_type" id="notulensi_type" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                            <option value=""></option>
                            <?php foreach ($noteType as $type) {
                                $selected = 'selected';
                            ?>
                                <option value="<?= $type['meetType_id'] ?>" <?= $noteData[0]['meetType_id'] == $type['meetType_id'] ? 'selected' : ''; ?>><?= $type['meetType_name'] ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="notulensi_date">
                            <?= $this->lang->line('notulensi_date') ?>
                            <small class="text-warning"></small>
                        </label>
                        <div class="input-group">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-calendar"></i>
                            </span>

                            <input class="form-control input-mask-phone date-picker" type="text" id="notulensi_date" name="notulensi_date" value="<?= date("m/d/Y", strtotime($noteData[0]['notulensi_date'])) ?>">
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('notulensi_start') ?>
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <div class="input-group clockpicker">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-clock-o"></i>
                            </span>

                            <input class="form-control input-mask-phone" type="text" id="notulensi_start" name="notulensi_start" value="<?= $noteData[0]['notulensi_start'] ?>">
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('notulensi_end') ?>
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <div class="input-group clockpicker">
                            <span class="input-group-addon">
                                <i class="ace-icon fa fa-clock-o"></i>
                            </span>

                            <input class="form-control input-mask-phone" type="text" id="notulensi_end" name="notulensi_end" value="<?= $noteData[0]['notulensi_end'] ?>">
                        </div>
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
                                    <option value="<?= EncryptString($school['school_id']) ?>" <?= $noteData[0]['school_id'] == $school['school_id'] ? 'selected' : ''; ?>><?= $school['school_name'] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('notulensi_result') ?>
                            <small class="text-warning"></small>
                        </label>

                        <div class="input-group">
                            <textarea id="notulensi_content" class="autosize-transition form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 92px;" name="notulensi_content"><?= P($noteData[0]['notulensi_content']) ?></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12">
                <br>
                <a class="btn btn-success add_button">
                    <i class="ace-icon fa fa-plus bigger-110"></i>
                    <?= $this->lang->line('notulensi_add_attach') ?>
                </a>
                <hr>
                <div class="field_wrapper">

                </div>
                <div class="widget-body">
                    <div class="widget-main padding-8">
                        <?php if ($noteAttachment) { ?>
                            <ul class="ace-thumbnails clearfix center">
                                <?php foreach ($noteAttachment as $attch) { ?>

                                    <li id="file_<?= $attch['na_id'] ?>">
                                        <a href="<?= base_url() ?>assets/uploads/notulensi/<?= $attch['na_name'] ?>" title="" data-rel="colorbox">
                                            <img width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/notulensi/<?= $attch['na_name'] ?>" />
                                        </a>

                                        <div class="tags">
                                        </div>
                                        <div class="tools">
                                            <!-- <a href="#">
                                                        <i class="ace-icon fa fa-link"></i>
                                                    </a>

                                                    <a href="#">
                                                        <i class="ace-icon fa fa-paperclip"></i>
                                                    </a>

                                                    <a href="#">
                                                        <i class="ace-icon fa fa-pencil"></i>
                                                    </a> -->

                                            <a href="javascript:;" onclick="deleteImg(<?= $attch['na_id'] ?>)">
                                                <i class="ace-icon fa fa-times red"></i>
                                            </a>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
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
<script src="<?= base_url() ?>assets/js/jquery.colorbox.min.js"></script>
<!-- inline scripts related to this page -->

<script type="text/javascript">
    function deleteImg(id) {
        Swal.fire({
            title: '<?= $this->lang->line('notulensi_approval') ?>',
            text: "<?= $this->lang->line('notulensi_delete_img_warning') ?>!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('notulensi_agree') ?>'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('notulensi/deleteImg') ?>',
                    type: 'POST',
                    data: {
                        imgId: id
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

    $(document).ready(function() {
        var maxField = 10; //Input fields increment limitation
        var addButton = $('.add_button'); //Add button selector
        var wrapper = $('.field_wrapper'); //Input field wrapper
        var fieldHTML = `<div class="col-md-6 files animated fadeIn">
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
        var editor = CKEDITOR.replace('notulensi_content');
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
        var $overflow = '';
        var colorbox_params = {
            rel: 'colorbox',
            reposition: true,
            scalePhotos: true,
            scrolling: false,
            previous: '<i class="ace-icon fa fa-arrow-left"></i>',
            next: '<i class="ace-icon fa fa-arrow-right"></i>',
            close: '&times;',
            current: '{current} of {total}',
            maxWidth: '100%',
            maxHeight: '100%',
            onOpen: function() {
                $overflow = document.body.style.overflow;
                document.body.style.overflow = 'hidden';
            },
            onClosed: function() {
                document.body.style.overflow = $overflow;
            },
            onComplete: function() {
                $.colorbox.resize();
            }
        };

        $('.ace-thumbnails [data-rel="colorbox"]').colorbox(colorbox_params);
        $("#cboxLoadingGraphic").html("<i class='ace-icon fa fa-spinner orange fa-spin'></i>"); //let's add a custom loading icon


        $(document).one('ajaxloadstart.page', function(e) {
            $('#colorbox, #cboxOverlay').remove();
        });
    })


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
        Swal.fire({
            title: '<?= $this->lang->line('notulensi_approval') ?>',
            text: "<?= $this->lang->line('notulensi_approve_text_create') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('notulensi_agree') ?>'
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
                            $('#dialog-confirm').dialog("close");
                            Swal.fire({
                                icon: 'success',
                                title: 'Success!',
                                text: response.message,
                            }).then(function() {
                                window.location = "<?= base_url('notulensi') ?>";
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
</script>