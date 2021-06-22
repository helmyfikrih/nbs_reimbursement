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
                <li class="active"><?= $announ[0]['announ_number'] ?></li>
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

                                <h4 class="blue"> <?= $announ[0]['announ_number'] ?></h4>
                                <span class="label label-primary">
                                    <i class="ace-icon fa fa-user bigger-120"></i>
                                    <?= $announ[0]['user_username'] ?>
                                </span>
                                <span class="label label-info">
                                    <i class="ace-icon fa fa-cog bigger-120"></i>
                                    <?= $announ[0]['role_name'] ?>
                                </span>
                                <span class="label label-purple">
                                    <i class="ace-icon fa fa-calendar bigger-120"></i>
                                    <?= P(date('d/m/Y H:i:s', strtotime($announ[0]['announ_created_date']))) ?>
                                </span>
                                <span class="label label-yellow">
                                    <i class="ace-icon fa fa-info bigger-120"></i>
                                    <?= $announ[0]['announ_subject'] == null ? "-" : $announ[0]['announ_subject'] ?>
                                </span>
                                <span class="label label-success">
                                    <i class="ace-icon fa fa-home bigger-120"></i>
                                    <?= $announ[0]['school_name'] == null ? "-" : $announ[0]['school_name'] ?>
                                </span>
                                <div class="hr dotted"></div>
                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name " style="min-width: 250px;"> <?= $this->lang->line('announ_number') ?> </div>

                                        <div class="profile-info-value">
                                            <?= P($announ[0]['announ_number']) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name " style="min-width: 250px;"> <?= $this->lang->line('announ_title') ?> </div>

                                        <div class="profile-info-value">
                                            <?= P($announ[0]['announ_title']) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name " style="min-width: 250px;"> <?= $this->lang->line('announ_subject') ?> </div>

                                        <div class="profile-info-value">
                                            <?= P($announ[0]['announ_subject']) ?>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name " style="min-width: 250px;"> <?= $this->lang->line('announ_date') ?> </div>

                                        <div class="profile-info-value">
                                            <?= P(date('d/m/Y', strtotime($announ[0]['announ_date']))) ?>
                                        </div>
                                    </div>

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('announ_content') ?> </div>

                                        <div class="profile-info-value">
                                            <?= ($announ[0]['announ_content']) ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php if ($announAttachment) { ?>
                            <div class="widget-box transparent">

                                <h4 class="widget-title blue smaller pull-left">
                                    <i class="ace-icon fa fa-rss orange"></i>
                                    <?= $this->lang->line('announ_attach') ?>
                                </h4>
                                <div>
                                    &nbsp;
                                    <hr>
                                </div>

                                <div class="widget-body">
                                    <div class="widget-main padding-8">

                                        <ul class="ace-thumbnails clearfix center">
                                            <?php foreach ($announAttachment as $attch) {
                                                $ext = pathinfo($attch['aa_name'], PATHINFO_EXTENSION);
                                                $filename = $attch['aa_name'];
                                                $multimediaArr = array('mp4', 'mkv', 'mov', 'avi', 'mpeg4', 'mp3');
                                            ?>

                                                <li>
                                                    <?php if (in_array($ext, $multimediaArr)) { ?>
                                                        <video width="150" height="150" controls>
                                                            <source src="<?= $attch['aa_dir'] ?>" type="video/mp4">
                                                            Your browser does not support the video tag.
                                                        </video>
                                                        <!-- <embed width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/document/<?= $filename ?>" /> -->
                                                    <?php } else if ($ext == "pdf") { ?>
                                                        <embed width="150" height="150" alt="150x150" src="<?= $attch['aa_dir'] ?>" />
                                                    <?php } else { ?>
                                                        <a href="<?= $attch['aa_dir'] ?>" title="" data-rel="colorbox">
                                                            <img width="150" height="150" alt="150x150" src="<?= $attch['aa_dir'] ?>" />
                                                        </a>
                                                    <?php } ?>

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
            <?php if ((in_array($menu_allow . '_validasi', $user_allow_menu)) && (in_array($announ[0]['notulensi_status'], array(2)))) { ?>
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

</script>