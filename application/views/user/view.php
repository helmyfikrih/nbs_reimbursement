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
                <li class="active"><?= $userDetail[0]['user_username'] ? $userDetail[0]['user_username'] : 'Tidak Ada' ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1>
                    <?= $userDetail[0]['user_username'] ? $userDetail[0]['user_username'] : 'Tidak Ada' ?>
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
                                    <span class="profile-picture">
                                        <img id="avatar" class="editable img-responsive" alt="Alex's Avatar" src="<?= base_url() ?>assets/images/avatars/<?= $userDetail[0]['ud_img_name'] ? $userDetail[0]['ud_img_name'] :  'avatar2.png' ?>" />
                                    </span>

                                    <div class="space-4"></div>

                                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                            <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                                <!-- <i class="ace-icon fa fa-circle light-green"></i> -->
                                                &nbsp;
                                                <span class="white"><?= $userDetail[0]['user_f_name'] ? $userDetail[0]['user_f_name'] :  $userDetail[0]['user_username'] ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-6"></div>

                                <div class="profile-contact-info">
                                    <div class="profile-contact-links align-left">
                                        <a href="#" class="btn btn-link">
                                            <i class="ace-icon fa fa-phone bigger-120 green"></i>
                                            <?= $userDetail[0]['ud_phone'] ? $userDetail[0]['ud_phone'] : 'Tidak Ada' ?>
                                        </a>

                                        <a href="#" class="btn btn-link">
                                            <i class="ace-icon fa fa-envelope bigger-120 pink"></i>
                                            <?= $userDetail[0]['user_email'] ? wordwrap($userDetail[0]['user_email'], 18, "<br>\n") : '-' ?>
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
                                        <div class="profile-info-name"> <?= $this->lang->line('profile_username') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['user_username'] ? $userDetail[0]['user_username'] : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> NIK / NIP / NIS </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['ud_nik'] ? $userDetail[0]['ud_nik'] : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('text_school') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['school_name'] ? $userDetail[0]['school_name'] : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> N<?= $this->lang->line('profile_full_name') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['user_f_name'] ? $userDetail[0]['user_f_name'] : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('profile_gender') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['ud_phone'] == 'L' ? 'Laki-Laki' : 'Perempuan' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('profile_birth_place') ?>, <?= $this->lang->line('profile_birth_date') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['ud_birth_place'] ? $userDetail[0]['ud_birth_place'] : 'Tidak Ada' ?>, <?= $userDetail[0]['ud_birth_date'] ? date('d/m/Y', strtotime($userDetail[0]['ud_birth_date'])) : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('profile_address') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['ud_address'] ? $userDetail[0]['ud_address'] : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('text_designation') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['designation_name'] ? $userDetail[0]['designation_name'] : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('text_role') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['role_name'] ? $userDetail[0]['role_name'] : 'Tidak Ada' ?></span>
                                        </div>
                                    </div>
                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('text_subject') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="username"><?= $userDetail[0]['subject_name'] ? $userDetail[0]['subject_name'] : '  ' ?></span>
                                        </div>
                                    </div>

                                    <!-- <div class="profile-info-row">
                                        <div class="profile-info-name"> Location </div>

                                        <div class="profile-info-value">
                                            <i class="fa fa-map-marker light-orange bigger-110"></i>
                                            <span class="editable" id="country">Netherlands</span>
                                            <span class="editable" id="city">Amsterdam</span>
                                        </div>
                                    </div> -->

                                    <div class="profile-info-row">
                                        <div class="profile-info-name"> <?= $this->lang->line('profile_joined') ?> </div>

                                        <div class="profile-info-value">
                                            <span class="editable" id="signup"><?= $userDetail[0]['user_created_date'] ? $userDetail[0]['user_created_date'] : 'Tidak Ada' ?></span>
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
