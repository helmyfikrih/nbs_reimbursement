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
                <li class="active"><?= $this->lang->line('role_title') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1><?= $this->lang->line('role_title') ?></h1>
            </div><!-- /.page-header -->
            <div class="pull-right">
                <!-- <span class="green middle bolder">Choose result page type: &nbsp;</span> -->
                <div class="btn-group">
                    <a id="add-group" href="javascript:;" onclick="clearData()" class=" btn btn-white btn-info btn-bold">
                        <i class="ace-icon fa fa-plus bigger-120 blue"></i>
                        <?= $this->lang->line('role_create') ?>
                    </a>
                </div>
            </div>
            <div class="row">
                <div class="toggle-add-group" style="display:none; background-color:#EEEEEE;width:800px;min-height:100px;position:absolute;z-index:9; padding:10px; margin-top:-10px">
                    <style>

                    </style>
                    <div class="row">
                        <div class="col-md-6 col-sm-6">
                            <table border="0" width="100%">
                                <input type="hidden" id="role_id" name="role_id" />
                                <tr>
                                    <td><?= $this->lang->line('role_name') ?></td>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;"><input type="text" placeholder="<?= $this->lang->line('role_name') ?>" id="role_name" name="role_name" /></td>
                                </tr>
                                <tr>
                                    <td><?= $this->lang->line('role_code') ?></td>
                                    <td style="padding-left: 20px; padding-bottom: 5px;"><input type="text" placeholder="<?= $this->lang->line('role_code') ?>" id="role_code" name="role_code" /></td>
                                </tr>
                                <!--
							<tr>
									<td>Role</td>
									<td>
										<div id="selector">
											<select name="role" id="role" class="m-wrap scroll-select">
												<option value="DIRUT">Direktur Utama</option>
												<option value="SRM">Sales Region Manager</option>
												<option value="SAM">Sales Area Manager</option>
												<option value="SAS">Sales Area Supervisor</option>
												<option value="SPV">Supervisor</option>
												<option selected value="SLS">Salesman</option>
											</select>
										</div>
									</td>
							</tr>
							-->
                                <tr>
                                    <td></td>
                                    <td>
                                        <button name="" id="" class="btn blue" onclick="input_role_data()">Submit</button>&nbsp;
                                        <button name="" id="" class="btn blue" onclick="remove_toggle('toggle-add-group'); clearData();">Cancel</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div id="imenu" style="display:none"></div>
                            <style>
                                .akar_dua {
                                    padding-left: 25px
                                }

                                .akar_tiga {
                                    padding-left: 50px
                                }

                                #accordion3 input[type="checkbox"] {
                                    margin-top: -3px !important;
                                }

                                #selector {
                                    width: 220px;
                                    overflow: auto;
                                    margin-bottom: 10px;
                                }

                                .scroll-select {
                                    width: auto !important;
                                    min-width: 220px;
                                    margin-bottom: 0px !important;
                                }
                            </style>

                            <div class="panel-group accordion" id="accordion3">
                                Access Level

                                <?php
                                define('MAINDOMAIN', 'peka');
                                $data = $menuakses;
                                // print_r($data);
                                foreach ($data['root'] as $top) {
                                    $rootname = $top['menu_name'];
                                    $rootid   = $top['menu_id'];

                                    if (isset($data['sub_' . $rootid])) {
                                        echo '<div class="panel panel-default"><i class="ace-icon fa fa-plus bigger-120 blue"></i>
									<input id="box_' . $rootid . '" type="checkbox" value="' . $rootid . '" onclick="treedata(this)" >
									<a class="" data-toggle="collapse"  href="#collapse_' . $rootid . '">' . $rootname . '</a>
								  <div style="height: 0px; " id="collapse_' . $rootid . '" class="panel-collapse collapse akar_dua down_' . $rootid . '">';

                                        foreach ($data['sub_' . $rootid] as $sub_satu) {

                                            if (isset($data['sub_' . $rootid . '_' . $sub_satu->menu_id])) {
                                                echo '<div class="panel panel-default"><i class="ace-icon fa fa-plus bigger-120 blue"></i>
											<input type="checkbox" id="box_' . $sub_satu->menu_id . '" value="' . $sub_satu->menu_id . '" >
                                            <a class="" data-toggle="collapse"  href="#sub_tiga_' . $sub_satu->menu_id . '">' . $sub_satu->menu_name . ' <span class="arrow"></span></a>
											<div style="height: 0px;" id="sub_tiga_' . $sub_satu->menu_id . '" class="panel-collapse collapse akar_dua down_' . $sub_satu->menu_id . '">';

                                                foreach ($data['sub_' . $rootid . '_' . $sub_satu->menu_id] as $sub_dua) {

                                                    if (isset($data['sub_' . $rootid . '_' . $sub_satu->menu_id . '_' . $sub_dua->menu_id])) {
                                                        echo '<div class="panel panel-default"><i class="ace-icon fa fa-plus bigger-120 blue"></i>
													<input type="checkbox" id="box_' . $sub_dua->menu_id . '" value="' . $sub_dua->menu_id . '" >
												    <a class="" data-toggle="collapse"  href="#sub_tiga_' . $sub_dua->id . '">' . $sub_dua->menu_name . ' <span class="arrow"></span></a>
													<div style="height: 0px;" id="sub_tiga_' . $sub_dua->menu_id . '" class="panel-collapse collapse akar_dua down_' . $sub_dua->menu_id . '">';

                                                        foreach ($data['sub_' . $rootid . '_' . $sub_satu->menu_id . '_' . $sub_dua->menu_id] as $sub_tiga) {
                                                            echo '<input style="margin-left: 15px;" type="checkbox" id="box_' . $sub_tiga->menu_id . '" value="' . $sub_tiga->menu_id . '" onclick="treedata(this)"> ' . $sub_tiga->menu_name . '<br>';
                                                            if (!empty($sub_tiga->menu_access)) {
                                                                echo '<div style="height: auto;" id="collapse_' . $sub_tiga->menu_id . '" class="panel-collapse akar_dua down_' . $sub_tiga->menu_id . ' in collapse">';
                                                                $arr_level = explode(",", $sub_tiga->access);
                                                                foreach ($arr_level as $arr_value) {
                                                                    $level_value = 'level_' . $sub_tiga->menu_id . '_' . $arr_value;
                                                                    echo '<input style="margin-left: 15px;" style="margin-left: 26px;" type="checkbox" id="box_' . $level_value . '" value="' . $level_value . '" onclick="treedata(this)"> ' . $arr_value . '<br>';
                                                                }
                                                                echo '</div>';
                                                            }
                                                        }
                                                        echo '</div></div>';
                                                    } else {
                                                        echo '<input style="margin-left: 15px;" type="checkbox" id="box_' . $sub_dua->menu_id . '" value="' . $sub_dua->menu_id . '" onclick="treedata(this)"> ' . $sub_dua->menu_name . '<br>';
                                                        if (!empty($sub_dua->menu_access)) {
                                                            echo '<div style="height: auto;" id="collapse_' . $sub_dua->menu_id . '" class="panel-collapse akar_dua down_' . $sub_dua->menu_id . ' in collapse">';
                                                            $arr_level = explode(",", $sub_dua->menu_access);
                                                            foreach ($arr_level as $arr_value) {
                                                                $level_value = 'level_' . $sub_dua->menu_id . '_' . $arr_value;
                                                                echo '<input style="margin-left: 15px;" type="checkbox" id="box_' . $level_value . '" value="' . $level_value . '" onclick="treedata(this)"> ' . $arr_value . '<br>';
                                                            }
                                                            echo '</div>';
                                                        }
                                                    }
                                                }
                                                echo '</div></div>';
                                            } else {
                                                echo '<input style="margin-left: 15px;" type="checkbox" id="box_' . $sub_satu->menu_id . '" value="' . $sub_satu->menu_id . '" onclick="treedata(this)" > ' . $sub_satu->menu_name . '<br>';
                                                if (!empty($sub_satu->menu_access)) {
                                                    $arr_level = explode(",", $sub_satu->menu_access);
                                                    echo '<div style="height: auto;" id="collapse_' . $sub_satu->menu_id . '" class="panel-collapse akar_dua down_' . $sub_satu->menu_id . ' in collapse">';
                                                    foreach ($arr_level as $arr_value) {
                                                        $level_value = 'level_' . $sub_satu->menu_id . '_' . $arr_value;
                                                        echo '<input style="margin-left: 15px;" type="checkbox"  id="box_' . $level_value . '"  value="' . $level_value . '" onclick="treedata(this)"> ' . $arr_value . '<br>';
                                                    }
                                                    echo '</div>';
                                                }
                                            }
                                        }
                                        echo ' </div>
                				</div>';
                                    } else {
                                        echo '<div class="panel panel-default" style="margin-left: 15px;"><input id="box_' . $rootid . '" type="checkbox" value="' . $rootid . '" onclick="treedata(this)" ><a class="" data-toggle="collapse"  href="#collapse_' . $rootid . '"> ' . $rootname . '</a></div>';
                                    }
                                }

                                ?>
                            </div>
                        </div>
                    </div>

                </div>
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
            <hr>
            <div class="clearfix">
                <div class="pull-right tableTools-container"></div>
            </div>
            <!-- div.dataTables_borderWrap -->
            <div class="dataTables_borderWrap">
                <table id="dynamic-table" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <!-- <th class="center">
                                                        <label class="pos-rel">
                                                            <input type="checkbox" class="ace" />
                                                            <span class="lbl"></span>
                                                        </label>
                                                    </th> -->
                            <th>Role ID</th>
                            <th><?= $this->lang->line('role_code') ?></th>
                            <th><?= $this->lang->line('role_name') ?></th>
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
<script src="<?= base_url() ?>assets/js/dataTables.buttons.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.flash.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.html5.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.print.min.js"></script>
<script src="<?= base_url() ?>assets/js/buttons.colVis.min.js"></script>
<script src="<?= base_url() ?>assets/js/dataTables.select.min.js"></script>
<script type="text/javascript">
    jQuery(function($) {
        //initiate dataTables plugin
        var myTable =
            $('#dynamic-table')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .DataTable({
                bAutoWidth: false,
                "aoColumns": [null, null, null,
                    {
                        "bSortable": false
                    }
                ],
                "aaSorting": [],


                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "<?= base_url("role/getList/"); ?>",
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

    function input_role_data() {
        if (jQuery('#role_name').val() === '' ||
            jQuery('#role_code').val() === ''
        ) {
            Toast.fire({
                icon: 'warning',
                title: '<?= $this->lang->line('warning_fill_value') ?>'
            })
            return;
        }

        $('button[type=submit]').prop('disabled', true);

        ngeklik();
        // loading("tab-content");
        var role_id = jQuery("#role_id").val();
        var role_code = jQuery("#role_code").val();
        var role_name = jQuery("#role_name").val();
        var role_allow_menu = jQuery("#imenu").html();
        jQuery.ajax({
            url: "<?= base_url() ?>role/save",
            dataType: "json",
            type: "POST",
            // beforeSend: function() {$('#loading').show();},	
            // complete: function() {$('#loading').hide();	},
            data: {
                role_id: role_id,
                role_code: role_code,
                role_name: role_name,
                role_allow_menu: role_allow_menu,
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

    function deleteData(e) {
        $(".dialog_confirm").dialog({
            dialogClass: "ui-dialog-green",
            height: 210,
            modal: true,
            buttons: [{
                "class": "btn red",
                text: "Delete",
                click: function() {
                    execDelete(e)
                }
            }, {
                "class": "btn",
                text: "Cancel",
                click: function() {
                    $(this).dialog("close")
                }
            }]
        })
    }

    function clearData() {
        jQuery("#role_id").val("");
        jQuery("#role_code").val("");
        jQuery("#role_name").val("");
        //	jQuery("#role").val("");
        jQuery("#imenu").html("")
        $('input:checkbox').removeAttr('checked');
    }

    function execDelete(e) {
        $.ajax({
            type: "post",
            data: {
                id: e
            },
            dataType: "json",
            url: "<?= base_url() ?>user/delete",
            success: function(e) {
                $(".dialog_confirm").dialog("close");
                clearData();
            }
        })
    }

    function editData(e) {
        $('input:checkbox').removeAttr('checked');
        jQuery.ajax({
            type: "post",
            data: {
                id: e
            },
            url: "<?= base_url() ?>role/getOne",
            dataType: "json",
            success: function(e) {
                jQuery("#role_id").val(e[0].role_id);
                jQuery("#role_name").val(e[0].role_name);
                jQuery("#role_code").val(e[0].role_code);
                //jQuery("#password").val(e[0].password);
                var t = e[0].role_allow_menu.split(",");
                for (i = 0; i < t.length; i++) {
                    $('#box_' + t[i]).prop('checked', true);
                    // $("#box_" + t[i]).attr("checked", "checked")
                }
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
            url: "<?= base_url() ?>role/cekpohon",
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

        var text = '<?= $this->lang->line('role_warning_delete') ?>'
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
                    url: '<?= base_url('role/deleteData/') ?>' + id,
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