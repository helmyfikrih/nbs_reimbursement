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
                <li class="active"><?= $this->lang->line('designation_title') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1><?= $this->lang->line('designation_title') ?></h1>
            </div><!-- /.page-header -->
            <div class="pull-right">
                <!-- <span class="green middle bolder">Choose result page type: &nbsp;</span> -->
                <div class="btn-group">
                    <a id="add-group" href="javascript:;" onclick="clearData()" class=" btn btn-white btn-info btn-bold">
                        <i class="ace-icon fa fa-plus bigger-120 blue"></i>
                        <?= $this->lang->line('designation_create') ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="toggle-add-group" style="display:none; background-color:#EEEEEE;width:400px;min-height:100px;position:absolute;z-index:9; padding:10px; margin-top:-10px">
                    <style>
                        .row {
                            margin-left: -15px;
                            margin-right: -15px;
                        }

                        .col-md-6 {
                            width: 45%;
                            position: relative;
                            min-height: 1px;
                            padding-left: 15px;
                            padding-right: 15px;
                            float: left;
                        }
                    </style>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <table border="0" width="100%">
                                <input type="hidden" id="designation_id" name="designation_id" />
                                <tr>
                                    <td><?= $this->lang->line('designation_name') ?></td>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;"><input type="text" placeholder="<?= $this->lang->line('designation_name') ?>" id="designation_name" name="designation_name" /></td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button name="" id="" class="btn blue" onclick="input_designation_data()">Submit</button>&nbsp;
                                        <button name="" id="" class="btn blue" onclick="remove_toggle('toggle-add-group'); clearData();">Cancel</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
            <hr>
            <!-- div.dataTables_borderWrap -->
            <div class="dataTables_borderWrap">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>Designation ID</th>
                            <th><?= $this->lang->line('designation_name') ?></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
        </div><!-- /.row -->
    </div><!-- /.page-content -->
</div><!-- /.main-content -->


<!-- page specific plugin scripts -->
<script src="<?= base_url() ?>assets/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url() ?>assets/js/jquery.dataTables.bootstrap.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.select.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.colVis.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        //initiate dataTables plugin
        var myTable =
            $('#dynamic-table')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .DataTable({
                bAutoWidth: false,
                "aoColumns": [null, null,
                    {
                        "bSortable": false
                    }
                ],
                "aaSorting": [],


                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "<?= base_url("designation/getList/"); ?>",
                    type: "POST",
                    data: function(d) {
                        // d.id_region = $('#region').val();
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

                "sScrollX": "80%",
                "sScrollXInner": "100%",
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
<!-- END JAVASCRIPTS -->
<script type="text/javascript">
    /*function load_region() {
	jQuery.ajax({
		url : domain + loadx0,
		dataType : "json",
		type : "POST",
		success : function (e) {
			if (e.length != 0) {
				for (var t = 0; t < e.length; t++) {
					var n = '<option id="region_' + e[t].id_region + '" value="' + e[t].id_region + '">' + e[t].name_region + "</option> ";
					$("#region").append(n)
				}
			}
		}
	})
}
*/

    function getID(e) {
        var t = e.id;
        alert(e.id)
    }


    function remove_toggle(e) {
        jQuery("." + e).toggle("slow")
    }

    function close_dialog(e) {
        $("#" + e).dialog("close")
    }

    function input_designation_data() {
        if (jQuery('#designation_name').val() === '') {
            alert("Fill the values");
            return;
        }

        $('button[type=submit]').prop('disabled', true);

        ngeklik();
        // loading("tab-content");
        var designation_id = jQuery("#designation_id").val();
        var designation_name = jQuery("#designation_name").val();
        jQuery.ajax({
            url: "<?= base_url() ?>designation/save",
            dataType: "json",
            type: "POST",
            // beforeSend: function() {$('#loading').show();},	
            // complete: function() {$('#loading').hide();	},
            data: {
                designation_id: designation_id,
                designation_name: designation_name,
            },
            success: function(e) {
                $('button[type=submit]').prop('disabled', false);
                if (e.is_success) {
                    clearData();
                    Toast.fire({
                        icon: 'success',
                        title: e.message
                    });
                    remove_toggle("toggle-add-group")
                    $('#dynamic-table').DataTable().ajax.reload(null, false);
                } else {
                    alert(e)
                }
            }
        })
    }


    function clearData() {
        jQuery("#designation_id").val("");
        jQuery("#designation_name").val("");
        //	jQuery("#designation").val("");
    }


    function editData(e) {
        $('input:checkbox').removeAttr('checked');
        jQuery.ajax({
            type: "post",
            data: {
                id: e
            },
            url: "<?= base_url() ?>designation/getOne",
            dataType: "json",
            success: function(e) {
                jQuery("#designation_id").val(e[0].designation_id);
                jQuery("#designation_name").val(e[0].designation_name);
            }
        });
        jQuery(".toggle-add-group").show("slow")
    }

    function ngeklik() {
        var e = [];
        $("#accordion3 input:checked").each(function() {
            e.push($(this).val())
        });
        $("#imenu").html(e.toString())
    }

    $("#accordion3 input:checkbox").click(function() {

        var e = $(this).attr("id");
        var t = $(this).val();
        jQuery.ajax({
            type: "post",
            data: {
                id: t
            },
            url: "<?= base_url() ?>designation/cekpohon",
            dataType: "json",
            success: function(e) {
                for (x = 0; x < e.length; x++) {
                    $("#box_" + e[x].id).attr("checked", "checked")
                }
            }
        });
        if ($(this).is(":checked")) {
            $(".down_" + t + " :checkbox").prop("checked", true)
        } else {
            $(".down_" + t + " :checkbox").prop("checked", false)
        }
    })
</script>


<script type="text/javascript">
    var type = 'Normal';
    jQuery(document).ready(function() {

        //LOAD FOR INPUT/EDIT
        jQuery('#add-group').click(function() {
            clearData()
            $("#box_1").attr("checked", "checked");
            $("#password").attr("placeholder", "password");
            jQuery('.toggle-add-group').toggle('slow');
            return false;
        });
    });
</script>


<script>
    function deleteData(id) {

        var text = '<?= $this->lang->line('designation_warning_delete') ?>'
        var confirmButtonText = '<?= $this->lang->line('accept_yes') ?>'
        Swal.fire({
            title: '<?= $this->lang->line('warning_approval') ?>',
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: confirmButtonText
        }).then((result) => {
            if (result.value) {
                $.ajax({
                    url: '<?= base_url('designation/deleteData/') ?>' + id,
                    type: 'POST',
                    data: {},
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
                            $.gritter.add({
                                title: '<?= $this->lang->line('text_failed') ?>',
                                text: response.message,
                                class_name: 'gritter-error gritter-light'
                            });

                        }

                    },
                    error: function(xhr, status, error) {
                        //console.log(xhr);
                        $.gritter.add({
                            title: '<?= $this->lang->line('text_error') ?>',
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