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
                    <a href="#"><?= $this->lang->line('document_title') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('document_edit') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1><?= $this->lang->line('document_edit') ?> </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <?php echo form_open_multipart('document/saveEdit', 'class="form-horizontal" id="form" role="form"'); ?>
                    <div class="col-md-12">
                        <div class="col-xs-6">
                            <div>
                                <label for="notulensi_date">
                                    <?= $this->lang->line('document_name') ?>
                                    <small class="text-warning"></small>
                                </label>

                                <input class="form-control" type="text" id="document_name" name="document_name" placeholder="EX: Dokumen Persentasi" required value="<?= P($docDetail[0]['document_name']) ?>">
                                <input class="form-control hidden" type="text" id="document_id" name="document_id" placeholder="EX: Dokumen Persentasi" required value="<?= $docDetail[0]['document_id'] ?>">
                                <input class="form-control hidden" type="text" id="document_code" name="document_code" placeholder="EX: Dokumen Persentasi" required value="<?= $docDetail[0]['document_code'] ?>">
                            </div>
                        </div>
                        <div class="col-xs-6">
                            <div>
                                <label for="form-field-mask-2">
                                    <?= $this->lang->line('document_up_req') ?>
                                    <!-- <small class="text-warning">(999) 999-9999</small> -->
                                </label>

                                <select class="select2 form-control" name="option" id="option" data-placeholder="Pilih Option..." disabled required>
                                    <option value=""></option>
                                    <option value="2"><?= $this->lang->line('document_upload') ?></option>
                                    <option value="3"><?= $this->lang->line('document_request') ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-12" id="uploadAdditionalData">
                        <hr>
                        <div class="col-xs-6">
                            <div>
                                <label for="form-field-mask-2">
                                    <?= $this->lang->line('document_category') ?>
                                    <!-- <small class="text-warning">(999) 999-9999</small> -->
                                </label>

                                <select class="select2 form-control" name="documentType" id="documentType" data-placeholder="Pilih Option..." required>
                                    <option value=""> </option>
                                    <?php foreach ($documentType as $type) { ?>
                                        <option value="<?= $type['doctype_id'] ?>"><?= $type['doctype_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-6" id="subjectDiv" hidden>
                            <div>
                                <label for="form-field-mask-2">
                                    <?= $this->lang->line('document_subject') ?>
                                    <!-- <small class="text-warning">(999) 999-9999</small> -->
                                </label>

                                <select class="select2 form-control" name="subject" id="subject" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                                    <option value=""> </option>
                                    <?php foreach ($subjects as $subj) { ?>
                                        <option value="<?= $subj['subject_id'] ?>"><?= $subj['subject_name'] ?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <hr>
                        <?php
                        if ($this->session->userdata('logged_in')['role_id'] == 1) {
                        ?>
                            <div class="col-xs-6">
                                <div>
                                    <label for="form-field-mask-2">
                                        <?= $this->lang->line('text_school') ?>
                                        <!-- <small class="text-warning">(999) 999-9999</small> -->
                                    </label>

                                    <select class="select2 form-control" name="school_id" id="school_id" data-placeholder="<?= $this->lang->line('text_select_option') ?>" required>
                                        <option value=""> </option>
                                        <?php foreach ($schools as $school) { ?>
                                            <option value="<?= EncryptString($school['school_id']) ?>"><?= $school['school_name'] ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                    <div class="col-xs-12">
                        <hr>
                        <div>
                            <label for="form-field-mask-2">
                                <?= $this->lang->line('document_desc') ?>
                                <small class="text-warning"></small>
                            </label>

                            <div class="input-group">
                                <textarea id="document_desc" class="autosize-transition form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 92px;" name="document_desc">
                                    <?= P($docDetail[0]['document_desc']) ?>
                                </textarea>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <hr>
                        <div id="addFile" hidden>

                            <a class="btn btn-success add_button">
                                <i class="ace-icon fa fa-plus bigger-110"></i>
                                <?= $this->lang->line('document_add_attach') ?>
                            </a>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <hr>
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-small">
                                <h4 class="widget-title blue smaller pull-left">
                                    <i class="ace-icon fa fa-file blue"></i>
                                    <?= $this->lang->line('document_attach') ?>
                                </h4>

                                <div class="widget-toolbar action-buttons">
                                </div>
                            </div>
                            <div>
                                &nbsp;

                            </div>
                            <?php if ($docAttachment) {
                                $multimediaArr = array('mp4', 'mkv', 'mov', 'avi', 'mpeg4', 'mp3');
                            ?>
                                <ul class="ace-thumbnails clearfix">
                                    <?php foreach ($docAttachment as $attch) {
                                        $ext = pathinfo($attch['da_name'], PATHINFO_EXTENSION);
                                    ?>
                                        <li id="file_<?= $attch['da_id'] ?>">
                                            <?php if (in_array($ext, $multimediaArr)) { ?>
                                                <video width="150" height="150" controls>
                                                    <source src="<?= base_url() ?>assets/uploads/document/<?= $attch['da_name'] ?>" type="video/mp4">
                                                    Your browser does not support the video tag.
                                                </video>
                                            <?php } else if ($ext == "pdf") { ?>
                                                <embed width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/document/<?= $attch['da_name'] ?>" />
                                            <?php } else { ?>
                                                <a href="<?= base_url() ?>assets/uploads/document/<?= $attch['da_name'] ?>" data-rel="colorbox" class="cboxElement">
                                                    <img width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/document/<?= $attch['da_name'] ?>">
                                                </a>
                                            <?php } ?>
                                            <div class="tags">
                                                <span class="label-holder">
                                                    <span class="label label-info"> <i class="ace-icon fa fa-upload"></i> <?= $this->lang->line('text_by') ?> <?= P($attch['user_username']) ?></span>
                                                </span>
                                            </div>
                                            <div class="tools">
                                                <a href="javascript:;" onclick="deleteImg(<?= $attch['da_id'] ?>)">
                                                    <i class="ace-icon fa fa-times red"></i>
                                                </a>
                                            </div>
                                        </li>
                                    <?php } ?>
                                </ul>
                            <?php } ?>
                        </div><!-- PAGE CONTENT ENDS -->
                        <div id="fileWrapper">
                            <div class="field_wrapper">
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
    <script src="<?= base_url() ?>assets/js/select2.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?= base_url() ?>assets/plugins/ckfinder/ckfinder.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
    <script src="<?= base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?= base_url() ?>assets/js/moment.min.js"></script>
    <script src="<?= base_url() ?>assets/js/jquery.colorbox.min.js"></script>

    <!-- ace scripts -->
    <script src="<?= base_url() ?>assets/js/ace-elements.min.js"></script>
    <script src="<?= base_url() ?>assets/js/ace.min.js"></script>
    <!-- inline scripts related to this page -->

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


        function deleteImg(id) {
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
                        url: '<?= base_url('document/deleteImg') ?>',
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
            $('#option').change(function() {
                if ($(this).val() == 2) {
                    $("#addFile").attr("hidden", false);
                    $(".files").remove();
                } else {
                    $("#addFile").attr("hidden", true);
                    $(".files").remove();
                }
            });
            $('#documentType').change(function() {

                var selectedText = $("#documentType option:selected").html();
                if (selectedText.includes("Bahan Ajar") || selectedText.includes("aahan ajar")) {
                    $("#subjectDiv").attr("hidden", false);
                    $("#subject").attr("required", true);
                    $(".select2").select2();
                } else {
                    $("#subjectDiv").attr("hidden", true);
                    $("#subject").attr("required", false);
                    $("#subject").val('');
                }
            });
            $('#documentType').val(<?= $docDetail[0]['doctype_id'] ?>)
            $('#subject').val(<?= $docDetail[0]['subject_id'] ?>)
            $('#documentType').trigger('change');
            $('#option').val(<?= $docDetail[0]['document_status'] ?>);
            $('#option').trigger('change');
            $('#school_id').val("<?= EncryptString($docDetail[0]['school_id']) ?>");
            $('#school_id').trigger('change'); // Notify only Select2 of changes

            $('#option').on('select2:unselect', function(e) {
                $("#addFile").attr("hidden", true);
                $(".files").remove();
            });

            var maxField = 10; //Input fields increment limitation
            var addButton = $('.add_button'); //Add button selector
            var wrapper = $('.field_wrapper'); //Input field wrapper
            var fieldHTML = `<div class="form-group files col-md-6">
                                <a href="javascript:void(0);" class="remove_button">
                                    <i class="ace-icon red fa fa-close bigger-110"></i>
                                </a>
                                <div class="col-md-12">
                                    <input class="file" name="files[]" type="file"/>
                                </div>
                            </div>`; //New input field html 
            var x = 1; //Initial field counter is 1
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
            var editor = CKEDITOR.replace('document_desc');
            CKFinder.setupCKEditor(editor);
            //override dialog's title function to allow for HTML titles
            // $.widget("ui.dialog", $.extend({}, $.ui.dialog.prototype, {
            //     _title: function(title) {
            //         var $title = this.options.title || '&nbsp;'
            //         if (("title_html" in this.options) && this.options.title_html == true)
            //             title.html($title);
            //         else title.text($title);
            //     }
            // }));
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
            var fileWrap = $(".file");
            var multi = (".file");
            var valid = true;
            var option = $("#option").val();
            $(multi).each(function() {
                var fieldVal = $(this).val();
                if (!fieldVal) valid = false;
            });
            if ((option == 1) && (fileWrap.length <= 0)) {
                Toast.fire({
                    icon: 'warning',
                    title: "<?= $this->lang->line('document_warning_no_file') ?>"
                })
                return;
            }

            if (!valid) {
                Toast.fire({
                    icon: 'warning',
                    title: " <?= $this->lang->line('document_warning_some_file_miss') ?>"
                })
                return;
            }
            Swal.fire({
                title: '<?= $this->lang->line('warning_approval') ?>',
                text: "<?= $this->lang->line('document_warning_submit') ?>",
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
                                    window.location = "<?= base_url('document') ?>";
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