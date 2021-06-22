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
                <li class="active"><?= P($dataForum['forum_title']) ?></li>
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
                    <div class="clearfix">
                        <!-- <div class="pull-left alert alert-success no-margin alert-dismissable">
                            <?= P($dataForum['forum_title']) ?>
                        </div> -->
                        <h4>
                            <?= P($dataForum['forum_title']) ?>
                        </h4>

                        <div class="pull-right">
                            <?php if ($dataForum['forum_is_closed']) { ?>
                                <div class="center alert alert-danger no-margin alert-dismissable col-sm-12 col-xs-12">
                                    <i class="ace-icon fa fa-close red"></i> <?= $this->lang->line('forum_closed') ?>
                                </div>
                            <?php } ?>
                        </div>
                    </div>

                    <div class="hr dotted"></div>

                    <div>
                        <div id="user-profile-1" class="user-profile row">
                            <div class="col-xs-12 col-sm-3 center">
                                <div>
                                    <span class="profile-picture">
                                        <img id="avatar" class="editable img-responsive img_clickable" alt="Alex's Avatar" src="<?= base_url() ?>assets/images/avatars/<?= $dataForum['user_img'] ?>" />
                                    </span>

                                    <div class="space-4"></div>

                                    <div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
                                        <div class="inline position-relative">
                                            <a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
                                                <!-- <i class="ace-icon fa fa-circle light-green"></i> -->
                                                &nbsp;
                                                <span class="white"><?= $dataForum['username'] ?></span>
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="space-6"></div>

                                <div class="profile-contact-info">
                                    <div class="profile-contact-links align-left">
                                        <a href="javascript:;" class="btn btn-link">
                                            <i class="ace-icon fa fa-clock-o bigger-120 green"></i>
                                            <?= date("H:i:s d/M/Y", strtotime($dataForum['forum_created'])) ?>
                                        </a>

                                        <a href="javascript:;" class="btn btn-link">
                                            <i class="ace-icon fa fa-cog bigger-120 pink"></i>
                                            <?= $dataForum['role_name'] ?>
                                        </a>

                                        <a href="javascript:;" class="btn btn-link">
                                            <i class="ace-icon fa fa-tags bigger-125 blue"></i>
                                            <?= $dataForum['forum_category'] ?>
                                        </a>
                                        <a href="javascript:;" class="btn btn-link">
                                            <i class="ace-icon fa fa-home bigger-125 blue"></i>
                                            <?= wordwrap($dataForum['school_name'], 22, "<br>\n") ?>
                                        </a>
                                    </div>

                                    <div class="space-6"></div>

                                    <div class="profile-social-links align-center">
                                        <!-- <a href="#" class="tooltip-info" title="" data-original-title="Visit my Facebook">
                                            <i class="middle ace-icon fa fa-facebook-square fa-2x blue"></i>
                                        </a>

                                        <a href="#" class="tooltip-info" title="" data-original-title="Visit my Twitter">
                                            <i class="middle ace-icon fa fa-twitter-square fa-2x light-blue"></i>
                                        </a>

                                        <a href="#" class="tooltip-error" title="" data-original-title="Visit my Pinterest">
                                            <i class="middle ace-icon fa fa-pinterest-square fa-2x red"></i>
                                        </a> -->
                                    </div>
                                </div>

                            </div>

                            <div class="col-xs-12 col-sm-9">


                                <div class="space-12"></div>
                                <div class="well well-lg">
                                    <h4 class="blue"></h4>
                                    <?= $dataForum['forum_content'] ?>
                                </div>

                                <div class="space-20"></div>



                                <!-- <div class="hr hr2 hr-double"></div> -->

                                <div class="space-6"></div>

                            </div>
                        </div>
                        <div class="widget-box transparent">
                            <div class="widget-header widget-header-small">
                                <h4 class="widget-title blue smaller pull-left">
                                    <i class="ace-icon fa fa-rss orange"></i>
                                    <?= $this->lang->line('forum_recent_activity') ?>
                                </h4>

                                <div class="widget-toolbar action-buttons">
                                    <!-- <a href="#" data-action="reload">
                                        <i class="ace-icon fa fa-refresh blue"></i>
                                    </a> -->
                                    <!-- &nbsp; -->
                                    <!-- <a href="#" class="pink">
                                        <i class="ace-icon fa fa-trash-o"></i>
                                    </a> -->
                                    <!-- &nbsp; -->
                                    <?php if ((in_array($dataForum['menu_allow'] . '_comment', $dataForum['user_allow_menu'])) && (!$dataForum['forum_is_closed'])) { ?>

                                        <a href="javascript:;" onclick="showFormReply();" class="pink">
                                            <i class="ace-icon fa fa-plus blue"></i>
                                        </a>
                                    <?php } ?>
                                </div>
                            </div>
                            <div>
                                &nbsp;
                                <div class="input-group" id="form_reply" style="display: none;">
                                    <?php echo form_open_multipart('forum/saveReply', 'class="form-horizontal" id="formReply" role="form"'); ?>
                                    <input type="text" name="forum_id" id="forum_id" value="<?= $dataForum['forum_id'] ?>" readonly hidden>
                                    <input type="text" name="forum_slug" id="forum_slug" value="<?= P($dataForum['forum_slug']) ?>" readonly hidden>
                                    <a class="input-group-addon" onclick="showFormReply();">
                                        <i class="ace-icon fa fa-times"> Close</i>
                                    </a>
                                    <textarea id="content_reply" class="autosize-transition form-control" style="overflow: hidden; overflow-wrap: break-word; resize: horizontal; height: 92px;" name="content_reply"></textarea>
                                    <span class="input-group-addon">
                                        <button class="btn btn-info" type="submit">
                                            <i class="ace-icon fa fa-check bigger-110"></i>
                                            Submit
                                        </button>
                                        <!-- <i class="ace-icon fa fa-reply"> Submit</i> -->
                                    </span>
                                    <?php echo form_close(); ?>
                                </div>
                            </div>

                            <div class="widget-body">
                                <div class="widget-main padding-8">
                                    <div id="comment-tab" class="tab-pane">
                                        <div class="comments" id="commentList">

                                        </div>
                                        <!-- Paginate -->
                                        <div id='pagination'></div>
                                        <div class="hr hr8"></div>
                                        <?php if ($dataForum['forum_is_closed']) { ?>
                                            <div class="itemdiv commentdiv">
                                                <div class="center alert alert-danger no-margin alert-dismissable col-sm-12 col-xs-12">
                                                    <i class="ace-icon fa fa-close red"></i> <?= $this->lang->line('forum_closed') ?>
                                                </div>
                                            </div>
                                            <div class="hr hr-double hr8"></div>
                                        <?php } ?>
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

