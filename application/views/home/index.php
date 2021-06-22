<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<div class="main-content">
	<div class="main-content-inner">
		<div class="breadcrumbs ace-save-state" id="breadcrumbs">
			<ul class="breadcrumb">
				<li class="active">
					<i class="ace-icon fa fa-home home-icon"></i>
					<a href=""><?= $this->lang->line('home_title') ?></a>
				</li>
			</ul><!-- /.breadcrumb -->
		</div>

		<div class="page-content">

			<!-- <div class="page-header">
				<h1>
					Dashboard
					<small>
						<i class="ace-icon fa fa-angle-double-right"></i>
						overview &amp; stats
					</small>
				</h1>
			</div>/.page-header -->

			<div class="row">
				<div class="col-xs-12">
					<!-- PAGE CONTENT BEGINS -->
					<!-- <div class="alert alert-block alert-success">
							<button type="button" class="close" data-dismiss="alert">
								<i class="ace-icon fa fa-times"></i>
							</button>

							<i class="ace-icon fa fa-check green"></i>

							Welcome to
							<strong class="green">
								Ace
								<small>(v1.4)</small>
							</strong>,
							лёгкий, многофункциональный и простой в использовании шаблон для админки на bootstrap 3.3.6. Загрузить исходники с <a href="https://github.com/bopoda/ace">github</a> (with minified ace js/css files).
						</div> -->

					<div class="row">
						<div class="space-6"></div>

						<div class="col-sm-7 infobox-container">
							<div class="infobox infobox-green">
								<div class="infobox-icon">
									<i class="ace-icon fa fa-comments"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?= $cForumComment ?></span>
									<div class="infobox-content"><?= $this->lang->line('home_comments') ?></div>
								</div>
								<span class="stat stat-<?= $cForumCommentToday ? 'success' : 'important'; ?>"><?= $cForumCommentToday ?> <?= $this->lang->line('home_today') ?></span>
							</div>

							<div class="infobox infobox-blue">
								<div class="infobox-icon">
									<i class="ace-icon fa fa-book"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?= $cDoc ?></span>
									<div class="infobox-content"><?= $this->lang->line('home_document_upload') ?></div>
								</div>
								<span class="stat stat-<?= $cDocToday ? 'success' : 'important'; ?>"><?= $cDocToday ?> <?= $this->lang->line('home_today') ?></span>
							</div>

							<div class="infobox infobox-pink">
								<div class="infobox-icon">
									<i class="ace-icon fa fa-bullhorn"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?= $cForum ?></span>
									<div class="infobox-content"><?= $this->lang->line('home_forum') ?></div>
								</div>
								<span class="stat stat-<?= $cForumToday ? 'success' : 'important'; ?>"><?= $cForumToday ?> <?= $this->lang->line('home_today') ?></span>
							</div>

							<div class="infobox infobox-red">
								<div class="infobox-icon">
									<i class="ace-icon fa fa-edit"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?= $cNotulensi ?></span>
									<div class="infobox-content"><?= $this->lang->line('home_minutes') ?></div>
								</div>
								<span class="stat stat-<?= $cNotulensiToday ? 'success' : 'important'; ?>"><?= $cNotulensiToday ?> <?= $this->lang->line('home_today') ?></span>
							</div>

							<div class="infobox infobox-black">
								<div class="infobox-icon">
									<i class="ace-icon fa fa-users"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?= $cUsers ?></span>
									<div class="infobox-content"><?= $this->lang->line('home_members') ?></div>
								</div>
								<span class="stat stat-<?= $cUsersToday ? 'success' : 'important'; ?>"><?= $cUsersToday ?> <?= $this->lang->line('home_today') ?></span>
							</div>

							<div class="infobox infobox-blue">
								<div class="infobox-icon">
									<i class="ace-icon fa fa-book"></i>
								</div>

								<div class="infobox-data">
									<span class="infobox-data-number"><?= $cDocReq ?></span>
									<div class="infobox-content"><?= $this->lang->line('home_document_request') ?></div>
								</div>

								<span class="stat stat-<?= $cDocReqToday ? 'success' : 'important'; ?>"><?= $cDocReqToday ?> <?= $this->lang->line('home_today') ?></span>
							</div>

							<div class="space-6"></div>
							<!-- 
							<div class="infobox infobox-green infobox-small infobox-dark">
								<div class="infobox-progress">
									<div class="easy-pie-chart percentage" data-percent="61" data-size="39">
										<span class="percent">61</span>%
									</div>
								</div>

								<div class="infobox-data">
									<div class="infobox-content">Task</div>
									<div class="infobox-content">Completion</div>
								</div>
							</div>

							<div class="infobox infobox-blue infobox-small infobox-dark">
								<div class="infobox-chart">
									<span class="sparkline" data-values="3,4,2,3,4,4,2,2"></span>
								</div>

								<div class="infobox-data">
									<div class="infobox-content">Earnings</div>
									<div class="infobox-content">$32,000</div>
								</div>
							</div>

							<div class="infobox infobox-grey infobox-small infobox-dark">
								<div class="infobox-icon">
									<i class="ace-icon fa fa-download"></i>
								</div>

								<div class="infobox-data">
									<div class="infobox-content">Downloads</div>
									<div class="infobox-content">1,205</div>
								</div>
							</div> -->
						</div>

						<div class="vspace-12-sm"></div>

						<div class="col-sm-5">
							<div class="widget-box">
								<div class="widget-header widget-header-flat widget-header-small">
									<h5 class="widget-title">
										<i class="ace-icon fa fa-bullhorn"></i>
										<?= $this->lang->line('home_info') ?>
									</h5>

									<div class="widget-toolbar no-border">
										<!-- <div class="inline dropdown-hover">
											<button class="btn btn-minier btn-primary">
												This Week
												<i class="ace-icon fa fa-angle-down icon-on-right bigger-110"></i>
											</button>

											<ul class="dropdown-menu dropdown-menu-right dropdown-125 dropdown-lighter dropdown-close dropdown-caret">
												<li class="active">
													<a href="#" class="blue">
														<i class="ace-icon fa fa-caret-right bigger-110">&nbsp;</i>
														This Week
													</a>
												</li>

												<li>
													<a href="#">
														<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
														Last Week
													</a>
												</li>

												<li>
													<a href="#">
														<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
														This Month
													</a>
												</li>

												<li>
													<a href="#">
														<i class="ace-icon fa fa-caret-right bigger-110 invisible">&nbsp;</i>
														Last Month
													</a>
												</li>
											</ul>
										</div> -->
									</div>
								</div>

								<div class="widget-body">
									<div class="widget-main">
										<?php foreach ($dataAnnouncement as $announ) { ?>
											<a href="<?= base_url('announcement/view/' . P($announ['announ_id']) . '/' . P($announ['announ_subject'])) ?>">
												<div class="alert alert-block alert-success">
													<i class="ace-icon fa fa-check green"></i>
													<strong class="green">
														<?= P($announ['announ_subject']) ?>,
													</strong>
													<?= P($announ['announ_title']) ?>. <small class="pull-right"><i class="ace-icon fa fa-calendar"></i> <?= date('d/m/Y', strtotime(P($announ['announ_date']))) ?></small>
												</div>
											</a>
										<?php } ?>
									</div><!-- /.widget-main -->
								</div><!-- /.widget-body -->
							</div><!-- /.widget-box -->
						</div><!-- /.col -->
					</div><!-- /.row -->

					<div class="hr hr32 hr-dotted"></div>

					<div class="row">
						<div class="col-sm-6">
							<div class="widget-box transparent" id="recent-box">
								<div class="widget-header">
									<h4 class="widget-title lighter smaller">
										<i class="ace-icon fa fa-rss orange"></i><?= $this->lang->line('home_recent') ?>
									</h4>

									<div class="widget-toolbar no-border">
										<ul class="nav nav-tabs" id="recent-tab">
											<li class="active">
												<a data-toggle="tab" href="#doc-tab"><?= $this->lang->line('home_document') ?></a>
											</li>
											<li>
												<a data-toggle="tab" href="#forum-tab"><?= $this->lang->line('home_forum') ?></a>
											</li>
											<li>
												<a data-toggle="tab" href="#comment-tab"><?= $this->lang->line('home_comments') ?></a>
											</li>
											<li>
												<a data-toggle="tab" href="#member-tab"><?= $this->lang->line('home_members') ?></a>
											</li>
										</ul>
									</div>
								</div>

								<div class="widget-body">
									<div class="widget-main padding-4">
										<div class="tab-content padding-8">
											<div id="doc-tab" class="tab-pane active">
												<h4 class="smaller lighter green">
													<i class="ace-icon fa fa-list"></i>
													Document List
												</h4>

												<ul id="tasks" class="item-list">
													<?php
													$n = 0;
													foreach ($dataDocument as $doc) {
														$docId = $doc['document_id'];
														$docCode = $doc['document_code'];
														$docName = P($doc['document_name']);
														$docCreatedDate = $doc['document_created_date'];
														if ($n == 5) break;
													?>
														<li class="item-orange clearfix">
															<a class="inline" href="<?= base_url("document/view/$docId/$docCode") ?>">
																<span class="lbl"> <?= $docName ?></span>
															</a>
															<div class="pull-right action-buttons">

																<span class="label label-info">
																	<i class="ace-icon fa fa-calendar bigger-120"></i>
																	<?= date("d  M  Y H:i:s", strtotime($docCreatedDate)) ?>
																</span>
															</div>
														</li>
													<?php
														$n++;
													}
													?>
												</ul>
												<div class="space-4"></div>
												<div id="doc-tab" class="tab-pane">
													<div class="center">
														<i class="ace-icon fa fa-book fa-2x green middle"></i>

														&nbsp;
														<a href="<?= base_url("document") ?>" class="btn btn-sm btn-white btn-info">
															<?= $this->lang->line('home_all_document') ?> &nbsp;
															<i class="ace-icon fa fa-arrow-right"></i>
														</a>
													</div>
												</div>
											</div>

											<div id="member-tab" class="tab-pane">
												<div class="clearfix">
													<?php
													$n = 0;
													foreach ($dataUsers as $user) {
														if ($n == 5) break;
														$userId = $user['user_id'];
														$username = $user['user_username'];
														$userImg = $user['ud_img_name'];
														$userRole = $user['role_name'];
														$userCreatedDate = $user['user_created_date'];
														$userSchool = $user['school_name'] ? $user['school_name'] : "-";
													?>
														<div class="itemdiv memberdiv">
															<div class="user">
																<img alt="Bob Doe's avatar" src="assets/images/avatars/<?= $userImg ? $userImg : 'avatar2.png' ?>" />
															</div>

															<div class="body">
																<div class="name">
																	<a href="<?= base_url("user/view/$userId/$username") ?>"><?= $username ?></a>
																</div>

																<div class="time">
																	<i class="ace-icon fa fa-home"></i>
																	<span class="blue"><?= P($userSchool) ?></span>
																</div>
																<div class="time">
																	<i class="ace-icon fa fa-key"></i>
																	<span class="blue"><?= $userRole ?></span>
																</div>

																<!-- <div>
																<span class="label label-info label-sm">pending</span>
															</div> -->
															</div>
														</div>
													<?php
														$n++;
													}
													?>
												</div>

												<div class="space-4"></div>

												<!-- <div class="center">
													<i class="ace-icon fa fa-book fa-2x green middle"></i>

													&nbsp;
													<a href="#" class="btn btn-sm btn-white btn-info">
														See all Document &nbsp;
														<i class="ace-icon fa fa-arrow-right"></i>
													</a>
												</div> -->

												<!-- <div class="hr hr-double hr8"></div> -->
											</div><!-- /.#member-tab -->

											<div id="comment-tab" class="tab-pane">
												<div class="comments">
													<?php
													$n = 0;
													foreach ($dataForumComment as $fc) {
														if ($n == 5) break;
														$fcForumId = $fc['forum_id'];
														$fcForumSlug = $fc['forum_slug'];
														$fcusername = $fc['user_username'];
														$fcContent = $fc['fc_content'];
														$fcImg = $fc['ud_img_name'];
														$fcCreatedDate = $fc['fc_created_date'];
													?>
														<div class="itemdiv commentdiv">
															<div class="user">
																<img alt="Bob Doe's Avatar" src="assets/images/avatars/<?= $fcImg ? $fcImg : 'avatar2.png' ?>" />
															</div>

															<div class="body">
																<div class="name">
																	<a href="<?= base_url("forum/view/$fcForumId/$fcForumSlug") ?>"><?= $fcusername ?></a>
																</div>

																<div class="time">
																	<i class="ace-icon fa fa-calendar"></i>
																	<span class="green"><?= date("d  M  Y H:i:s", strtotime($fcCreatedDate)) ?></span>
																</div>

																<div class="text forumContent">
																	<i class="ace-icon fa fa-quote-left"></i>
																	<span>
																		<?= substr($fcContent, 0, 250) ?>
																	</span>
																</div>
															</div>
														</div>
													<?php
														$n++;
													}
													?>
												</div>

												<div class="hr hr8"></div>

												<!-- <div class="center">
													<i class="ace-icon fa fa-comments-o fa-2x green middle"></i>

													&nbsp;
													<a href="#" class="btn btn-sm btn-white btn-info">
														See all comments &nbsp;
														<i class="ace-icon fa fa-arrow-right"></i>
													</a>
												</div> -->

												<!-- <div class="hr hr-double hr8"></div> -->
											</div>

											<div id="forum-tab" class="tab-pane">
												<div class="comments">
													<?php
													$n = 0;
													foreach ($dataForum as $forum) {
														if ($n == 5) break;
														$forumId = $forum['forum_id'];
														$forumSlug = $forum['forum_slug'];
														$forumTitle = P($forum['forum_title']);
														$forumContent = $forum['forum_content'];
														$forumImg = $forum['ud_img_name'];
														$forumCreatedDate = $forum['forum_created_date'];
													?>
														<div class="itemdiv commentdiv">
															<div class="user">
																<img alt="Bob Doe's Avatar" src="assets/images/avatars/<?= $forumImg ? $forumImg : 'avatar2.png' ?>" />
															</div>

															<div class="body">
																<div class="name">
																	<a href="<?= base_url("forum/view/$forumId/$forumSlug") ?>"><?= $forumTitle ?></a>
																</div>

																<div class="time">
																	<i class="ace-icon fa fa-calendar"></i>
																	<span class="green"><?= date("d  M  Y H:i:s", strtotime($forumCreatedDate)) ?></span>
																</div>

																<div class="text forumContent">
																	<i class="ace-icon fa fa-quote-left"></i>
																	<span>
																		<?= substr($forumContent, 0, 250) ?>
																	</span>
																</div>
															</div>
														</div>
													<?php
														$n++;
													}
													?>
												</div>

												<div class="hr hr8"></div>

												<div class="center">
													<i class="ace-icon fa fa-comments-o fa-2x green middle"></i>

													&nbsp;
													<a href="<?= base_url('forum') ?>" class="btn btn-sm btn-white btn-info">
														<?= $this->lang->line('home_all_forum') ?> &nbsp;
														<i class="ace-icon fa fa-arrow-right"></i>
													</a>
												</div>

												<div class="hr hr-double hr8"></div>
											</div>
										</div>
									</div><!-- /.widget-main -->
								</div><!-- /.widget-body -->
							</div><!-- /.widget-box -->
						</div><!-- /.col -->

						<div class="col-sm-6">
							<div class="widget-box">
								<div class="widget-header">
									<h4 class="widget-title lighter smaller">
										<i class="ace-icon fa fa-bullhorn blue"></i>
										<?= $this->lang->line('home_document_image') ?>
									</h4>
								</div>

								<div class="widget-body">
									<div class="widget-main no-padding">
										<div id="myCarousel" class="carousel slide" data-ride="carousel">
											<!-- Indicators -->
											<ol class="carousel-indicators">
												<?php
												$i = 0;
												$active = "active";
												foreach ($dataDocumentAttch as $attch) {
													if ($i == 5) break;
												?>
													<li data-target="#myCarousel" data-slide-to="<?= $i ?>" class="<?= $i == 0 ? $active : '' ?>"></li>
												<?php
													$i++;
												}
												?>
											</ol>

											<!-- Wrapper for slides -->
											<div class="carousel-inner">

												<?php
												$i = 0;
												foreach ($dataDocumentAttch as $attch) {
													if ($i == 5) break;
												?>
													<div class="item <?= $i == 0 ? $active : '' ?>">
														<img src="<?= $attch['da_dir'] ?>" alt="Los Angeles" style="width:100%;">
														<!-- <div class="carousel-caption">
														<h3>Los Angeles</h3>
														<p>LA is always so much fun!</p>
													</div> -->
													</div>
												<?php
													$i++;
												}
												?>

											</div>

											<!-- Left and right controls -->
											<a class="left carousel-control" href="#myCarousel" data-slide="prev">
												<span class="glyphicon glyphicon-chevron-left"></span>
												<span class="sr-only">Previous</span>
											</a>
											<a class="right carousel-control" href="#myCarousel" data-slide="next">
												<span class="glyphicon glyphicon-chevron-right"></span>
												<span class="sr-only">Next</span>
											</a>
										</div>
									</div><!-- /.widget-main -->
								</div><!-- /.widget-body -->
							</div><!-- /.widget-box -->
						</div><!-- /.col -->
					</div><!-- /.row -->

					<!-- PAGE CONTENT ENDS -->
				</div><!-- /.col -->
			</div><!-- /.row -->
		</div><!-- /.page-content -->
	</div>
</div><!-- /.main-content -->

<script>
	$(document).ready(function() {
		$('.forumContent').find('img').remove();
	})
</script>