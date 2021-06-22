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
                <li class="active"><?= $this->lang->line('profile_title') ?></li>
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
                    <div class="tabbable">
                        <ul class="nav nav-tabs padding-18">
                            <li class="active">
                                <a data-toggle="tab" href="#home">
                                    <i class="green ace-icon fa fa-user bigger-120"></i>
                                    <?= $this->lang->line('profile_tab') ?>
                                </a>
                            </li>

                            <!-- <li>
                                <a data-toggle="tab" href="#feed">
                                    <i class="orange ace-icon fa fa-rss bigger-120"></i>
                                    Activity Feed
                                </a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#friends">
                                    <i class="blue ace-icon fa fa-users bigger-120"></i>
                                    Friends
                                </a>
                            </li>

                            <li>
                                <a data-toggle="tab" href="#pictures">
                                    <i class="pink ace-icon fa fa-picture-o bigger-120"></i>
                                    Pictures
                                </a>
                            </li> -->
                            <li>
                                <a data-toggle="tab" href="#settings">
                                    <i class="pink ace-icon fa fa-gears bigger-120"></i>
                                    <?= $this->lang->line('profile_tab_edit') ?>
                                </a>
                            </li>
                        </ul>

                        <div class="tab-content no-border padding-24">
                            <div id="home" class="tab-pane in active">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-3 center">
                                        <span class="profile-picture">
                                            <img class="editable img-responsive avatar img_clickable" src="assets/images/avatars/<?= $usDetail['avatar_name'] ?>?x=<?= time() ?>" />
                                        </span>

                                        <div class="space space-4"></div>
                                        <!-- 
                                        <a href="#" class="btn btn-sm btn-block btn-success">
                                            <i class="ace-icon fa fa-plus-circle bigger-120"></i>
                                            <span class="bigger-110">Add as a friend</span>
                                        </a>

                                        <a href="#" class="btn btn-sm btn-block btn-primary">
                                            <i class="ace-icon fa fa-envelope-o bigger-110"></i>
                                            <span class="bigger-110">Send a message</span>
                                        </a> -->
                                    </div><!-- /.col -->

                                    <div class="col-xs-12 col-sm-9">
                                        <h4 class="blue">
                                            <span class="middle"><?= $usDetail['full_name'] ?></span>

                                            <!-- <span class="label label-purple arrowed-in-right">
                                                <i class="ace-icon fa fa-circle smaller-80 align-middle"></i>
                                                online
                                            </span> -->
                                        </h4>

                                        <div class="profile-user-info">
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('profile_username') ?> </div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['username'] ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('profile_full_name') ?> </div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['full_name'] ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> NIP / NIK / NIS </div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['nik'] ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('text_school') ?></div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['school_name'] ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('profile_birth_place') ?> </div>

                                                <div class="profile-info-value">
                                                    <i class="fa fa-map-marker light-orange bigger-110"></i>
                                                    <span><?= $usDetail['birth_place'] ?></span>
                                                    <!-- <span>Amsterdam</span> -->
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('profile_birth_date') ?> </div>

                                                <div class="profile-info-value">
                                                    <span><?= date("d/m/Y", strtotime($usDetail['birth_date'])) ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('profile_address') ?> </div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['address'] ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('profile_phone') ?> </div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['phone'] ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> E-mail </div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['email'] ?></span>
                                                </div>
                                            </div>
                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> Role </div>

                                                <div class="profile-info-value">
                                                    <span><?= $usDetail['role_name'] ?></span>
                                                </div>
                                            </div>
                                            <?php
                                            if (strpos(strtolower($usDetail['role_name']), 'guru') !== false) { ?>
                                                <div class="profile-info-row">
                                                    <div class="profile-info-name"> <?= $this->lang->line('text_subject') ?> </div>

                                                    <div class="profile-info-value">
                                                        <span><?= $usDetail['subject'] ?></span>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name"> <?= $this->lang->line('profile_joined') ?> </div>

                                                <div class="profile-info-value">
                                                    <span><?= date("d/m/Y", strtotime($usDetail['join_date'])) ?></span>
                                                </div>
                                            </div>

                                            <!-- <div class="profile-info-row">
                                                <div class="profile-info-name"> Last Online </div>

                                                <div class="profile-info-value">
                                                    <span>3 hours ago</span>
                                                </div>
                                            </div> -->
                                        </div>

                                        <div class="hr hr-8 dotted"></div>

                                        <div class="profile-user-info">
                                            <!-- <div class="profile-info-row">
                                                <div class="profile-info-name"> Website </div>

                                                <div class="profile-info-value">
                                                    <a href="#" target="_blank">www.alexdoe.com</a>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name">
                                                    <i class="middle ace-icon fa fa-facebook-square bigger-150 blue"></i>
                                                </div>

                                                <div class="profile-info-value">
                                                    <a href="#">Find me on Facebook</a>
                                                </div>
                                            </div>

                                            <div class="profile-info-row">
                                                <div class="profile-info-name">
                                                    <i class="middle ace-icon fa fa-twitter-square bigger-150 light-blue"></i>
                                                </div>

                                                <div class="profile-info-value">
                                                    <a href="#">Follow me on Twitter</a>
                                                </div>
                                            </div> -->
                                        </div>
                                    </div><!-- /.col -->
                                </div><!-- /.row -->

                                <div class="space-20"></div>

                                <div class="row">
                                    <!-- <div class="col-xs-12 col-sm-6">
                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small">
                                                <h4 class="widget-title smaller">
                                                    <i class="ace-icon fa fa-check-square-o bigger-110"></i>
                                                    Little About Me
                                                </h4>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main">
                                                    <p>
                                                        My job is mostly lorem ipsuming and dolor sit ameting as long as consectetur adipiscing elit.
                                                    </p>
                                                    <p>
                                                        Sometimes quisque commodo massa gets in the way and sed ipsum porttitor facilisis.
                                                    </p>
                                                    <p>
                                                        The best thing about my job is that vestibulum id ligula porta felis euismod and nullam quis risus eget urna mollis ornare.
                                                    </p>
                                                    <p>
                                                        Thanks for visiting my profile.
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xs-12 col-sm-6">
                                        <div class="widget-box transparent">
                                            <div class="widget-header widget-header-small header-color-blue2">
                                                <h4 class="widget-title smaller">
                                                    <i class="ace-icon fa fa-lightbulb-o bigger-120"></i>
                                                    My Skills
                                                </h4>
                                            </div>

                                            <div class="widget-body">
                                                <div class="widget-main padding-16">
                                                    <div class="clearfix">
                                                        <div class="grid3 center">
                                                            <div class="easy-pie-chart percentage" data-percent="45" data-color="#CA5952">
                                                                <span class="percent">45</span>%
                                                            </div>

                                                            <div class="space-2"></div>
                                                            Graphic Design
                                                        </div>

                                                        <div class="grid3 center">
                                                            <div class="center easy-pie-chart percentage" data-percent="90" data-color="#59A84B">
                                                                <span class="percent">90</span>%
                                                            </div>

                                                            <div class="space-2"></div>
                                                            HTML5 & CSS3
                                                        </div>

                                                        <div class="grid3 center">
                                                            <div class="center easy-pie-chart percentage" data-percent="80" data-color="#9585BF">
                                                                <span class="percent">80</span>%
                                                            </div>

                                                            <div class="space-2"></div>
                                                            Javascript/jQuery
                                                        </div>
                                                    </div>

                                                    <div class="hr hr-16"></div>

                                                    <div class="profile-skills">
                                                        <div class="progress">
                                                            <div class="progress-bar" style="width:80%">
                                                                <span class="pull-left">HTML5 & CSS3</span>
                                                                <span class="pull-right">80%</span>
                                                            </div>
                                                        </div>

                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-success" style="width:72%">
                                                                <span class="pull-left">Javascript & jQuery</span>

                                                                <span class="pull-right">72%</span>
                                                            </div>
                                                        </div>

                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-purple" style="width:70%">
                                                                <span class="pull-left">PHP & MySQL</span>

                                                                <span class="pull-right">70%</span>
                                                            </div>
                                                        </div>

                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-warning" style="width:50%">
                                                                <span class="pull-left">Wordpress</span>

                                                                <span class="pull-right">50%</span>
                                                            </div>
                                                        </div>

                                                        <div class="progress">
                                                            <div class="progress-bar progress-bar-danger" style="width:38%">
                                                                <span class="pull-left">Photoshop</span>

                                                                <span class="pull-right">38%</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div> -->
                                </div>
                            </div><!-- /#home -->

                            <div id="settings" class="tab-pane">
                                <div class="col-sm-offset-1 col-sm-10">

                                    <div class="space"></div>

                                    <form class="form-horizontal" id="infoForm">
                                        <div class="tabbable">
                                            <ul class="nav nav-tabs padding-16">
                                                <li class="active">
                                                    <a data-toggle="tab" href="#edit-basic" onclick="setTypeInput('info');">
                                                        <i class="green ace-icon fa fa-pencil-square-o bigger-125"></i>
                                                        <?= $this->lang->line('profile_basic_info') ?>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a data-toggle="tab" href="#edit-username" onclick="setTypeInput('changeUsername');">
                                                        <i class="purple ace-icon fa fa-user bigger-125"></i>
                                                        <?= $this->lang->line('profile_change_username') ?>
                                                    </a>
                                                </li>

                                                <li>
                                                    <a data-toggle="tab" href="#edit-email" onclick="setTypeInput('changeEmail');">
                                                        <i class="purple ace-icon fa fa-envelope bigger-125"></i>
                                                        <?= $this->lang->line('profile_change_email') ?>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a data-toggle="tab" href="#edit-password" onclick="setTypeInput('changePassword');">
                                                        <i class="blue ace-icon fa fa-key bigger-125"></i>
                                                        <?= $this->lang->line('profile_change_password') ?>
                                                    </a>
                                                </li>
                                            </ul>

                                            <div class="tab-content profile-edit-tab-content">
                                                <div id="edit-basic" class="tab-pane in active">
                                                    <h4 class="header blue bolder smaller"><?= $this->lang->line('text_general') ?></h4>

                                                    <div class="row">
                                                        <div class="col-xs-12 col-sm-4 ">
                                                            <!-- <label class="ace-file-input ace-file-multiple" id="avatar"><span class="ace-file-container hide-placeholder selected"><span class="ace-file-name" data-title="profile-pic.jpg"><img class="middle avatar" src="<?= base_url() ?>assets/images/avatars/<?= $usDetail['avatar_name'] ?>?x=<?= time() ?>"><i class=" ace-icon fa fa-picture-o file-image"></i></span></span><a class="remove" href="javarcipt:;" onclick="removeAvatar();"><i class=" ace-icon fa fa-times"></i></a></label> -->
                                                            <a class="remove" href="javarcipt:;" onclick="removeAvatar();"><i class=" ace-icon fa fa-times"></i> <?= $this->lang->line('profile_remove_ava') ?></a>
                                                            <br />
                                                            <img class="editable img-responsive avatar" id="avatar" src="<?= base_url() ?>assets/images/avatars/<?= $usDetail['avatar_name'] ?>?x=<?= time() ?>">
                                                        </div>

                                                        <div class="vspace-12-sm"></div>

                                                        <div class="col-xs-12 col-sm-8">

                                                            <div class="space-4"></div>

                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label no-padding-right" for="fullName"> <?= $this->lang->line('profile_full_name') ?></label>

                                                                <div class="col-sm-8">
                                                                    <input class="col-xs-12 col-sm-10" type="text" placeholder="First Name" name="fullName" id="fullName" value="">
                                                                    <!-- <input class="input-small" type="text" id="form-field-last" placeholder="Last Name" value="Doe"> -->
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label no-padding-right" for="nik">NIK / NIP</label>
                                                                <div class="col-sm-8">
                                                                    <input class="col-xs-12 col-sm-10" type="text" placeholder="Ex: 11114093000027" name="nik" id="nik" value="">
                                                                    <!-- <input class="input-small" type="text" id="form-field-last" placeholder="Last Name" value="Doe"> -->
                                                                </div>
                                                            </div>

                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label no-padding-right" for="birthPlace"> <?= $this->lang->line('profile_birth_place') ?></label>
                                                                <div class="col-sm-8">
                                                                    <input class="col-xs-12 col-sm-10" type="text" placeholder="Ex: Jakarta" name="birthPlace" id="birthPlace" value="">
                                                                </div>
                                                            </div>
                                                            <div class="form-group">
                                                                <label class="col-sm-4 control-label no-padding-right" for="birthDate"><?= $this->lang->line('profile_birth_date') ?></label>

                                                                <div class="col-sm-8">
                                                                    <div class="input-medium">
                                                                        <div class="input-group">
                                                                            <input class="input-medium date-picker" type="text" data-date-format="dd/mm/yyyy" placeholder="dd/mm/yyyy" name="birthDate" id="birthDate">
                                                                            <span class="input-group-addon">
                                                                                <i class="ace-icon fa fa-calendar"></i>
                                                                            </span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <hr>


                                                    <div class="space-4"></div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right"><?= $this->lang->line('profile_gender') ?></label>

                                                        <div class="col-sm-9">
                                                            <label class="inline">
                                                                <input type="radio" class="ace" name="sex" value="L" id="L">
                                                                <span class="lbl middle"> <?= $this->lang->line('text_male') ?></span>
                                                            </label>

                                                            &nbsp; &nbsp; &nbsp;
                                                            <label class="inline">
                                                                <input type="radio" class="ace" name="sex" value="P" id="P">
                                                                <span class="lbl middle"> <?= $this->lang->line('text_female') ?></span>
                                                            </label>
                                                        </div>
                                                    </div>

                                                    <div class="space-4"></div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="address"><?= $this->lang->line('profile_address') ?></label>

                                                        <div class="col-sm-9">
                                                            <textarea class="autosize-transition form-control" id="address" name="address"></textarea>
                                                        </div>
                                                    </div>

                                                    <div class="form-group" id="divSubject">
                                                        <label class="col-sm-3 control-label no-padding-right" for="subejct"><?= $this->lang->line('text_subject') ?></label>

                                                        <div class="col-sm-9">
                                                            <div class="input-medium">
                                                                <select class="select2 form-control" name="subject" id="subject" data-placeholder="Pilih Option...">
                                                                    <option value=""></option>
                                                                    <?php foreach ($dataSubject as $subject) {
                                                                        $subjectId = $subject['subject_id'];
                                                                        $subjectName = $subject['subject_name'];
                                                                        echo "<option value='$subjectId'>$subjectName</option>";
                                                                    } ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <div class="space"></div>
                                                    <h4 class="header blue bolder smaller"><?= $this->lang->line('text_contact') ?></h4>

                                                    <div class="space-4"></div>

                                                    <!-- <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-website">Website</label>

                                                        <div class="col-sm-9">
                                                            <span class="input-icon input-icon-right">
                                                                <input type="url" id="form-field-website" value="http://www.alexdoe.com/">
                                                                <i class="ace-icon fa fa-globe"></i>
                                                            </span>
                                                        </div>
                                                    </div> -->

                                                    <div class="space-4"></div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="phone"><?= $this->lang->line('profile_phone') ?></label>

                                                        <div class="col-sm-9">
                                                            <span class="input-icon input-icon-right">
                                                                <input class="input-medium input-mask-phone" type="text" id="phone" name="phone">
                                                                <i class="ace-icon fa fa-phone fa-flip-horizontal"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <!-- <div class="space"></div>
                                                    <h4 class="header blue bolder smaller">Social</h4>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-facebook">Facebook</label>

                                                        <div class="col-sm-9">
                                                            <span class="input-icon">
                                                                <input type="text" value="facebook_alexdoe" id="form-field-facebook">
                                                                <i class="ace-icon fa fa-facebook blue"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="space-4"></div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-twitter">Twitter</label>

                                                        <div class="col-sm-9">
                                                            <span class="input-icon">
                                                                <input type="text" value="twitter_alexdoe" id="form-field-twitter">
                                                                <i class="ace-icon fa fa-twitter light-blue"></i>
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="space-4"></div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="form-field-gplus">Google+</label>

                                                        <div class="col-sm-9">
                                                            <span class="input-icon">
                                                                <input type="text" value="google_alexdoe" id="form-field-gplus">
                                                                <i class="ace-icon fa fa-google-plus red"></i>
                                                            </span>
                                                        </div>
                                                    </div> -->
                                                </div>

                                                <div id="edit-password" class="tab-pane">
                                                    <div class="space-10"></div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="oldPassword"><?= $this->lang->line('profile_old_password') ?></label>

                                                        <div class="col-sm-9">
                                                            <input type="password" id="oldPassword" name="oldPassword">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="newPassword"><?= $this->lang->line('profile_new_password') ?></label>

                                                        <div class="col-sm-9">
                                                            <input type="password" id="newPassword" name="newPassword">
                                                        </div>
                                                    </div>

                                                    <div class="space-4"></div>

                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="confirmPassword"><?= $this->lang->line('profile_conf_password') ?></label>
                                                        <div class="col-sm-9">
                                                            <input type="password" id="confirmPassword" name="confirmPassword">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="edit-email" class="tab-pane">
                                                    <div class="space-10"></div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="email">E-mail</label>

                                                        <div class="col-sm-9">
                                                            <input type="email" id="email" name="email">
                                                            <input type="email" id="oldEmail" name="oldEmail" hidden>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div id="edit-username" class="tab-pane">
                                                    <div class="space-10"></div>
                                                    <div class="form-group">
                                                        <label class="col-sm-3 control-label no-padding-right" for="username">Username</label>

                                                        <div class="col-sm-9">
                                                            <input type="text" id="username" name="username">
                                                            <input type="text" id="oldUsername" name="oldUsername" hidden>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <input type="password" id="type" name="type" value="info" hidden>
                                        <div class="clearfix form-actions">
                                            <div class="col-md-offset-3 col-md-9">
                                                <button class="btn btn-info" type="submit">
                                                    <i class="ace-icon fa fa-check bigger-110"></i>
                                                    Save
                                                </button>

                                                &nbsp; &nbsp;
                                                <button class="btn" type="reset">
                                                    <i class="ace-icon fa fa-undo bigger-110"></i>
                                                    Reset
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div><!-- /#settings -->
                        </div>
                    </div>
                </div>
                <div class="hr dotted"></div>
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div><!-- /.main-content -->

<!-- page specific plugin scripts -->
<script src="<?= base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.gritter.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootbox.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.easypiechart.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-datepicker.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.hotkeys.index.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-wysiwyg.min.js"></script>
<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/js/spinbox.min.js"></script>
<script src="<?= base_url() ?>assets/js/bootstrap-editable.min.js"></script>
<script src="<?= base_url() ?>assets/js/ace-editable.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.maskedinput.min.js"></script>
<script src="<?= base_url() ?>assets/js/autosize.min.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
    function clearPassword() {
        $("#oldPassword").val('');
        $("#newPassword").val('');
        $("#confirmPassword").val('');
    }

    function removeAvatar() {
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('profile_remove_ava') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('profile/removeAvatar') ?>',
                    type: 'POST',
                    data: {},
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            d = new Date();
                            $(".avatar").attr("src", "assets/images/avatars/" + response.imgName + "?" + d.getTime());
                            // $('#infoForm').trigger("reset");
                            clearPassword();
                            $('a[href="#edit-basic"]').trigger('click');
                        } else {
                            // Toast.fire({
                            //     icon: 'warning',
                            //     title: response.message
                            // })
                            $.gritter.add({
                                title: '<?= $this->lang->line('text_failed') ?>',
                                text: response.message,
                                class_name: 'gritter-warning gritter-light'
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        Toast.fire({
                            icon: 'danger',
                            title: "Connection Timeout <br> Status : " + xhr.statusText
                        })
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        })
    }

    $(document).ready(function() {
        autosize($('textarea[class*=autosize]'));
        // Set Form
        var role = '<?= $usDetail['role_name'] ?>';
        if ((role.indexOf("Guru") >= 0) || role.indexOf("guru") >= 0) {
            $("#divSubject").attr("hidden", false);
            $("#subject").val('<?= $usDetail['subject_id'] ?>');
            $("#subject").trigger("change");
        } else {
            $("#divSubject").val('');
            $("#divSubject").attr("hidden", true);
        }
        $("#oldUsername").val('<?= $usDetail['username'] ?>');
        $("#username").val('<?= $usDetail['username'] ?>');
        $("#fullName").val('<?= $usDetail['full_name'] ?>');
        $("#nik").val('<?= $usDetail['nik'] ?>');
        $("#address").val(`<?= $usDetail['address'] ?>`);
        $("#email").val('<?= $usDetail['email'] ?>');
        $("#oldEmail").val('<?= $usDetail['email'] ?>');
        $("#phone").val('<?= $usDetail['phone'] ?>');
        $("#birthPlace").val('<?= $usDetail['birth_place'] ?>');
        $("#birthDate").val('<?= date("d/m/Y", strtotime($usDetail['birth_date'])) ?>');
        if ('<?= $usDetail['sex'] ?>' == 'L') {
            $('#L').prop("checked", true);
        } else if ('<?= $usDetail['sex'] ?>' == 'L') {
            $('#P').prop("checked", true);
        } else {
            $('#L').prop("checked", false);
            $('#P').prop("checked", false);
        }
        $('#subject').val('<?= $usDetail['subject_id'] ? $usDetail['subject_id'] : '' ?>');
        $('#subject').trigger('change');
    });
</script>
<script type="text/javascript">
    jQuery(function($) {
        $('.date-picker').datepicker();
        //editables on first profile page
        $.fn.editable.defaults.mode = 'inline';
        $.fn.editableform.loading = "<div class='editableform-loading'><i class='ace-icon fa fa-spinner fa-spin fa-2x light-blue'></i></div>";
        $.fn.editableform.buttons = '<button type="submit" class="btn btn-info editable-submit"><i class="ace-icon fa fa-check"></i></button>' +
            '<button type="button" class="btn editable-cancel"><i class="ace-icon fa fa-times"></i></button>';

        //editables 

        // *** editable avatar *** //
        try { //ie8 throws some harmless exceptions, so let's catch'em

            //first let's add a fake appendChild method for Image element for browsers that have a problem with this
            //because editable plugin calls appendChild, and it causes errors on IE at unpredicted points
            try {
                document.createElement('IMG').appendChild(document.createElement('B'));
            } catch (e) {
                Image.prototype.appendChild = function(el) {}
            }

            var last_gritter
            $('#avatar').editable({
                type: 'image',
                name: 'avatar',
                value: null,
                //onblur: 'ignore',  //don't reset or hide editable onblur?!
                image: {
                    //specify ace file input plugin's options here
                    btn_choose: 'Change Avatar',
                    droppable: true,
                    maxSize: 410000000, //~4MB

                    //and a few extra ones here
                    name: 'avatar', //put the field name here as well, will be used inside the custom plugin
                    on_error: function(error_type) { //on_error function will be called when the selected file has a problem
                        if (last_gritter) $.gritter.remove(last_gritter);
                        if (error_type == 1) { //file format error
                            last_gritter = $.gritter.add({
                                title: 'File is not an image!',
                                text: 'Please choose a jpg|png image!',
                                class_name: 'gritter-error gritter-center'
                            });
                        } else if (error_type == 2) { //file size rror
                            last_gritter = $.gritter.add({
                                title: 'File too big!',
                                text: 'Image size should not exceed 10MB!',
                                class_name: 'gritter-error gritter-center'
                            });
                        } else { //other error
                        }
                    },
                    on_success: function() {
                        $.gritter.removeAll();
                    }
                },
                url: function(params) {
                    // ***UPDATE AVATAR HERE*** //
                    //for a working upload example you can replace the contents of this function with 
                    //examples/profile-avatar-update.js
                    var deferred = new $.Deferred

                    var value = $('#avatar').next().find('input[type=hidden]:eq(0)').val();
                    if (!value || value.length == 0) {
                        deferred.resolve();
                        return deferred.promise();
                    }


                    //dummy upload
                    setTimeout(function() {
                        $.ajax({
                            url: '<?= base_url('profile/changeAvatar') ?>',
                            type: 'POST',
                            data: new FormData($('.editableform')[0]),
                            contentType: false,
                            cache: false,
                            processData: false,
                            dataType: 'json',
                            success: function(data) {
                                response = jQuery.parseJSON(JSON.stringify(data));
                                if (response.is_success === true) {
                                    // form.find('button').removeAttr('disabled');
                                    // modal.modal("hide");
                                    // working = false;
                                    d = new Date();
                                    $(".avatar").attr("src", "assets/images/avatars/" + response.imgName + "?" + d.getTime());
                                    Toast.fire({
                                        icon: 'success',
                                        title: response.message
                                    })
                                    deferred.resolve({
                                        'status': 'OK'
                                    });
                                } else {
                                    // modal.modal("hide");
                                    // working = false;
                                    Toast.fire({
                                        icon: 'warning',
                                        title: response.message
                                    })
                                }
                                // modal.modal("hide");
                                // working = false;
                            },
                            error: function(xhr, status, error) {
                                // modal.modal("hide");
                                // working = false;
                                Toast.fire({
                                    icon: 'danger',
                                    title: "Connection Timeout <br> Status : " + xhr.statusText
                                })
                            },
                            timeout: 300000 // sets timeout to 5 minutes
                        });

                    }, parseInt(Math.random() * 800 + 800))

                    return deferred.promise();
                },

                success: function(response, newValue) {}
            })
        } catch (e) {}


        ///////////////////////////////////////////
        $('.input-mask-phone').mask('(999) 999-999-999');


        ////////////////////
        //change profile
        $('[data-toggle="buttons"] .btn').on('click', function(e) {
            var target = $(this).find('input[type=radio]');
            var which = parseInt(target.val());
            $('.user-profile').parent().addClass('hide');
            $('#user-profile-' + which).parent().removeClass('hide');
        });



        /////////////////////////////////////
        $('.select2').css('width', '100%').select2({
            allowClear: true
        });
    });
</script>
<!-- <script>
    $('#avatar').on('click', function() {
        var modal =
            '<div class="modal fade">\
					  <div class="modal-dialog">\
					   <div class="modal-content">\
						<div class="modal-header">\
							<button type="button" class="close" data-dismiss="modal">&times;</button>\
							<h4 class="blue">Change Avatar</h4>\
						</div>\
						\
						<form class="no-margin" id="avatarForm">\
						 <div class="modal-body">\
							<div class="space-4"></div>\
							<div style="width:75%;margin-left:12%;"><input type="file" id="avatarFile" name="avatar"/></div>\
						 </div>\
						\
						 <div class="modal-footer center">\
							<button type="submit" class="btn btn-sm btn-success"><i class="ace-icon fa fa-check"></i> Submit</button>\
							<button type="button" class="btn btn-sm" data-dismiss="modal"><i class="ace-icon fa fa-times"></i> Cancel</button>\
						 </div>\
						</form>\
					  </div>\
					 </div>\
					</div>';


        var modal = $(modal);
        modal.modal("show").on("hidden", function() {
            modal.remove();
        });

        var working = false;

        var form = modal.find('form:eq(0)');
        var file = form.find('input[type=file]').eq(0);
        file.ace_file_input({
            style: 'well',
            btn_choose: 'Click to choose new avatar',
            btn_change: null,
            no_icon: 'ace-icon fa fa-picture-o',
            thumbnail: 'small',
            before_remove: function() {
                //don't remove/reset files while being uploaded
                return !working;
            },
            allowExt: ['jpg', 'jpeg', 'png', 'gif'],
            allowMime: ['image/jpg', 'image/jpeg', 'image/png', 'image/gif'],
        });

        form.on('submit', function() {
            if (!file.data('ace_input_files')) return false;
            form.find('.modal-body').append("<div class='center'><i class='ace-icon fa fa-spinner fa-spin bigger-150 orange'></i></div>");
            working = true;
            form.find('button').attr('disabled', 'disabled');
            form.find('input[type=file]').ace_file_input('enable');
            console.log(file.data('ace_input_files'));
            $.ajax({
                url: '<?= base_url('profile/changeAvatar') ?>',
                type: 'POST',
                data: new FormData(this),
                contentType: false,
                cache: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    response = jQuery.parseJSON(JSON.stringify(data));
                    if (response.is_success === true) {
                        form.find('button').removeAttr('disabled');
                        modal.modal("hide");
                        working = false;
                        d = new Date();
                        $(".avatar").attr("src", "assets/images/avatars/" + response.imgName + "?" + d.getTime());
                        $.gritter.add({
                            title: 'Success!',
                            text: response.message,
                            class_name: 'gritter-success gritter-light'
                        });
                    } else {
                        modal.modal("hide");
                        working = false;
                        $.gritter.add({
                            title: 'Failed!',
                            text: response.message,
                            class_name: 'gritter-danger gritter-light'
                        });
                    }
                    modal.modal("hide");
                    working = false;
                },
                error: function(xhr, status, error) {
                    modal.modal("hide");
                    working = false;
                    $.gritter.add({
                        title: 'Ops!',
                        text: "Connection Timeout <br> Status : " + xhr.statusText,
                        class_name: 'gritter-success gritter-light'
                    });
                },
                timeout: 300000 // sets timeout to 5 minutes
            });
            return false;
        });

    });