<!-- page specific plugin scripts -->

<!--[if lte IE 8]>
		  <script src="<?= base_url() ?>assets/js/excanvas.min.js"></script>
		<![endif]-->
<script src="<?= base_url() ?>assets/plugins/ckfinder/ckfinder.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/plugins/ckeditor/ckeditor.js" type="text/javascript"></script>
<script src="<?= base_url() ?>assets/js/jquery.gritter.min.js"></script>
<script src="<?= base_url() ?>assets/js/time_ago.js"></script>
<script src="<?= base_url() ?>assets/js/moment.min.js"></script>

<!-- inline scripts related to this page -->
<script type="text/javascript">
    $(document).ready(function() {
        var editor = CKEDITOR.replace('content_reply');
        CKFinder.setupCKEditor(editor);
    })
</script>


<script type="text/javascript">
    function showFormReply() {
        var x = document.getElementById("form_reply");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    // Load pagination
    function loadPagination(pagno) {
        $.ajax({
            url: '<?= base_url() ?>forum/loadComment/' + pagno,
            type: 'post',
            dataType: 'json',
            data: {
                forumId: <?= $this->uri->segment(3) ?>
            },
            success: function(response) {
                $('#pagination').html(response.pagination);
                createCommentList(response.result, response.row);
            }
        });
    }

    // Create table list
    function createCommentList(result, sno) {
        sno = Number(sno);
        $('#commentList').empty();
        if (result.length > 0) {
            for (index in result) {
                var id = result[index].fc_id;
                var content = result[index].fc_content;
                var fcUserId = result[index].user_id;
                var username = result[index].user_username;
                var school = result[index].school_name;
                var roleName = result[index].role_name;
                // var createdDate = timeSince(result[index].fc_created_date);
                var createdDate = moment(result[index].fc_created_date).fromNow()
                var imgName = result[index].ud_img_name ? result[index].ud_img_name : 'avatar2.png';
                var btnComment = '';
                // <a href="#">
                //                         <i class="ace-icon fa fa-pencil blue"></i>
                //                     </a>
                if (fcUserId == '<?= $this->session->userdata('logged_in')['user_id'] ?>') {
                    btnComment = `  
                                    <a href="javascript:;" onclick="deleteComment(${id})">
                                        <i class="ace-icon fa fa-trash-o red"></i>
                                    </a>`;
                }
                // var link = result[index].link;
                sno += 1;

                var commentList = `<div class="itemdiv commentdiv">
                                                <div class="user">
                                                    <img alt="Rita's Avatar" src="<?= base_url() ?>assets/images/avatars/${imgName}" />
                                                </div>

                                                <div class="body">
                                                    <div class="name">
                                                        <a href="#"> ${username}</a>
                                                    </div>

                                                    <div class="time">
                                                        <i class="ace-icon fa fa-cog"></i>
                                                        <span class="blue">${roleName}</span> 
                                                        <i class="ace-icon fa fa-home"></i>
                                                        <span class="blue">${school}</span> 
                                                        <i class="ace-icon fa fa-clock-o"></i>
                                                        <span class="blue">${createdDate}</span> 
                                                    </div>

                                                    <div class="text">
                                                        <i class="ace-icon fa fa-quote-left"></i>
                                                        ${content}
                                                    </div>
                                                </div>

                                                <div class="tools">
                                                    <div class="action-buttons bigger-125">
                                                    ${btnComment}
                                                    </div>
                                                </div>
                                            </div>`;
                $('#commentList').append(commentList);

            }
        } else {
            $('#commentList').append(`<div class="itemdiv commentdiv"> <div class="center alert alert-danger no-margin alert-dismissable col-sm-12 col-xs-12">
                            <?= $this->lang->line('forum_dont_have_comment') ?>                       </div> </div>`);
        }

    }

    function deleteComment(id) {
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('forum_warning_delete_reply') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('forum/deleteComment') ?>',
                    type: 'POST',
                    data: {
                        commentId: id
                    },
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message,
                            })
                            loadPagination(0);
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
                            title: response.message,
                        })
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        })
    }

    jQuery(function($) {
        /**
        //let's display edit mode by default?
        var blank_image = true;//somehow you determine if image is initially blank or not, or you just want to display file input at first
        if(blank_image) {
        	$('#avatar').editable('show').on('hidden', function(e, reason) {
        		if(reason == 'onblur') {
        			$('#avatar').editable('show');
        			return;
        		}
        		$('#avatar').off('hidden');
        	})
        }
        */



        //////////////////////////////
        $('#profile-feed-1').ace_scroll({
            height: '720px',
            mouseWheelLock: true,
            alwaysVisible: true
        });

        ///////////////////////////////////////////

        //right & left position



        ////////////////////

        /////////////////////////////////////
        $(document).one('ajaxloadstart.page', function(e) {
            //in ajax mode, remove remaining elements before leaving page
            try {
                $('.editable').editable('destroy');
            } catch (e) {}
            $('[class*=select2]').remove();
        });
    });
