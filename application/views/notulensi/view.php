<?php
$labelColor = "";
$labelText = "";
$labelIcon = "";
if ($noteData[0]['notulensi_status'] == 1) {
    $labelColor = "success";
    $labelText = $this->lang->line('notulensi_valid');
    $labelIcon = "fa-check-square-o";
}
if ($noteData[0]['notulensi_status'] == 2) {
    $labelColor = "warning";
    $labelText = $this->lang->line('notulensi_waiting_valid');
    $labelIcon = "fa-exclamation-triangle";
}
if ($noteData[0]['notulensi_status'] == 3) {
    $labelColor = "danger";
    $labelText = $this->lang->line('notulensi_invalid');
    $labelIcon = "fa-close";
}
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
                    <a href="#"><?= $this->lang->line('notulensi_title') ?></a>
                </li>
                <li class="active"><?= $noteData[0]['notulensi_code'] ?></li>
            </ul><!-- /.breadcrumb -->

            <!-- <div class="nav-search" id="nav-search">
                <form class="form-search">
                    <span class="input-icon">
                        <input type="text" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon"></i>
                    </span>
                </form>
            </div> -->
            <!-- /.nav-search -->
        </div>

        <div class="page-content">
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div>
                        <div class="col-xs-12 col-sm-12">
                            <div class="space-12"></div>
                            <div class="well well-lg">

                                <h4 class="blue"> <?= $noteData[0]['notulensi_code'] ?></h4>
                                <span class="label label-primary">
                                    <i class="ace-icon fa fa-user bigger-120"></i>
                                    <?= $noteData[0]['user_username'] ?>
                                </span>
                                <span class="label label-info">
                                    <i class="ace-icon fa fa-cog bigger-120"></i>
                                    <?= $noteData[0]['role_name'] ?>
                                </span>
                                <span class="label label-purple">
                                    <i class="ace-icon fa fa-calendar bigger-120"></i>
                                    <?= $noteData[0]['notulensi_created_date'] ?>
                                </span>
                                <span class="label label-<?= $labelColor ?>">
                                    <i class="ace-icon fa <?= $labelIcon ?> bigger-120"></i>
                                    <?= $labelText ?>
                                </span>
                                <span class="label label-info">
                                    <i class="ace-icon fa fa-info bigger-120"></i>
                                    <?= $this->lang->line('notulensi_type') ?> <?= $noteData[0]['meetType_name'] ?>
                                </span>
                                <span class="label label-success">
                                    <i class="ace-icon fa fa-home bigger-120"></i>
                                    <?= $noteData[0]['school_name'] == null ? "-" : $noteData[0]['school_name'] ?>
                                </span>
                                <div class="hr dotted"></div>
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name " style="min-width: 250px;"> <?= $this->lang->line('notulensi_agenda') ?> </div>

                                        <div class="profile-info-value">
                                            <?= P($noteData[0]['notulensi_agenda']) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name " style="min-width: 250px;"> <?= $this->lang->line('notulensi_leader') ?> </div>

                                        <div class="profile-info-value">
                                            <?= P($noteData[0]['notulensi_leader']) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('notulensi_place') ?> </div>

                                        <div class="profile-info-value">
                                            <?= P($noteData[0]['notulensi_place']) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('notulensi_date') ?> </div>

                                        <div class="profile-info-value">
                                            <?= date('d/m/Y', strtotime(P($noteData[0]['notulensi_date']))) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('notulensi_start') ?> </div>

                                        <div class="profile-info-value">
                                            <?= $noteData[0]['notulensi_start'] ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('notulensi_end') ?> </div>

                                        <div class="profile-info-value">
                                            <?= $noteData[0]['notulensi_end'] ?>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('notulensi_result') ?> </div>

                                        <div class="profile-info-value">
                                            <?= ($noteData[0]['notulensi_content']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($noteAttachment) { ?>
                            <div class="widget-box transparent">

                                <h4 class="widget-title blue smaller pull-left">
                                    <i class="ace-icon fa fa-rss orange"></i>
                                    <?= $this->lang->line('notulensi_attach') ?>
                                </h4>
                                <div>
                                    &nbsp;
                                    <hr>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main padding-8">

                                        <ul class="ace-thumbnails clearfix center">
                                            <?php foreach ($noteAttachment as $attch) { ?>

                                                <li>
                                                    <a href="<?= base_url() ?>assets/uploads/notulensi/<?= $attch['na_name'] ?>" title="" data-rel="colorbox">
                                                        <img width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/notulensi/<?= $attch['na_name'] ?>" />
                                                    </a>

                                                    <div class="tags">
                                                    </div>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>

                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
            <?php if ((in_array($menu_allow . '_validasi', $user_allow_menu)) && (in_array($noteData[0]['notulensi_status'], array(2))) && $this->session->userdata('logged_in')['school_id'] == $noteData[0]['school_id']) { ?>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <a class="btn btn-success" href="javascript:;" onclick="approval(1)">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            <?= $this->lang->line('notulensi_valid_btn') ?>
                        </a>
                        &nbsp; &nbsp; &nbsp;
                        <a class="btn btn-danger" href="javascript:;" onclick="approval(3)">
                            <i class="ace-icon fa fa-close bigger-110"></i>
                            <?= $this->lang->line('notulensi_invalid_btn') ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
            <?php if ((in_array($menu_allow . '_validasi', $user_allow_menu)) && (in_array($noteData[0]['notulensi_status'], array(2))) && $this->session->userdata('logged_in')['role_id'] == 1) { ?>
                <div class="clearfix form-actions">
                    <div class="col-md-offset-3 col-md-9">
                        <a class="btn btn-success" href="javascript:;" onclick="approval(1)">
                            <i class="ace-icon fa fa-check bigger-110"></i>
                            <?= $this->lang->line('notulensi_valid_btn') ?>
                        </a>
                        &nbsp; &nbsp; &nbsp;
                        <a class="btn btn-danger" href="javascript:;" onclick="approval(3)">
                            <i class="ace-icon fa fa-close bigger-110"></i>
                            <?= $this->lang->line('notulensi_invalid_btn') ?>
                        </a>
                    </div>
                </div>
            <?php } ?>
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->


<!-- page specific plugin scripts -->
<script src="<?= base_url() ?>assets/js/jquery.colorbox.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.gritter.min.js"></script>

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

    function approval(status) {
        if (status == 1) {
            var text = 'Notulensi akan di Validasi.'
            var confirmButtonText = 'Validasi!'
        } else {
            var text = 'Notulensi Tidak Valid.'
            var confirmButtonText = 'Iya!'
        }
        Swal.fire({
            title: 'Apakah Anda Yakin?',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('notulensi/approval/' . $noteData[0]['notulensi_id']) ?>',
                    type: 'POST',
                    data: {
                        status: status
                    },
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
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
        });
    }
</script>