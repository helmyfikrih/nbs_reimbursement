<!DOCTYPE html>
<?php
include "layout/_header.html";
include "layout/_topbar.html";
include "layout/_navbar.html";
?>
<?= $body ?>
<script>
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        onOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    $(document).ajaxStart(function() {
        $(document).ajaxStart($.blockUI({
            global: false,
            message: 'Loading...',
            css: {
                border: 'none',
                padding: '5px',
                backgroundColor: '#000',
                '-webkit-border-radius': '10px',
                '-moz-border-radius': '10px',
                opacity: .6,
                color: '#fff'
            }

        })).ajaxStop($.unblockUI);
    });
</script>
<script type="text/javascript">
    var modal = document.getElementById("photoModal");

    var modalImg = document.getElementById("img");

    var is_new = false;
    var is_new_temp = false;

    function closeImg() {
        modal.style.display = "none";
    }

    $(document).ready(function() {
        getNotif();
        $(document).on("click", "p", function() {
            // $(".selectedImage").attr('href', imagePath)
            var img = $(this).find("img").first()[0]; // select images inside .container
            var imagePath = $(img).find("img").prevObject.attr("src");
            if (imagePath) {
                modal.style.display = "block";
                modalImg.src = imagePath;
            }
        });
        $(document).on("click", ".img_clickable", function() {
            var imagePath = $(this).find("img").prevObject.attr("src");
            // $(".selectedImage").attr('href', imagePath)
            // var img = $(this).find("img").first()[0]; // select images inside .container
            // var imagePath = $(img).find("img").prevObject.attr("src");
            modal.style.display = "block";
            modalImg.src = imagePath;
        });

        $('p').find('img').css({
            "width": "50%",
            "height": "50%"
        });
    });

    function getNotif() {
        $("#totalNotif").html("");
        $("#appendNotif").html("");
        $.ajax({
            url: '<?= base_url('kms/getNotif') ?>',
            type: 'POST',
            dataType: 'json',
            global: false,
            success: function(data) {
                response = jQuery.parseJSON(JSON.stringify(data));
                var totalNotif = 0;
                if (response.dataNotif) {
                    $("#appendNotif").html(`<li class="dropdown-header">
							<i class="ace-icon fa fa-exclamation-triangle"></i>
							<span id="total"></span> <?= $this->lang->line('text_notif') ?>
						</li>`);

                    $.each(response.dataNotif, function(key, value) {
                        totalNotif++;
                        var text = "";
                        var icon = "";
                        var link = "";
                        var totalPerKey = 0;
                        if (key == 'register') {
                            totalPerKey = response.dataNotif.register.length;
                            text = "<?= $this->lang->line('text_new_user_register') ?>";
                            icon = "fa-users";
                            link = "<?= base_url('register_user') ?>";

                            $("#appendNotif").append(`
                            <li class="dropdown-content">
								<ul class="dropdown-menu dropdown-navbar navbar-info">
									<li>
										<a href="${link}">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-info fa ${icon}"></i>
													${text}
												</span>
												<span class="pull-right badge badge-info">+${totalPerKey}</span>
											</div>
										</a>
									</li>

									
								</ul>
                            </li>`);
                            is_new = true;
                        }
                        if (key == 'document') {
                            totalPerKey = response.dataNotif.document.length;
                            icon = "fa-book";
                            $.each(response.dataNotif.document, function(key, value) {
                                $("#appendNotif").append(`
                            <li class="dropdown-content">
								<ul class="dropdown-menu dropdown-navbar navbar-info">
									<li>
										<a href="${value.url}">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-info fa ${icon}"></i>
													${value.username} <?= $this->lang->line('text_has_requested_doc') ?> (${value.doc_code})
												</span>
											</div>
										</a>
									</li>

									
								</ul>
							</li>`);
                            })
                            is_new = true;
                        }
                        if (key == 'documentApprove') {
                            totalPerKey = response.dataNotif.documentApprove.length;
                            icon = "fa-info";
                            $.each(response.dataNotif.documentApprove, function(key, value) {
                                $("#appendNotif").append(`
                            <li class="dropdown-content">
								<ul class="dropdown-menu dropdown-navbar navbar-info">
									<li>
										<a href="${value.url}">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-info fa ${icon}"></i>
													${value.doc_code} <?= $this->lang->line('text_need_approve') ?>
												</span>
											</div>
										</a>
									</li>

									
								</ul>
							</li>`);
                            })
                            is_new = true;
                        }
                        if (key == 'notulensiApprove') {
                            totalPerKey = response.dataNotif.notulensiApprove.length;
                            icon = "fa-info";
                            $.each(response.dataNotif.notulensiApprove, function(key, value) {
                                $("#appendNotif").append(`
                            <li class="dropdown-content">
								<ul class="dropdown-menu dropdown-navbar navbar-info">
									<li>
										<a href="${value.url}">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-info fa ${icon}"></i>
													${value.note_code} <?= $this->lang->line('text_need_approve') ?>
												</span>
											</div>
										</a>
									</li>

									
								</ul>
							</li>`);
                            })
                            is_new = true;
                        }
                        if (key == 'uploaded') {
                            totalPerKey = response.dataNotif.uploaded.length;
                            icon = "fa-info";
                            $.each(response.dataNotif.uploaded, function(key, value) {
                                if (value.notif_status == '0' || value.notif_status == 0) {
                                    is_new_temp = true;
                                }
                                $("#appendNotif").append(`
                            <li class="dropdown-content">
								<ul class="dropdown-menu dropdown-navbar navbar-info">
									<li>
										<a href="${value.url}">
											<div class="clearfix">
												<span class="pull-left">
													<i class="btn btn-xs no-hover btn-info fa ${icon}"></i>
													${value.notif_msg}
												</span>
											</div>
										</a>
									</li>

									
								</ul>
							</li>`);
                            })
                        }
                    });
                    if (is_new || is_new_temp) {
                        $("#totalNotif").html("<?= $this->lang->line('text_new') ?>");
                    }
                    $("#total").html('');
                }




            },
            error: function(xhr, status, error) {
                //console.log(xhr);
                // Toast.fire({
                //     icon: 'error',
                //     title: xhr.statusText,
                //     text: "Something Wrong"
                // })
            },
            timeout: 300000 // sets timeout to 5 minutes
        });

    }

    function setNotifReaded() {
        $.ajax({
            url: '<?= base_url('kms/setNotifReaded') ?>',
            type: 'POST',
            dataType: 'json',
            global: false,
            success: function(data) {
                is_new_temp = false;
                if (!is_new && !is_new_temp) {
                    $("#totalNotif").empty();
                }
            },
            error: function(xhr, status, error) {},
            timeout: 300000 // sets timeout to 5 minutes
        });
    }
</script>
<?php include "layout/_footer.html"; ?>