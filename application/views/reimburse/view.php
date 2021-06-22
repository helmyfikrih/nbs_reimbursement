<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<?php
$multimediaArr = array('mp4', 'mkv', 'mov', 'avi', 'mpeg4', 'mp3');
$status = "";
if ($reimburseDetail[0]['reimburse_status'] == 1) {
	$label = 'success';
	$text = "Approved";
}
if ($reimburseDetail[0]['reimburse_status'] == 2) {
	$label = 'warning';
	$text = "Waiting Approval";
}
if ($reimburseDetail[0]['reimburse_status'] == 3) {
	$label = 'info';
	$text = $this->lang->line('reimburse_status_request');
}
if ($reimburseDetail[0]['reimburse_status'] == 0) {
	$label = 'danger';
	$text = "Deleted";
}
if ($reimburseDetail[0]['reimburse_status'] == 4) {
	$label = 'danger';
	$text = "Rejected";
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
					<a href="#"><?= $this->lang->line('document_title') ?></a>
				</li>
				<li class="active">Lihat Surat</li>
			</ul><!-- /.breadcrumb -->
		</div>

		<div class="page-content">

			<div class="page-header">
				<h1>Lihat Surat</h1>
			</div><!-- /.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<div class="col-xs-12 col-sm-3 center">
						<div>
							<span class="profile-picture">
								<img class="editable img-responsive editable-empty" alt="Alex's Avatar" src="<?= base_url() ?>assets/images/avatars/<?= isset($reimburseDetail[0]['ud_img_name']) ? $reimburseDetail[0]['ud_img_name'] : 'avatar2.png' ?>">
							</span>

							<div class="space-4"></div>

							<div class="width-80 label label-info label-xlg arrowed-in arrowed-in-right">
								<div class="inline position-relative">
									<a href="#" class="user-title-label dropdown-toggle" data-toggle="dropdown">
										&nbsp;
										<span class="white"><?= $reimburseDetail[0]['user_username'] ?></span>
									</a>
								</div>
							</div>
						</div>

						<div class="profile-contact-info">
							<div class="space-6"></div>
						</div>


						<div class="clearfix">
						</div>

					</div>
					<div class="col-xs-12 col-sm-9">

						<div class="profile-user-info profile-user-info-striped">
							<div class="profile-info-row">
								<div class="profile-info-name" style="width: 150px;"> Value Claim</div>

								<div class="profile-info-value">
									<span class="editable"><?= $reimburseDetail[0]['reimburse_value'] ?></span>
								</div>
							</div>
							<div class="profile-info-row">
								<div class="profile-info-name" style="width: 150px;"> Jenis Claim </div>

								<div class="profile-info-value">
									<span class="editable"><?= P(($reimburseDetail[0]['reimburse_type_name'])) ?></span>
								</div>
							</div>
							<div class="profile-info-row">
								<div class="profile-info-name" style="width: 150px;"> Start Date </div>

								<div class="profile-info-value">
									<span class="editable"><?= P(date('d/m/Y', strtotime($reimburseDetail[0]['reimburse_start_date']))) ?></span>
								</div>
							</div>
							<div class="profile-info-row">
								<div class="profile-info-name" style="width: 150px;"> End Date </div>

								<div class="profile-info-value">
									<span class="editable"><?= P(date('d/m/Y', strtotime($reimburseDetail[0]['reimburse_end_date']))) ?></span>
								</div>
							</div>

							<div class="profile-info-row">
								<div class="profile-info-name"> Ketrangan Surat </div>

								<div class="profile-info-value">
									<span class="editable "><?= $reimburseDetail[0]['reimburse_note'] ?></span>
								</div>
							</div>


							<div class="profile-info-row">
								<div class="profile-info-name"> Status </div>

								<div class="profile-info-value">
									<span class="label label-sm label-<?= $label ?>"><?= $text ?></span>
								</div>
							</div>
							<!-- <div class="profile-info-row">
								<div class="profile-info-name"> <?= $this->lang->line('text_school') ?> </div>

								<div class="profile-info-value">
									<span class="label label-info label-sm"><?= $reimburseDetail[0]['school_name'] ?></span>
								</div>
							</div> -->

							<div class="profile-info-row">
								<div class="profile-info-name"> Tanggal Request </div>

								<div class="profile-info-value">
									<span class="editable"><?= date('H:i:s d/m/Y', strtotime($reimburseDetail[0]['reimburse_created_at'])) ?></span>
								</div>
							</div>
						</div>
					</div>
					<div class="col-xs-12">
						<div class="col-xs-12">
							<!-- PAGE CONTENT BEGINS -->
							<div class="widget-box transparent">
								<div class="widget-header widget-header-small">
									<h4 class="widget-title blue smaller pull-left">
										<i class="ace-icon fa fa-file blue"></i>
										Lampiran Surat
									</h4>

									<div class="widget-toolbar action-buttons">
									</div>
								</div>
								<div>
									&nbsp;

								</div>
								<?php if ($reimburseAttachment) { ?>
									<ul class="ace-thumbnails clearfix">
										<?php foreach ($reimburseAttachment as $attch) {
											$ext = pathinfo($attch['reimburse_attachment_name'], PATHINFO_EXTENSION);
											$filename = $attch['reimburse_attachment_name'];
										?>
											<li>
												<?php if (in_array($ext, $multimediaArr)) { ?>
													<video width="150" height="150" controls>
														<source src="<?= base_url() ?>assets/uploads/reimburse/<?= $filename ?>" type="video/mp4">
														Your browser does not support the video tag.
													</video>
													<!-- <embed width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/reimburse/<?= $filename ?>" /> -->
												<?php } else if ($ext == "pdf") { ?>
													<embed width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/reimburse/<?= $filename ?>" />
												<?php } else { ?>
													<a href="<?= base_url() ?>assets/uploads/reimburse/<?= $filename ?>" data-rel="colorbox" class="cboxElement">
														<img width="150" height="150" alt="150x150" src="<?= base_url() ?>assets/uploads/reimburse/<?= $filename ?>">
													</a>
												<?php } ?>
												<div class="tags">
													<span class="label-holder">
														<span class="label label-info"> <i class="ace-icon fa fa-upload"></i> <?= $this->lang->line('text_by') ?> <?= P($attch['user_username']) ?></span>
													</span>
												</div>
												<div class="tools">
													<a href='<?= base_url("kms/downloadUploadFile/reimburse/$filename") ?>'>
														<i class="ace-icon fa fa-download"> </i>
													</a>
												</div>
											</li>
										<?php } ?>
									</ul>
								<?php } ?>
							</div><!-- PAGE CONTENT ENDS -->
						</div>
					</div>
					<div class="col-xs-12">
						<hr>
						<div>
							<?php
							$search_level = $menu_allow . '_validasi';
							if (($reimburseDetail[0]['reimburse_status'] == 2) && (in_array($search_level, $user_allow_menu)) ||  (($reimburseDetail[0]['reimburse_status'] == 2) && ($this->session->userdata('logged_in')['role_id'] == 1))) { ?>
								<div class="clearfix form-actions">
									<div class="col-md-offset-3 col-md-9">
										<button class="btn btn-info" href="javascript:;" onclick="approval(1)">
											<i class="ace-icon fa fa-check bigger-110"></i>
											Approve
										</button>
										&nbsp; &nbsp; &nbsp;
										<button class="btn btn-danger" href="javascript:;" onclick="approval(4)">
											<i class="ace-icon fa fa-close bigger-110"></i>
											Reject
										</button>
										&nbsp; &nbsp; &nbsp;
										<button class="btn btn-success" onclick="window.history.go(-1); return false;">
											<i class="ace-icon fa fa-arrow-left bigger-110"></i>
											<?= $this->lang->line('document_btn_cancel') ?>
										</button>
									</div>
								</div>
							<?php } ?>
							<div class="hr hr-24"></div>


							<div class="space-24"></div>
						</div><!-- /.col -->
					</div>

				</div><!-- /.row -->
			</div><!-- /.page-content -->
		</div>
	</div><!-- /.main-content -->

	<!-- page specific plugin scripts -->
	<!-- page specific plugin scripts -->
	<script src="<?= base_url() ?>assets/js/jquery.colorbox.min.js"></script>
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

		function approval(status) {
			if (status == 1) {
				var text = ' Valid '
				var confirmButtonText = 'Validasi!'
			} else {
				var text = 'Tidak Valid'
				var confirmButtonText = 'Iya!'
			}
			Swal.fire({
				title: '<?= $this->lang->line('warning_approval') ?>',
				text: text,
				icon: 'warning',
				showCancelButton: true,
				confirmButtonColor: '#3085d6',
				cancelButtonColor: '#d33',
				confirmButtonText: '<?= $this->lang->line('accept_yes') ?>'
			}).then((result) => {
				if (result.value) {
					$.ajax({
						url: '<?= base_url('reimburse/approval/') ?>',
						type: 'POST',
						data: {
							status: status,
							doc_id: '<?= $reimburseDetail[0]['reimburse_id'] ?>',
							doc_code: '<?= $reimburseDetail[0]['user_id'] ?>'
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
									window.location = "<?= base_url('reimburse') ?>";
								});
							} else {
								Toast.fire({
									icon: 'warning',
									title: response.message
								})

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
			});
		}
	</script>
