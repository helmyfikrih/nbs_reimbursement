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
                <li class="active"><?= $this->lang->line('notulensi_title') ?></li>
            </ul><!-- /.breadcrumb -->

            <div class="nav-search" id="nav-search">
            </div><!-- /.nav-search -->
        </div>

        <div class="page-content">

            <div class="page-header">

                <div class="clearfix">
                    <div class="pull-left">
                        <h1><?= $this->lang->line('notulensi_head') ?> </h1>
                    </div>
                    <div class="pull-right">
                        <!-- <span class="green middle bolder">Choose result page type: &nbsp;</span> -->
                        <?php if ((in_array($menu_allow . '_add', $user_allow_menu))) { ?>
                            <a href="<?= base_url('notulensi/create') ?>" class="btn btn-white btn-info btn-bold">
                                <i class="ace-icon fa fa-pencil bigger-120 blue"></i>
                                <?= $this->lang->line('notulensi_create') ?>
                            </a>
                        <?php } ?>
                        <a class="btn btn-white btn-info btn-bold collapsed" data-toggle="collapse" href="#kms_filter" aria-expanded="false">
                            <i class="ace-icon fa fa-filter bigger-120 blue"></i>
                            <?= $this->lang->line('text_filter') ?>
                        </a>
                    </div>
                </div>

            </div><!-- /.page-header -->
            <!-- advance search -->
            <div id="kms_filter" class="collapse animated fadeIn" data-parent="#accordion">
                <div class="row">
                    <div class="col-md-12">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="first_name"><?= $this->lang->line('notulensi_school') ?></label>
                                <select class="form-control select2" name="filter_school" id="filter_school" data-placeholder="<?= $this->lang->line('text_select_option') ?>">
                                    <option value="0">-- <?= $this->lang->line('text_all') ?> --</option>
                                    <?php
                                    foreach ($filterSchools as $school) { ?>
                                        <option value="<?= EncryptString($school['school_id']) ?>"><?= $school['school_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="first_name"><?= $this->lang->line('notulensi_type') ?></label>
                                <select class="form-control select2" name="filter_meetType" id="filter_meetType" data-placeholder="<?= $this->lang->line('text_select_option') ?>">
                                    <option value="0">-- <?= $this->lang->line('text_all') ?> --</option>
                                    <?php
                                    foreach ($filterMeetType as $meetType) { ?>
                                        <option value="<?= EncryptString($meetType['meetType_id']) ?>"><?= $meetType['meetType_name'] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="first_name"><?= $this->lang->line('text_status') ?></label>
                                <select class="form-control select2" name="filter_status" id="filter_status" data-placeholder="<?= $this->lang->line('text_select_option') ?>">
                                    <option value="0">-- <?= $this->lang->line('text_all') ?> --</option>
                                    <option value="<?= EncryptString('1') ?>"><?= $this->lang->line('notulensi_validated_status') ?></option>
                                    <option value="<?= EncryptString('2') ?>"><?= $this->lang->line('notulensi_waiting_valid') ?></option>
                                    <option value="<?= EncryptString('3') ?>"><?= $this->lang->line('notulensi_invalidated_status') ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <a class="btn btn-white btn-info btn-bold" href="javascript:;" onclick="resetFilter();">
                                <i class="ace-icon fa fa-refresh bigger-120 blue"></i>
                                <?= $this->lang->line('text_reset') ?>
                            </a>
                        </div>
                    </div>
                    <hr>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12">
                    <!-- PAGE CONTENT BEGINS -->
                    <div>
                        <div class="row search-page" id="search-page-1">
                            <div class="row">
                                <div class="col-xs-12">
                                    <div class="clearfix">
                                        <div class="pull-right tableTools-container"></div>
                                    </div>
                                    <!-- div.table-responsive -->

                                    <!-- div.dataTables_borderWrap -->
                                    <div class="table-responsive">
                                        <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <!-- <th class="center">
                                                        <label class="pos-rel">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"></span>
                                                        </label>
                                                    </th> -->
                                                    <th><?= $this->lang->line('notulensi_school') ?></th>
                                                    <th>
                                                        <i class="ace-icon fa fa-user bigger-110 hidden-480"></i>
                                                        <?= $this->lang->line('notulensi_user') ?>
                                                    </th>
                                                    <th><?= $this->lang->line('notulensi_code') ?></th>
                                                    <th><?= $this->lang->line('notulensi_agenda') ?></th>
                                                    <th class="hidden-480"><?= $this->lang->line('notulensi_content') ?></th>

                                                    <th>
                                                        <i class="ace-icon fa fa-clock-o bigger-110 hidden-480"></i>
                                                        <?= $this->lang->line('notulensi_date') ?>
                                                    </th>
                                                    <th>
                                                        <i class="ace-icon fa fa-info"></i>
                                                        <?= $this->lang->line('notulensi_type') ?>
                                                    </th>
                                                    <th class="hidden-480"><?= $this->lang->line('notulensi_status') ?></th>

                                                    <th></th>
                                                </tr>
                                            </thead>

                                            <tbody>
                                                <!-- <tr>
                                                    <td class="center">
                                                        <label class="pos-rel">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"></span>
                                                        </label>
                                                    </td>
                                                    <td>$45</td>
                                                    <td class="hidden-480">3,330</td>
                                                    <td>Feb 12</td>

                                                    <td class="hidden-480">
                                                        <span class="label label-sm label-warning">Expiring</span>
                                                    </td>

                                                    <td>
                                                        <div class="hidden-sm hidden-xs action-buttons">
                                                            <a class="blue" href="#">
                                                                <i class="ace-icon fa fa-search-plus bigger-130"></i>
                                                            </a>

                                                            <a class="green" href="#">
                                                                <i class="ace-icon fa fa-pencil bigger-130"></i>
                                                            </a>

                                                            <a class="red" href="#">
                                                                <i class="ace-icon fa fa-trash-o bigger-130"></i>
                                                            </a>
                                                        </div>

                                                        <div class="hidden-md hidden-lg">
                                                            <div class="inline pos-rel">
                                                                <button class="btn btn-minier btn-yellow dropdown-toggle" data-toggle="dropdown" data-position="auto">
                                                                    <i class="ace-icon fa fa-caret-down icon-only bigger-120"></i>
                                                                </button>

                                                                <ul class="dropdown-menu dropdown-only-icon dropdown-yellow dropdown-menu-right dropdown-caret dropdown-close">
                                                                    <li>
                                                                        <a href="#" class="tooltip-info" data-rel="tooltip" title="View">
                                                                            <span class="blue">
                                                                                <i class="ace-icon fa fa-search-plus bigger-120"></i>
                                                                            </span>
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="#" class="tooltip-success" data-rel="tooltip" title="Edit">
                                                                            <span class="green">
                                                                                <i class="ace-icon fa fa-pencil-square-o bigger-120"></i>
                                                                            </span>
                                                                        </a>
                                                                    </li>

                                                                    <li>
                                                                        <a href="#" class="tooltip-error" data-rel="tooltip" title="Delete">
                                                                            <span class="red">
                                                                                <i class="ace-icon fa fa-trash-o bigger-120"></i>
                                                                            </span>
                                                                        </a>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr> -->

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- PAGE CONTENT ENDS -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.page-content -->
        </div>
    </div>
</div><!-- /.main-content -->
<!-- page specific plugin scripts -->
<script src="<?= base_url() ?>assets/js/select2.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.flash.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.colVis.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.select.min.js"></script>

<script src="<?= base_url() ?>assets/js/jquery-ui.custom.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.ui.touch-punch.min.js"></script>
<!-- inline scripts related to this page -->
<script type="text/javascript">
    jQuery(function($) {
        //initiate dataTables plugin
        var myTable =
            $('#dynamic-table')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .DataTable({
                bAutoWidth: false,
                "aoColumns": [
                    null, null, null, null, null, null, null, null,
                    {
                        "bSortable": false
                    }
                ],
                "aaSorting": [],


                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "<?= base_url("notulensi/getList/"); ?>",
                    type: "POST",
                    data: function(f) {
                        f.filter_school = $('#filter_school').val();
                        f.filter_meetType = $('#filter_meetType').val();
                        f.filter_status = $('#filter_status').val();
                    }
                },
                "initComplete": function(settings, json) {
                    $('#dynamic-table_filter input').unbind();
                    $('#dynamic-table_filter input').bind('keyup', function(e) {
                        if (e.keyCode == 13) {
                            myTable.search(this.value).draw();
                        }
                    });
                },
                //,
                //"sScrollY": "200px",
                //"bPaginate": false,

                "sScrollX": "100%",
                "sScrollXInner": "120%",
                "bScrollCollapse": true,
                //Note: if you are applying horizontal scrolling (sScrollX) on a ".table-bordered"
                //you may want to wrap the table inside a "div.dataTables_borderWrap" element

                //"iDisplayLength": 50


                select: {
                    style: 'single'
                }
            });



        $.fn.dataTable.Buttons.defaults.dom.container.className = 'dt-buttons btn-overlap btn-group btn-overlap';

        new $.fn.dataTable.Buttons(myTable, {
            buttons: [{
                    "extend": "colvis",
                    "text": "<i class='fa fa-search bigger-110 blue'></i> <span class='hidden'>Show/hide columns</span>",
                    "className": "btn btn-white btn-primary btn-bold",
                    columns: ':not(:first):not(:last)'
                },
                {
                    "extend": "copy",
                    "text": "<i class='fa fa-copy bigger-110 pink'></i> <span class='hidden'>Copy to clipboard</span>",
                    "className": "btn btn-white btn-primary btn-bold"
                },
                {
                    "extend": "csv",
                    "text": "<i class='fa fa-database bigger-110 orange'></i> <span class='hidden'>Export to CSV</span>",
                    "className": "btn btn-white btn-primary btn-bold"
                },
                {
                    "extend": "excel",
                    "text": "<i class='fa fa-file-excel-o bigger-110 green'></i> <span class='hidden'>Export to Excel</span>",
                    "className": "btn btn-white btn-primary btn-bold"
                },
                {
                    "extend": "pdf",
                    "text": "<i class='fa fa-file-pdf-o bigger-110 red'></i> <span class='hidden'>Export to PDF</span>",
                    "className": "btn btn-white btn-primary btn-bold"
                },
                {
                    "extend": "print",
                    "text": "<i class='fa fa-print bigger-110 grey'></i> <span class='hidden'>Print</span>",
                    "className": "btn btn-white btn-primary btn-bold",
                    autoPrint: false,
                    message: 'This print was produced using the Print button for DataTables'
                }
            ]
        });
        myTable.buttons().container().appendTo($('.tableTools-container'));

        //style the message box
        var defaultCopyAction = myTable.button(1).action();
        myTable.button(1).action(function(e, dt, button, config) {
            defaultCopyAction(e, dt, button, config);
            $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
        });


        var defaultColvisAction = myTable.button(0).action();
        myTable.button(0).action(function(e, dt, button, config) {

            defaultColvisAction(e, dt, button, config);


            if ($('.dt-button-collection > .dropdown-menu').length == 0) {
                $('.dt-button-collection')
                    .wrapInner('<ul class="dropdown-menu dropdown-light dropdown-caret dropdown-caret" />')
                    .find('a').attr('href', '#').wrap("<li />")
            }
            $('.dt-button-collection').appendTo('.tableTools-container .dt-buttons')
        });

        ////

        setTimeout(function() {
            $($('.tableTools-container')).find('a.dt-button').each(function() {
                var div = $(this).find(' > div').first();
                if (div.length == 1) div.tooltip({
                    container: 'body',
                    title: div.parent().text()
                });
                else $(this).tooltip({
                    container: 'body',
                    title: $(this).text()
                });
            });
        }, 500);





        myTable.on('select', function(e, dt, type, index) {
            if (type === 'row') {
                $(myTable.row(index).node()).find('input:checkbox').prop('checked', true);
            }
        });
        myTable.on('deselect', function(e, dt, type, index) {
            if (type === 'row') {
                $(myTable.row(index).node()).find('input:checkbox').prop('checked', false);
            }
        });




        /////////////////////////////////
        //table checkboxes
        $('th input[type=checkbox], td input[type=checkbox]').prop('checked', false);

        //select/deselect all rows according to table header checkbox
        $('#dynamic-table > thead > tr > th input[type=checkbox], #dynamic-table_wrapper input[type=checkbox]').eq(0).on('click', function() {
            var th_checked = this.checked; //checkbox inside "TH" table header

            $('#dynamic-table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) myTable.row(row).select();
                else myTable.row(row).deselect();
            });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#dynamic-table').on('click', 'td input[type=checkbox]', function() {
            var row = $(this).closest('tr').get(0);
            if (this.checked) myTable.row(row).deselect();
            else myTable.row(row).select();
        });



        $(document).on('click', '#dynamic-table .dropdown-toggle', function(e) {
            e.stopImmediatePropagation();
            e.stopPropagation();
            e.preventDefault();
        });



        //And for the first simple table, which doesn't have TableTools or dataTables
        //select/deselect all rows according to table header checkbox
        var active_class = 'active';
        $('#simple-table > thead > tr > th input[type=checkbox]').eq(0).on('click', function() {
            var th_checked = this.checked; //checkbox inside "TH" table header

            $(this).closest('table').find('tbody > tr').each(function() {
                var row = this;
                if (th_checked) $(row).addClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', true);
                else $(row).removeClass(active_class).find('input[type=checkbox]').eq(0).prop('checked', false);
            });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#simple-table').on('click', 'td input[type=checkbox]', function() {
            var $row = $(this).closest('tr');
            if ($row.is('.detail-row ')) return;
            if (this.checked) $row.addClass(active_class);
            else $row.removeClass(active_class);
        });



        /********************************/
        //add tooltip for small view action buttons in dropdown menu
        $('[data-rel="tooltip"]').tooltip({
            placement: tooltip_placement
        });

        //tooltip placement on right or left
        function tooltip_placement(context, source) {
            var $source = $(source);
            var $parent = $source.closest('table')
            var off1 = $parent.offset();
            var w1 = $parent.width();

            var off2 = $source.offset();
            //var w2 = $source.width();

            if (parseInt(off2.left) < parseInt(off1.left) + parseInt(w1 / 2)) return 'right';
            return 'left';
        }




        /***************/
        $('.show-details-btn').on('click', function(e) {
            e.preventDefault();
            $(this).closest('tr').next().toggleClass('open');
            $(this).find(ace.vars['.icon']).toggleClass('fa-angle-double-down').toggleClass('fa-angle-double-up');
        });
        /***************/





        /**
        //add horizontal scrollbars to a simple table
        $('#simple-table').css({'width':'2000px', 'max-width': 'none'}).wrap('<div style="width: 1000px;" />').parent().ace_scroll(
          {
        	horizontal: true,
        	styleClass: 'scroll-top scroll-dark scroll-visible',//show the scrollbars on top(default is bottom)
        	size: 2000,
        	mouseWheelLock: true
          }
        ).css('padding-top', '12px');
        */


    })
</script>

<script>
    function approval(status, id) {
        if (status == '0') {
            var text = '<?= $this->lang->line('notulensi_delete_warning') ?>'
            var confirmButtonText = '<?= $this->lang->line('notulensi_agree') ?>'
        }
        Swal.fire({
            title: '<?= $this->lang->line('notulensi_approval') ?>',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('notulensi/approval/') ?>' + id,
                    type: 'POST',
                    data: {
                        status: status
                    },
                    dataType: 'json',
                    success: function(data) {
                        response = jQuery.parseJSON(JSON.stringify(data));
                        if (response.is_success === true) {
                            Toast.fire({
                                icon: 'success',
                                title: response.message
                            })
                            $('#dynamic-table').DataTable().ajax.reload(null, false);
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
                            title: response.message
                        })
                    },
                    timeout: 300000 // sets timeout to 5 minutes
                });
            }
        });
    }
</script>

<!-- script filter -->
<script>
    $('.select2').select2({
        width: '100%'
    });

    $('.select2').on('select2:select', function(e) {
        $('#dynamic-table').DataTable().ajax.reload(null, false);
    });

    function resetFilter() {
        $('.select2').val('0');
        $('.select2').trigger('change.select2');
        $('#dynamic-table').DataTable().ajax.reload(null, false);
    }
</script>