</script> -->

<script>
    function setTypeInput(str) {
        $("#type").val(str);
    }

    $('#infoForm').on('submit', (function(e) {
        e.preventDefault();
        var type = $("#type").val();
        if (type == 'changeUsername') {
            var oldUsername = $("#oldUsername").val();
            var newUsername = $("#username").val();
            var checkUsername = function() {
                var username = null;
                $.ajax({
                    'type': "POST",
                    'global': true,
                    'async': false,
                    'dataType': 'JSON',
                    'data': {
                        username: newUsername
                    },
                    'url': "<?= base_url('profile/checkUsername') ?>",
                    'success': function(data) {
                        username = data;
                    }
                });
                return username;
            }();
            if ((checkUsername.isExist) && (oldUsername != newUsername)) {
                Toast.fire({
                    icon: 'warning',
                    title: "<?= $this->lang->line('profile_warning_username_exist') ?>"
                })
                return;
            }
            if ((checkUsername.isExist) && (oldUsername == newUsername)) {
                Toast.fire({
                    icon: 'warning',
                    title: "<?= $this->lang->line('profile_warning_username_didnt_change') ?>"
                })
                return;
            }
        }
        if (type == 'changeEmail') {
            var oldEmail = $("#oldEmail").val();
            var newEmail = $("#email").val();
            var checkEmail = function() {
                var email = null;
                $.ajax({
                    'type': "POST",
                    'global': true,
                    'async': false,
                    'dataType': 'JSON',
                    'data': {
                        email: newEmail
                    },
                    'url': "<?= base_url('profile/checkEmail') ?>",
                    'success': function(data) {
                        email = data;
                    }
                });
                return email;
            }();
            if ((checkEmail.isExist) && (oldEmail != newEmail)) {
                Toast.fire({
                    icon: 'warning',
                    title: "<?= $this->lang->line('profile_warning_email_exist') ?>"
                })
                return;
            }
            if ((checkEmail.isExist) && (oldEmail == newEmail)) {
                Toast.fire({
                    icon: 'warning',
                    title: "<?= $this->lang->line('profile_warning_email_didnt_change') ?>"
                })
                return;
            }
        }
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('profile/update') ?>',
                    type: 'POST',
                    data: new FormData(this),
                    contentType: false,
                    cache: false,
                    processData: false,
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
                            // $('#infoForm').trigger("reset");
                            clearPassword();
                            $('a[href="#home"]').trigger('click');
                        } else {
                            // Toast.fire({
                            //     icon: 'warning',
                            //     title: response.message
                            // })
                            $.gritter.add({
                                title: '<?= $this->lang->line('text_failed') ?>',
                                text: response.message,
                                class_name: 'gritter-warning gritter-light'
                            });
                        }

                    },
                    error: function(xhr, status, error) {
                        Toast.fire({
                            icon: 'danger',
                            title: "Connection Timeout <br> Status : " + xhr.statusText
                        })
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        })
        return;

    }));
</script>