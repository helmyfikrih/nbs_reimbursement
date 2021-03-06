<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#"><?= $this->lang->line('home_title') ?> </a>
                </li>
                <li class="active"><?= $this->lang->line('search_bread') ?> </li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1><?= $this->lang->line('search_head') ?>
                    <small>
                        <i class="ace-icon fa fa-angle-double-right"></i>
                        <?= $allCount ?> <?= $this->lang->line('search_desc') ?> <?= $q ?>
                    </small>
                </h1>

            </div><!-- /.page-header -->

            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <!-- <div class="clearfix">
                        <div class="center col-sm-12">
                            <form class="form-search col-sm-12">
                                <span class="input-icon">
                                    <input type="text" placeholder="Search ..." class="nav-search-input col-sm-12" id="nav-search-input" autocomplete="off" />
                                    <i class="ace-icon fa fa-search nav-search-icon"></i>
                                </span>
                            </form>
                        </div>
                    </div> -->

                    <div>
                        <div class="row search-page" id="search-page-1">
                            <div class="col-xs-12">
                                <div class="row">
                                    <!-- <div class="col-xs-12 col-sm-3">
                                        <div class="search-area well well-sm">
                                            <div class="search-filter-header bg-primary">
                                                <h5 class="smaller no-margin-bottom">
                                                    <i class="ace-icon fa fa-sliders light-green bigger-130"></i>&nbsp; Refine your Search
                                                </h5>
                                            </div>

                                            <div class="space-10"></div>

                                            <form>
                                                <div class="row">
                                                    <div class="col-xs-12 col-sm-11 col-md-10">
                                                        <div class="input-group">
                                                            <input type="text" class="form-control" name="keywords" placeholder="Look within results" />
                                                            <div class="input-group-btn">
                                                                <button type="button" class="btn btn-default no-border btn-sm">
                                                                    <i class="ace-icon fa fa-search icon-on-right bigger-110"></i>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </form>

                                            <div class="hr hr-dotted"></div>

                                            <h4 class="blue smaller">
                                                <i class="fa fa-tags"></i>
                                                Category
                                            </h4>

                                            <div class="tree-container">
                                                <ul id="cat-tree"></ul>
                                            </div>

                                            <div class="hr hr-dotted"></div>

                                            <h4 class="blue smaller">
                                                <i class="fa fa-map-marker light-orange bigger-110"></i>
                                                Location
                                            </h4>

                                            <div>
                                                <select multiple="" name="state" class="select2 tag-input-style" data-placeholder="Click to Choose...">
                                                    <option value="">&nbsp;</option>
                                                    <option value="AL">Alabama</option>
                                                    <option value="AK">Alaska</option>
                                                    <option value="AZ">Arizona</option>
                                                    <option value="AR">Arkansas</option>
                                                    <option value="CA">California</option>
                                                    <option value="CO">Colorado</option>
                                                    <option value="CT">Connecticut</option>
                                                    <option value="DE">Delaware</option>
                                                    <option value="FL">Florida</option>
                                                    <option value="GA">Georgia</option>
                                                    <option value="HI">Hawaii</option>
                                                    <option value="ID">Idaho</option>
                                                    <option value="IL">Illinois</option>
                                                    <option value="IN">Indiana</option>
                                                    <option value="IA">Iowa</option>
                                                    <option value="KS">Kansas</option>
                                                    <option value="KY">Kentucky</option>
                                                    <option value="LA">Louisiana</option>
                                                    <option value="ME">Maine</option>
                                                    <option value="MD">Maryland</option>
                                                    <option value="MA">Massachusetts</option>
                                                    <option value="MI">Michigan</option>
                                                    <option value="MN">Minnesota</option>
                                                    <option value="MS">Mississippi</option>
                                                    <option value="MO">Missouri</option>
                                                    <option value="MT">Montana</option>
                                                    <option value="NE">Nebraska</option>
                                                    <option value="NV">Nevada</option>
                                                    <option value="NH">New Hampshire</option>
                                                    <option value="NJ">New Jersey</option>
                                                    <option value="NM">New Mexico</option>
                                                    <option value="NY">New York</option>
                                                    <option value="NC">North Carolina</option>
                                                    <option value="ND">North Dakota</option>
                                                    <option value="OH">Ohio</option>
                                                    <option value="OK">Oklahoma</option>
                                                    <option value="OR">Oregon</option>
                                                    <option value="PA">Pennsylvania</option>
                                                    <option value="RI">Rhode Island</option>
                                                    <option value="SC">South Carolina</option>
                                                    <option value="SD">South Dakota</option>
                                                    <option value="TN">Tennessee</option>
                                                    <option value="TX">Texas</option>
                                                    <option value="UT">Utah</option>
                                                    <option value="VT">Vermont</option>
                                                    <option value="VA">Virginia</option>
                                                    <option value="WA">Washington</option>
                                                    <option value="WV">West Virginia</option>
                                                    <option value="WI">Wisconsin</option>
                                                    <option value="WY">Wyoming</option>
                                                </select>
                                            </div>

                                            <div class="hr hr-dotted"></div>

                                            <h4 class="blue smaller">
                                                <i class="fa fa-location-arrow light-grey bigger-110"></i>
                                                Distance
                                            </h4>

                                            <div class="search-filter-element">
                                                <span>within</span>
                                                &nbsp;
                                                <div id="slider-range" class="inline"></div>
                                                &nbsp;
                                                <span>miles</span>
                                            </div>

                                            <div class="hr hr-dotted hr-24"></div>

                                            <div class="text-center">
                                                <button type="button" class="btn btn-default btn-round btn-sm btn-white">
                                                    <i class="ace-icon fa fa-remove red2"></i>
                                                    Reset
                                                </button>

                                                <button type="button" class="btn btn-default btn-round btn-white">
                                                    <i class="ace-icon fa fa-refresh green"></i>
                                                    Update
                                                </button>
                                            </div>

                                            <div class="space-4"></div>
                                        </div>
                                    </div> -->

                                    <div class="col-xs-12 col-sm-9">
                                        <div class="row">
                                            <!-- <div class="search-area well col-xs-12">
                                                <div class="pull-left">
                                                    <b class="text-primary">Display</b>

                                                    &nbsp;
                                                    <div id="toggle-result-format" class="btn-group btn-overlap" data-toggle="buttons">
                                                        <label title="Thumbnail view" class="btn btn-lg btn-white btn-success active" data-class="btn-success" aria-pressed="true">
                                                            <input type="radio" value="2" autocomplete="off" />
                                                            <i class="icon-only ace-icon fa fa-th"></i>
                                                        </label>

                                                        <label title="List view" class="btn btn-lg btn-white btn-grey" data-class="btn-primary">
                                                            <input type="radio" value="1" checked="" autocomplete="off" />
                                                            <i class="icon-only ace-icon fa fa-list"></i>
                                                        </label>

                                                        <label title="Map view" class="btn btn-lg btn-white btn-grey" data-class="btn-warning">
                                                            <input type="radio" value="3" autocomplete="off" />
                                                            <i class="icon-only ace-icon fa fa-crosshairs"></i>
                                                        </label>
                                                    </div>
                                                </div>

                                                <div class="pull-right">
                                                    <b class="text-primary">Order</b>

                                                    &nbsp;
                                                    <select>
                                                        <option>Relevance</option>
                                                        <option>Newest First</option>
                                                        <option>Rating</option>
                                                    </select>
                                                </div>
                                            </div> -->
                                        </div>

                                        <!-- <div class="row">
                                            <div class="col-xs-6 col-sm-4 col-md-3">
                                                <div class="thumbnail search-thumbnail">
                                                    <span class="search-promotion label label-success arrowed-in arrowed-in-right">Sponsored</span>

                                                    <img class="media-object" data-src="holder.js/100px200?theme=gray" />
                                                    <div class="caption">
                                                        <div class="clearfix">
                                                            <span class="pull-right label label-grey info-label">London</span>

                                                            <div class="pull-left bigger-110">
                                                                <i class="ace-icon fa fa-star orange2"></i>

                                                                <i class="ace-icon fa fa-star orange2"></i>

                                                                <i class="ace-icon fa fa-star orange2"></i>

                                                                <i class="ace-icon fa fa-star-half-o orange2"></i>

                                                                <i class="ace-icon fa fa-star light-grey"></i>
                                                            </div>
                                                        </div>

                                                        <h3 class="search-title">
                                                            <a href="#" class="blue">Thumbnail label</a>
                                                        </h3>
                                                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4 col-md-3">
                                                <div class="thumbnail search-thumbnail">
                                                    <img class="media-object" data-src="holder.js/100px200?theme=gray" />
                                                    <div class="caption">
                                                        <div class="clearfix">
                                                            <span class="pull-right label label-grey info-label">Tokyo</span>
                                                        </div>

                                                        <h3 class="search-title">
                                                            <a href="#" class="blue">Thumbnail label</a>
                                                        </h3>
                                                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4 col-md-3">
                                                <div class="thumbnail search-thumbnail">
                                                    <img class="media-object" data-src="holder.js/100px200?theme=gray" />
                                                    <div class="caption">
                                                        <div class="clearfix">
                                                            <span class="pull-right label label-grey info-label">Istanbul</span>
                                                        </div>

                                                        <h3 class="search-title">
                                                            <a href="#" class="blue">Thumbnail label</a>
                                                        </h3>
                                                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xs-6 col-sm-4 col-md-3">
                                                <div class="thumbnail search-thumbnail">
                                                    <img class="media-object" data-src="holder.js/100px200?theme=social" />
                                                    <div class="caption">
                                                        <div class="clearfix">
                                                            <span class="pull-right label label-grey info-label">Chicago</span>
                                                        </div>

                                                        <h3 class="search-title">
                                                            <a href="#" class="blue">Thumbnail label</a>
                                                        </h3>
                                                        <p>Cras justo odio, dapibus ac facilisis in, egestas eget quam ...</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->

                                        <div class="space-12"></div>
                                        <div class="row">
                                            <div class="col-xs-12" id="forumList">
                                            </div>
                                        </div>
                                        <!-- Paginate -->
                                        <div id='pagination'></div>
                                        <!-- <div class="row">
                                            <div class="col-xs-12">
                                                <?php if ($dataResult) {
                                                    foreach ($dataResult as $res) { ?>
                                                        <div class="media search-media">
                                                            <div class="media-left">
                                                                <a href="#">
                                                                    <img class="media-object" data-src="holder.js/72x72" />
                                                                </a>
                                                            </div>

                                                            <div class="media-body">
                                                                <div>
                                                                    <h4 class="media-heading">
                                                                        <a href="#" class="blue">Media heading</a>
                                                                    </h4>
                                                                </div>
                                                                <p>Cras sit amet nibh libero, in gravida nulla. Nulla vel metus scelerisque ante sollicitudin commodo. Cras purus odio, vestibulum in vulputate at, tempus viverra turpis ...</p>

                                                                <div class="search-actions text-center">
                                                                    <span class="text-info">$</span>

                                                                    <span class="blue bolder bigger-150">300</span>

                                                                    monthly
                                                                    <div class="action-buttons bigger-125">
                                                                        <a href="#">
                                                                            <i class="ace-icon fa fa-phone green"></i>
                                                                        </a>

                                                                        <a href="#">
                                                                            <i class="ace-icon fa fa-heart red"></i>
                                                                        </a>

                                                                        <a href="#">
                                                                            <i class="ace-icon fa fa-star orange2"></i>
                                                                        </a>
                                                                    </div>
                                                                    <a class="search-btn-action btn btn-sm btn-block btn-info">Book it!</a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                <?php
                                                    }
                                                } ?>
                                            </div>
                                        </div> -->
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

