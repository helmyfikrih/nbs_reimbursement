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
                <li class="active"><?= $schoolDetail[0]['school_name'] ? P($schoolDetail[0]['school_name']) : '' ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1>
                    <?= $schoolDetail[0]['school_name'] ? P($schoolDetail[0]['school_name']) : '' ?>
                    <!-- <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        3 styles with inline editable feature
                    </small> -->
                </h1>
            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div>
                        <div id="user-profile-1" class="user-profile row">
                            <div class="col-xs-12 col-sm-3 center">
                                <div>
                                    <!-- <span class="profile-picture">
                                        <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?= base_url() ?>assets/images/avatars/'avatar2.png' ?>" />
                                    </span> -->

                                    <div class="space-4"></div>

                                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                            <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                                <!-- <i class="ace-icon fa fa-circle light-green"></i> -->
                                                &nbsp;
                                                <span class="white"><?= P($schoolDetail[0]['school_nsm']) ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-6"></div>

                                <div class="profile-contact-info">
                                    <div class="profile-contact-links align-left">
                                        <a href="#" class="btn btn-link">
                                            <i class="ace-icon fa fa-phone bigger-120 green"></i>
                                            <?= $schoolDetail[0]['school_phone'] ? $schoolDetail[0]['school_phone'] : '' ?>
                                        </a>
                                        <!-- <a href="#" class="btn btn-link">
                                            <i class="ace-icon fa fa-globe bigger-125 blue"></i>
                                            www.alexdoe.com
                                        </a> -->
                                    </div>

                                    <div class="space-6"></div>

                                    <!-- <div class="profile-social-links align-center">
                                        <a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
                                            <i class="middle ace-icon fa fa-facebook-square fa-2x blue"></i>
                                        </a>

                                        <a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
                                            <i class="middle ace-icon fa fa-twitter-square fa-2x light-blue"></i>
                                        </a>

                                        <a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
                                            <i class="middle ace-icon fa fa-pinterest-square fa-2x red"></i>
                                        </a>
                                    </div> -->
                                </div>

                                <!-- <div class="hr hr12 dotted"></div>

                                <div class="clearfix">
                                    <div class="grid2">
                                        <span class="bigger-175 blue">25</span>

                                        <br />
                                        Followers
                                    </div>

                                    <div class="grid2">
                                        <span class="bigger-175 blue">12</span>

                                        <br />
                                        Following
                                    </div>
                                </div>

                                <div class="hr hr16 dotted"></div> -->
                            </div>

                            <div class="col-xs-12 col-sm-9">
                                <!-- <div class="center">
                                    <span class="btn btn-app btn-sm btn-light no-hover">
                                        <span class="line-height-1 bigger-170 blue"> 1,411 </span>

                                        <br />
                                        <span class="line-height-1 smaller-90"> Views </span>
                                    </span>

                                    <span class="btn btn-app btn-sm btn-yellow no-hover">
                                        <span class="line-height-1 bigger-170"> 32 </span>

                                        <br />
                                        <span class="line-height-1 smaller-90"> Followers </span>
                                    </span>

                                    <span class="btn btn-app btn-sm btn-pink no-hover">
                                        <span class="line-height-1 bigger-170"> 4 </span>

                                        <br />
                                        <span class="line-height-1 smaller-90"> Projects </span>
                                    </span>

                                    <span class="btn btn-app btn-sm btn-grey no-hover">
                                        <span class="line-height-1 bigger-170"> 23 </span>

                                        <br />
                                        <span class="line-height-1 smaller-90"> Reviews </span>
                                    </span>

                                    <span class="btn btn-app btn-sm btn-success no-hover">
                                        <span class="line-height-1 bigger-170"> 7 </span>

                                        <br />
                                        <span class="line-height-1 smaller-90"> Albums </span>
                                    </span>

                                    <span class="btn btn-app btn-sm btn-primary no-hover">
                                        <span class="line-height-1 bigger-170"> 55 </span>

                                        <br />
                                        <span class="line-height-1 smaller-90"> Contacts </span>
                                    </span>
                                </div> -->

                                <div class="space-12"></div>

                                <div class="profile-user-info profile-user-info-striped">
                                    <div class="profile-info-row">
                                        <div class="profile-info-name" style="width: 40%;"> <?= $this->lang->line('school_name') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $schoolDetail[0]['school_name'] ? P($schoolDetail[0]['school_name']) : '' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('school_nsm') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $schoolDetail[0]['school_nsm'] ? P($schoolDetail[0]['school_nsm']) : '' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('school_address') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $schoolDetail[0]['school_address'] ? P($schoolDetail[0]['school_address']) : '' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('school_type') ?></div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= P($schoolDetail[0]['school_type']) ?></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- PAGE CONTENT ENDS -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->