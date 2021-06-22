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
                <li class="active"><?= $this->lang->line('forum_title') ?></li>
            </ul><!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
                <form class="form-search" id="search">
                    <span class="input-icon">
                        <input type="text" id="searchText" placeholder="Search ..." class="nav-search-input" id="nav-search-input" autocomplete="off" />
                        <i class="ace-icon fa fa-search nav-search-icon" type="submit"></i>
                    </span>
                </form>
            </div><!-- /.nav-search -->
        </div>

        <div class="page-content">

            <div class="page-header">
                <div class="clearfix">
                    <div class="pull-left">
                        <h1><?= $this->lang->line('forum_head') ?> </h1>
                    </div>
                    <div class="pull-right">
                        <?php if ((in_array($menu_allow . '_add', $user_allow_menu))) { ?>
                            <a href="<?= base_url('forum/create') ?>" class="btn btn-white btn-info btn-bold">
                                <i class="ace-icon fa fa-floppy-o bigger-120 blue"></i>
                                <?= $this->lang->line('forum_create') ?>
                            </a>
                        <?php } ?>
                        <!-- <span class="green middle bolder">Choose result page type: &nbsp;</span> -->

                    </div>
                </div>
            </div><!-- /.page-header -->
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div class="col-md-9 col-sm-12">
                        <div class="row">
                            <div id='forumList'></div>
                        </div>
                        <div class="row">
                            <div id='pagination'></div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-3">
                        <div class="well">
                            <h4 class="green smaller lighter">Category</h4>
                            <div id='tagList'></div>
                        </div>
                    </div>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.page-content -->
    </div>
</div><!-- /.main-content -->
<!-- page specific plugin scripts -->
<script>
    var curTag = "";
</script>

<script>
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
</script>

<script type='text/javascript'>
    $(document).ready(function() {
        $('#search').on('submit', (function(e) {

            e.preventDefault();
            loadPagination(0);
        }));
        // Detect pagination click
        $('#pagination').on('click', 'a', function(e) {
            e.preventDefault();
            var pageno = $(this).attr('data-ci-pagination-page');
            loadPagination(pageno);
        });

        loadPagination(0);
        loadCategory();
    });
</script>