</script>

<script type='text/javascript'>
    $(document).ready(function() {
        // Detect pagination click
        $('#pagination').on('click', 'a', function(e) {
            e.preventDefault();
            var pageno = $(this).attr('data-ci-pagination-page');
            loadPagination(pageno);
        });

        loadPagination(0);


        $('#formReply').on('submit', (function(e) {

            e.preventDefault();
            var myForm = $("#formReply")[0];
            let isiKomentar = CKEDITOR.instances['content_reply'].getData();
            if (isiKomentar == '') {
                // toastr["warning"]("Harap isi komentar", "Komentar Tidak Boleh Kosong");
                Toast.fire({
                    icon: 'error',
                    title: "<?= $this->lang->line('forum_warning_empty_reply') ?>"
                })
                return;
            }
            $.ajax({
                url: $(myForm).attr('action'),
                type: 'POST',
                data: {
                    replyContent: isiKomentar,
                    forum_id: $('#forum_id').val(),
                    forum_slug: $('#forum_slug').val(),
                },
                dataType: 'json',
                success: function(data) {
                    response = jQuery.parseJSON(JSON.stringify(data));
                    if (response.is_success === true) {
                        // $('#dialog-confirm').dialog("close");
                        Toast.fire({
                            icon: 'success',
                            title: response.message,
                        })
                        showFormReply();
                        loadPagination(0);
                        CKEDITOR.instances['content_reply'].setData('');

                    } else {
                        // $('#dialog-confirm').dialog("close");
                        Toast.fire({
                            icon: 'error',
                            title: response.message,
                        })

                    }

                },
                error: function(xhr, status, error) {
                    //console.log(xhr);
                    // $('#dialog-confirm').dialog("close");
                    $.gritter.add({
                        title: '<?= $this->lang->line('text_error') ?>',
                        text: xhr.statusText,
                        class_name: 'gritter-error gritter-light'
                    });
                },
                timeout: 300000 // sets timeout to 5 minutes
            });

        }));
    });
</script>