<script>
    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }
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

        // Load pagination
        function loadPagination(pagno) {
            $.ajax({
                url: '<?= base_url() ?>home/loadSearchRecord/' + pagno,
                type: 'get',
                dataType: 'json',
                data: {
                    q: '<?= $this->input->get('q') ?>',
                },
                success: function(response) {
                    $('#pagination').html(response.pagination);
                    createForumList(response.result, response.row);
                }
            });
        }

        // Create table list
        function createForumList(result, sno) {
            sno = Number(sno);
            $('#forumList').empty();
            for (index in result) {
                var id = result[index].id;
                var from = result[index].from;
                // console.log(from)
                var title = htmlEntities(result[index].title);
                var slug = result[index].code;
                var content = result[index].desc;
                var userName = result[index].username;
                var createdDate = result[index].date;
                var btn = '';
                var btnEdit = '';
                var btnDelete = '';
                if (from == 'forum') {
                    icon = 'forum.png';
                }
                if (from == 'document') {
                    icon = 'document.png';
                }
                // btnDelete = `<a href="#">
                //                 <i class="ace-icon fa fa-trash red"></i>
                //             </a>`;
                content = content.substr(0, 25) + "...";
                // var link = result[index].link;
                sno += 1;

                var list = `<div class="media search-media">
                                                    <div class="media-left">
                                                        <a href="#">
                                                          <img class="media-object" style="max-width:60px;" src="<?= base_url('assets/images/icon/') ?>${icon}"/>
                                                        </a>
                                                    </div>

                                                    <div class="media-body">
                                                        <div>
                                                            <h4 class="media-heading">
                                                                <a href="<?= base_url() ?>${from}/view/${id}/${slug}" class="blue">${title}</a>
                                                            </h4>
                                                        </div>
                                                        ${content}
                                                         <div class="search-actions text-center">
                                                            <span class="text-info"></span>

                                                            <span class="blue bolder">${userName}</span>
                                                            <br>
                                                            ${createdDate}
                                                            <div class="action-buttons bigger-125">
                                                            
                                                                <a href="<?= base_url() ?>${from}/view/${id}/${slug}">
                                                                    <i class="ace-icon fa fa-eye blue"></i>
                                                                </a>
                                                                ${btn}
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>`;
                $('#forumList').append(list);

            }
        }
    });
</script>