<script>
    // Load pagination
    function loadPagination(pagno) {
        $.ajax({
            url: '<?= base_url() ?>forum/loadRecord/' + pagno,
            type: 'POST',
            dataType: 'json',
            data: {
                saerchText: $("#searchText").val(),
            },
            success: function(response) {
                $('#pagination').html(response.pagination);
                createForumList(response.result, response.row);
            }
        });
    }
    // Load pagination by tag
    function loadPaginationByTag(pagno, tag) {
        if (curTag != tag) {
            curTag = tag;
        } else {
            curTag = "";
        }
        $.ajax({
            url: '<?= base_url() ?>forum/loadRecord/' + pagno,
            type: 'POST',
            dataType: 'json',
            data: {
                saerchText: $("#searchText").val(),
                tag: curTag,
            },
            success: function(response) {
                $('#pagination').html(response.pagination);
                createForumList(response.result, response.row);
                loadCategory();
            }
        });
    }
    // load category
    function loadCategory() {
        $.ajax({
            url: '<?= base_url() ?>kms/tagsWithCount/',
            type: 'POST',
            dataType: 'json',
            data: {},
            success: function(response) {
                createCategoryList(response);
            }
        });
    }

    // create category list
    function createCategoryList(result) {
        $('#tagList').empty();
        for (index in result) {
            var count = index;
            var list = `<a href="javascript:;" onclick="loadPaginationByTag(0,'${index}')">
                                <large>
                                    ${index}
                                </large>
                                <small>
                                    (${result[index]})
                                </small>
                                <br>
                            </a>`;
            $('#tagList').append(list);

        }
    }

    // Create table list
    function createForumList(result, sno) {
        sno = Number(sno);
        $('#forumList').empty();
        for (index in result) {
            var id = result[index].forum_id;
            var userId = result[index].user_id;
            var title = htmlEntities(result[index].forum_title);
            var slug = result[index].forum_slug;
            var content = result[index].forum_content;
            var imgName = result[index].ud_img_name;
            var userName = result[index].user_username;
            var createdDate = result[index].forum_created_date;
            var isClosed = result[index].forum_is_closed;
            var category = htmlEntities(result[index].forum_category);
            var school = htmlEntities(result[index].school_name);
            var imgSrc = '';
            var btn = '';
            var btnEdit = '';
            var btnDelete = '';
            var btnClose = '';
            var btnOpen = '';
            var elem = document.createElement('div');
            elem.style.display = 'none';
            document.body.appendChild(elem);
            elem.innerHTML = content;
            try {
                imgSrc = elem.querySelector('img').src;
            } catch (e) {
                imgSrc = '<?= base_url('assets/images/default_photo.png') ?>';
            }
            <?php if ((in_array($menu_allow . '_edit', $user_allow_menu))) {
                if (($this->session->userdata('logged_in')['role_id'] == 1)) {
            ?>
                    btnEdit = `<a href="<?= base_url('forum/edit/') ?>${id}/${slug}" class="tooltip-error" data-rel="tooltip" title="<?= $this->lang->line('forum_edit') ?>">
                                        <i class="ace-icon fa fa-edit green"></i>
                                    </a>`;
                <?php } else { ?>
                    if (userId == <?= $this->session->userdata('logged_in')['user_id'] ?>) {
                        btnEdit = `<a href="<?= base_url('forum/edit/') ?>${id}/${slug}" class="tooltip-error" data-rel="tooltip" title="<?= $this->lang->line('forum_edit') ?>">
                                            <i class="ace-icon fa fa-edit green"></i>
                                        </a>`;
                    }
            <?php }
            }     ?>
            // btnDelete = `<a href="#">
            //                 <i class="ace-icon fa fa-trash red"></i>
            //             </a>`;
            <?php if ((in_array($menu_allow . '_close', $user_allow_menu))) { ?>
                if (!isClosed) {
                    btnClose = `<a href="javascript:;" onclick="closeForum(${id})" class="tooltip-error" data-rel="tooltip" title="<?= $this->lang->line('forum_close') ?>">
                                    <i class="ace-icon fa fa-close red"></i>
                                </a>`;
                }
            <?php } ?>
            <?php if ((in_array($menu_allow . '_open', $user_allow_menu))) { ?>
                if (isClosed) {
                    btnOpen = `<a href="javascript:;" onclick="openForum(${id})" class="tooltip-error" data-rel="tooltip" title="<?= $this->lang->line('forum_open') ?>">
                                <i class="ace-icon fa fa-folder-open-o blue"></i>
                            </a>`;
                }
            <?php } ?>
            btn = btnEdit + btnDelete + btnClose + btnOpen;
            if (!imgName) {
                imgName = 'avatar2.png';
            }
            content = content.substr(0, 30);
            // var link = result[index].link;
            sno += 1;

            var list = `<div class="col-xs-6 col-sm-6 col-md-4">
                            <div class="thumbnail search-thumbnail">
                                <a href="<?= base_url('forum/view/') ?>${id}/${slug}" class="tooltip-error" data-rel="tooltip" title="<?= $this->lang->line('forum_view') ?>">
                                <div class="caption">
                                    <div class="clearfix">
                                        <span class="pull-left">
                                            <large>
                                                <i class="ace-icon fa fa-user"></i>
                                                ${userName}
                                            </large>
                                            <small>
                                                <i class="ace-icon fa fa-tags"></i>
                                                ${category}
                                            </small>
                                        </span>
                                    </div>
                                </div>
                                <img class="media-object" data-src="holder.js/100px200?theme=gray" alt="100%x200" src="${imgSrc}" data-holder-rendered="true" style="height: 150px; width: 100%; display: block;">
                                <div class="caption">
                                <small>
                                <i class="ace-icon fa fa-calendar"></i> ${createdDate}
                                </small>
                                    <h3 class="search-title">
                                          ${title}
                                    </h3> 
                                </div>
                                </a>
                                <div class="caption center">
                                    ${btn}
                                </div>
                            </div>
                        </div>`;
            $('#forumList').append(list);

        }
    }


    function closeForum(id) {
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('forum_warning_close') ?>",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?= base_url('forum/closeForum/') ?>" + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
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
                        $.gritter.add({
                            title: <?= $this->lang->line('text_error') ?>,
                            text: xhr.statusText,
                            class_name: 'gritter-error gritter-light'
                        });
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        })
    }

    function openForum(id) {
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: "<?= $this->lang->line('forum_warning_open') ?>",
            icon: '<?= $this->lang->line('text_warning') ?>',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: "<?= base_url('forum/openForum/') ?>" + id,
                    type: 'POST',
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            });
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
                        $.gritter.add({
                            title: <?= $this->lang->line('text_error') ?>,
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