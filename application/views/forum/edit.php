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
                    <a href="#"><?= $this->lang->line('forum_title') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('forum_edit') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <h1><?= $this->lang->line('forum_edit') ?> </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <?php echo form_open_multipart('forum/save', 'class="form-horizontal" id="form" role="form"'); ?>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('forum_title2') ?>
                            <small class="text-warning"></small>
                        </label>

                        <div class="input-group">
                            <span class="input-group-addon">
                                <!-- <i class="ace-icon fa fa-phone"></i> -->
                            </span>

                            <input class="form-control hidden" type="text" id="post_id" name="post_id" required value="<?= $dataForum['forum_id'] ?>">
                            <input class="form-control " type="text" id="post_title" name="post_title" required value="<?= P($dataForum['forum_title']) ?>">
                        </div>
                    </div>
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('forum_category') ?>
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <div class="input-group">
                            <span class="input-group-addon">
                                <!-- <i class="ace-icon fa fa-phone"></i> -->
                            </span>
                            <div class="inline">
                                <input class="form-control " type="text" id="post_category" name="post_category" value="<?= P($dataForum['forum_category']) ?>">
                            </div>
                        </div>
                    </div>
                    <div hidden>
                        <hr>
                        <label for="form-field-mask-2">
                            Mata Pelajaran
                            <!-- <small class="text-warning">(999) 999-9999</small> -->
                        </label>

                        <div class="input-group">
                            <span class="input-group-addon">
                                <!-- <i class="ace-icon fa fa-phone"></i> -->
                            </span>

                            <input class="form-control" type="text" id="post_mapel" name="post_mapel">
                        </div>
                    </div>
                    <hr>
                    <div>
                        <label for="form-field-mask-2">
                            <?= $this->lang->line('forum_content') ?>
                            <small class="text-warning"></small>
                        </label>

                        <div class="input-group">
                            <span class="input-group-addon">
                                <!-- <i class="ace-icon fa fa-phone"></i> -->
                            </span>

                            <textarea id="post_content" class="autosize-transition form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 92px;" name="post_content" required><?= P($dataForum['forum_content']) ?></textarea>
                        </div>
                    </div>


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
<script src="<?= base_url() ?>assets/js/bootstrap-tag.min.js"></script>
<!-- inline scripts related to this page -->


<script type="text/javascript">
    $(document).ready(function() {
        var editor = CKEDITOR.replace('post_content');
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
        // $('#kategori').select2();
        // $('#kategori').on('select2:select', function(e) {
        //     let data = e.params.data;
        //     if (data.id == 1) {
        //         $('#mapelDiv').removeAttr('hidden');
        //     } else {
        //         $('#mapelDiv').attr('hidden', true);
        //     }
        //     console.log(e.params.data)
        // });
        // $('#mapel').select2();
        // getMapel();

    })
</script>

<script type="text/javascript">
    jQuery(function($) {

        // category tag input
        var tag_input = $('#post_category');
        try {
            tag_input.tag({
                placeholder: tag_input.attr('placeholder'),
                //enable typeahead by specifying the source array
                // source: ace.vars['US_STATES'], //defined in ace.js >> ace.enable_search_ahead

                //or fetch data from database, fetch those that match "query"
                source: function(query, process) {
                    $.ajax({
                            url: '<?= base_url('kms/tags') ?>?q=' + encodeURIComponent(query),
                            global: false,
                            dataType: 'json',
                        })
                        .done(function(result_items) {
                            // console.log(result_items)
                            process(result_items);
                        });
                }

            })

            //programmatically add/remove a tag
            var $tag_obj = $('#post_category').data('tag');
            // $tag_obj.add('Programmatically Added');

            var index = $tag_obj.inValues('some tag');
            $tag_obj.remove(index);
        } catch (e) {
            //display a textarea for old IE, because it doesn't support this plugin or another one I tried!
            tag_input.after('<textarea id="' + tag_input.attr('id') + '" name="' + tag_input.attr('name') + '" rows="3">' + tag_input.val() + '</textarea>').remove();
            //autosize($('#form-field-tags'));
        }

        $('.tree-container').ace_scroll({
            size: 250,
            mouseWheelLock: true
        });
        $('#cat-tree').on('closed.fu.tree disclosedFolder.fu.tree', function() {
            $('.tree-container').ace_scroll('reset').ace_scroll('start');
        });



        //select2 location element
        $('.select2').css('min-width', '150px').select2({
            allowClear: true
        });


        //jQuery ui distance slider
        $("#slider-range").css('width', '150px').slider({
            range: true,
            min: 0,
            max: 100,
            values: [17, 67],
            slide: function(event, ui) {
                var val = ui.values[$(ui.handle).index() - 1] + "";

                if (!ui.handle.firstChild) {
                    $("<div class='tooltip bottom in' style='display:none;left:-6px;top:14px;'><div class='tooltip-arrow'></div><div class='tooltip-inner'></div></div>")
                        .prependTo(ui.handle);
                }
                $(ui.handle.firstChild).show().children().eq(1).text(val);
            }
        }).find('span.ui-slider-handle').on('blur', function() {
            $(this.firstChild).hide();
        });


        //this is for demo only
        $('.thumbnail').on('mouseenter', function() {
            $(this).find('.info-label').addClass('label-primary');
        }).on('mouseleave', function() {
            $(this).find('.info-label').removeClass('label-primary');
        });


        //toggle display format buttons
        $('#toggle-result-format .btn').tooltip({
            container: 'body'
        }).on('click', function(e) {
            $(this).siblings().each(function() {
                $(this).removeClass($(this).attr('data-class')).addClass('btn-grey');
            });
            $(this).removeClass('btn-grey').addClass($(this).attr('data-class'));
        });

        ////////////////////
        //show different search page
        $('#toggle-result-page .btn').on('click', function(e) {
            var target = $(this).find('input[type=radio]');
            var which = parseInt(target.val());
            $('.search-page').parent().addClass('hide');
            $('#search-page-' + which).parent().removeClass('hide');
        });
    });
</script>

<script>
    $('#form').on('submit', (function(e) {

        e.preventDefault();
        let forum = CKEDITOR.instances['post_content'].getData();
        if (forum == '') {
            Toast.fire({
                icon: 'warning',
                title: "<?= $this->lang->line('forum_warning_empty_content') ?>"
            });
            return;
        }

        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('forum_warning_submit') ?>",
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
                                window.location.replace('<?= base_url('forum/view/') ?>' + `${response.forum_id}/${response.forum_slug}`);
                            });
                        } else {
                            $('#dialog-confirm').dialog("close");
                            Toast.fire({
                                icon: '<?= $this->lang->line('text_error') ?>',
                                title: response.message
                            })

                        }

                    },
                    error: function(xhr, status, error) {
                        //console.log(xhr);
                        $('#dialog-confirm').dialog("close");
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