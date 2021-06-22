<div class="main-content">
    <div class="main-content-inner">
        <div class="breadcrumbs ace-save-state" id="breadcrumbs">
            <ul class="breadcrumb">
                <li>
                    <i class="ace-icon fa fa-home home-icon"></i>
                    <a href="#"><?= $this->lang->line('home_title') ?></a>
                </li>
                <li>
                    <a href="#"><?= $this->lang->line('calc_bread') ?></a>
                </li>
                <li class="active"><?= $this->lang->line('calc_head_topsis') ?></li>
            </ul><!-- /.breadcrumb -->
        </div>

        <div class="page-content">
            <div class="page-header">
                <h1><?= $this->lang->line('calc_text_head_topsis') ?></h1>
            </div><!-- /.page-header -->
            <div class="pull-right">
                <!-- <span class="green middle bolder">Choose result page type: &nbsp;</span> -->
                <div class="btn-group">
                    <button class="btn btn-info" onclick="sync_alternatif()"><?= $this->lang->line('calc_syn_alt') ?><i class="icon-angle-down"></i></button>
                </div>
                <div class="btn-group">
                    <button class="btn btn-success" onclick="sync_alternatif_kriteria()"><?= $this->lang->line('calc_syn_alt_crit') ?><i class="icon-angle-down"></i></button>
                </div>
                <!-- <div class="btn-group">
                    <button class="btn dropdown-toggle" id="add-group" onclick="clearData()">Add Kriteria<i class="icon-angle-down"></i></button>
                </div> -->
                <div class="btn-group">
                    <button class="btn" onclick="calculate()"><?= $this->lang->line('calc_start_calc') ?><i class="icon-angle-down"></i></button>
                </div>
            </div>
            <div class="row">

            </div>
            <hr>
            <?php
            function tampiltabel($arr)
            {
                echo '<table class="table table-bordered table-highlight">';
                for ($i = 0; $i < count($arr); $i++) {
                    echo '<tr>';
                    for ($j = 0; $j < count($arr[$i]); $j++) {
                        echo '<td>' . $arr[$i][$j] . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
            }

            function tampilbaris($arr)
            {
                echo '<table class="table  table-bordered table-highlight">';
                echo '<tr>';
                for ($i = 0; $i < count($arr); $i++) {
                    echo '<td>' . $arr[$i] . '</td>';
                }
                echo "</tr>";
                echo '</table>';
            }

            function tampilkolom($arr)
            {
                echo '<table class="table table-bordered table-highlight">';
                for ($i = 0; $i < count($arr); $i++) {
                    echo '<tr>';
                    echo '<td>' . $arr[$i] . '</td>';
                    echo "</tr>";
                }
                echo '</table>';
            }

            $alternatif = array(); //array("Galaxy", "iPhone", "BB", "Lumia");

            // $queryalternatif = mysql_query("SELECT * FROM talternatif ORDER BY id_alternatif");
            // $i=0;
            // while ($dataalternatif = mysql_fetch_array($queryalternatif))
            // {
            // 	$alternatif[$i] = $dataalternatif['nama_alternatif'];
            // 	$i++;
            // }

            $sql = "SELECT * FROM topsis_alternatif ORDER BY topsis_alternatif_id";
            $query = $this->db->query($sql);
            if ($query->num_rows() > 0) {
                $i = 0;

                foreach ($query->result_array() as $dataalternatif) {
                    $alternatif[$i] = $dataalternatif['username'];
                    $i++;
                }
            }

            $kriteria = array(); //array("Harga", "Kualitas", "Fitur", "Populer", "Purna Jual", "Keawetan");

            $costbenefit = array(); //array("cost", "benefit", "benefit", "benefit", "benefit", "benefit");

            $kepentingan = array(); //array(4, 5, 4, 3, 3, 2);

            $querykriteria = "SELECT * FROM topsis_kriteria ORDER BY topsis_kriteria_id";
            $query = $this->db->query($querykriteria);
            if ($query->num_rows() > 0) {
                $i = 0;
                foreach ($query->result_array() as $datakriteria) {
                    $kriteria[$i] = $datakriteria['nama_kriteria'];
                    $costbenefit[$i] = $datakriteria['costBenefit'];
                    $kepentingan[$i] = $datakriteria['kepentingan'];
                    $i++;
                }
            }
            // $i=0;
            // while ($datakriteria = mysql_fetch_array($querykriteria))
            // {
            // 	$kriteria[$i] = $datakriteria['nama_kriteria'];
            // 	$costbenefit[$i] = $datakriteria['costbenefit'];
            // 	$kepentingan[$i] = $datakriteria['kepentingan'];
            // 	$i++;
            // }

            $alternatifkriteria = array();
            /* array(
							array(3500, 70, 10, 80, 3000, 36),				
							array(4500, 90, 10, 60, 2500, 48),					                           
							array(4000, 80, 9, 90, 2000, 48),												                            
							array(4000, 70, 8, 50, 1500, 60)
						  ); */

            $queryalternatif = "SELECT * FROM topsis_alternatif ORDER BY topsis_alternatif_id";
            $query1 = $this->db->query($queryalternatif);
            $i = 0;
            foreach ($query1->result_array() as $dataalternatif) {
                // while ($dataalternatif = mysql_fetch_array($queryalternatif)){
                $querykriteria = "SELECT * FROM topsis_kriteria ORDER BY topsis_kriteria_id";
                $query2 = $this->db->query($querykriteria);
                $j = 0;
                foreach ($query2->result_array() as $datakriteria) {
                    // while ($datakriteria = mysql_fetch_array($querykriteria)){
                    $queryalternatifkriteria = "SELECT * FROM topsis_alternatif_kriteria WHERE topsis_alternatif_id = " . $dataalternatif["topsis_alternatif_id"] . " AND topsis_kriteria_id = " . $datakriteria["topsis_kriteria_id"] . "";
                    $query3 = $this->db->query($queryalternatifkriteria);
                    // $dataalternatifkriteria = $query3->result_array();
                    foreach ($query3->result_array() as $dataalternatifkriteria) {
                        $alternatifkriteria[$i][$j] = $dataalternatifkriteria['nilai'];
                        $j++;
                    }
                }
                $i++;
            }

            $pembagi = array();

            for ($i = 0; $i < count($kriteria); $i++) {
                $pembagi[$i] = 0;
                for ($j = 0; $j < count($alternatif); $j++) {
                    $pembagi[$i] = $pembagi[$i] + ($alternatifkriteria[$j][$i] * $alternatifkriteria[$j][$i]);
                }
                $pembagi[$i] = sqrt($pembagi[$i]);
            }

            $normalisasi = array();

            for ($i = 0; $i < count($alternatif); $i++) {
                for ($j = 0; $j < count($kriteria); $j++) {
                    if ($pembagi[$j] == 0) {
                        $normalisasi[$i][$j] = 0;
                    } else {
                        $normalisasi[$i][$j] = $alternatifkriteria[$i][$j] / $pembagi[$j];
                    }
                }
            }
            $terbobot = array();

            for ($i = 0; $i < count($alternatif); $i++) {
                for ($j = 0; $j < count($kriteria); $j++) {
                    $terbobot[$i][$j] = $normalisasi[$i][$j] * $kepentingan[$j];
                }
            }

            $aplus = array();

            for ($i = 0; $i < count($kriteria); $i++) {
                if ($costbenefit[$i] == 'Cost') {
                    for ($j = 0; $j < count($alternatif); $j++) {
                        if ($j == 0) {
                            $aplus[$i] = $terbobot[$j][$i];
                        } else {
                            if ($aplus[$i] > $terbobot[$j][$i]) {
                                $aplus[$i] = $terbobot[$j][$i];
                            }
                        }
                    }
                } else {
                    for ($j = 0; $j < count($alternatif); $j++) {
                        if ($j == 0) {
                            $aplus[$i] = $terbobot[$j][$i];
                        } else {
                            if ($aplus[$i] < $terbobot[$j][$i]) {
                                $aplus[$i] = $terbobot[$j][$i];
                            }
                        }
                    }
                }
            }

            $amin = array();

            for ($i = 0; $i < count($kriteria); $i++) {
                if ($costbenefit[$i] == 'Cost') {
                    for ($j = 0; $j < count($alternatif); $j++) {
                        if ($j == 0) {
                            $amin[$i] = $terbobot[$j][$i];
                        } else {
                            if ($amin[$i] < $terbobot[$j][$i]) {
                                $amin[$i] = $terbobot[$j][$i];
                            }
                        }
                    }
                } else {
                    for ($j = 0; $j < count($alternatif); $j++) {
                        if ($j == 0) {
                            $amin[$i] = $terbobot[$j][$i];
                        } else {
                            if ($amin[$i] > $terbobot[$j][$i]) {
                                $amin[$i] = $terbobot[$j][$i];
                            }
                        }
                    }
                }
            }

            $dplus = array();

            for ($i = 0; $i < count($alternatif); $i++) {
                $dplus[$i] = 0;
                for ($j = 0; $j < count($kriteria); $j++) {
                    $dplus[$i] = $dplus[$i] + (($aplus[$j] - $terbobot[$i][$j]) * ($aplus[$j] - $terbobot[$i][$j]));
                }
                $dplus[$i] = sqrt($dplus[$i]);
            }

            $dmin = array();

            for ($i = 0; $i < count($alternatif); $i++) {
                $dmin[$i] = 0;
                for ($j = 0; $j < count($kriteria); $j++) {
                    $dmin[$i] = $dmin[$i] + (($terbobot[$i][$j] - $amin[$j]) * ($terbobot[$i][$j] - $amin[$j]));
                }
                $dmin[$i] = sqrt($dmin[$i]);
            }


            $hasil = array();
            $hasilTable = array();

            for ($i = 0; $i < count($alternatif); $i++) {
                $j = 0;
                if (($dmin[$i] + $dplus[$i]) == 0) {
                    $hasil[$i] = 0;
                    $j++;
                    $hasilTable[$i][$j] = $alternatif[$i];
                } else {
                    $hasil[$i] = $dmin[$i] / ($dmin[$i] + $dplus[$i]);
                    $hasilTable[$i][$j] = $alternatif[$i];

                    $j++;
                    $hasilTable[$i][$j] = $dmin[$i] / ($dmin[$i] + $dplus[$i]);
                }
            }

            $alternatifrangking = array();
            $hasilrangking = array();
            $hasilrangkingTabel = array();

            for ($i = 0; $i < count($alternatif); $i++) {
                $hasilrangking[$i] = $hasil[$i];
                $alternatifrangking[$i] = $alternatif[$i];
            }

            for ($i = 0; $i < count($alternatif); $i++) {
                for ($j = $i; $j < count($alternatif); $j++) {
                    if ($hasilrangking[$j] > $hasilrangking[$i]) {
                        $tmphasil = $hasilrangking[$i];
                        $tmpalternatif = $alternatifrangking[$i];
                        $hasilrangking[$i] = $hasilrangking[$j];
                        $alternatifrangking[$i] = $alternatifrangking[$j];
                        $hasilrangking[$j] = $tmphasil;
                        $alternatifrangking[$j] = $tmpalternatif;
                    }
                }
            }

            $hasilrangkingTable = $hasilTable;
            //Sorting Multiple Array Dimension By Key Value
            array_multisort(array_map(function ($element) {
                return $element[1];
            }, $hasilrangkingTable), SORT_DESC, $hasilrangkingTable);
            ?>

            <div id="perhitungan" style="display: none;">
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_alt') ?> :
                </h4>
                <?php tampilbaris($alternatif); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_crit') ?> :
                </h4>
                <?php tampilbaris($kriteria); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_cost_benefit') ?> :
                </h4>
                <?php tampilbaris($costbenefit); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_weight') ?> :
                </h4>
                <?php tampilbaris($kepentingan); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_alt_crit') ?> :
                </h4>
                <?php tampiltabel($alternatifkriteria); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_divider') ?> :
                </h4>
                <?php tampilbaris($pembagi); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_normalization') ?>:
                </h4>
                <?php tampiltabel($normalisasi); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_weighted') ?>:
                </h4>

                <?php tampiltabel($terbobot); ?>
                <br />
                <h4 class="heading">
                    A+ :
                </h4>
                <?php tampilbaris($aplus); ?>
                <br />
                <h4 class="heading">
                    A- :
                </h4>
                <?php tampilbaris($amin); ?>
                <br />
                <h4 class="heading">
                    D+:
                </h4>
                <?php tampilkolom($dplus); ?>
                <br />
                <h4 class="heading">
                    D-:
                </h4>
                <?php tampilkolom($dmin); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_res') ?> :
                </h4>
                <!-- <?php tampilkolom($hasil); ?> -->
                <?php tampiltabel($hasilTable); ?>
                <br />
                <h4 class="heading">
                    <?= $this->lang->line('calc_text_res_rank') ?> :
                </h4>
                <!-- <?php tampilkolom($hasilrangking); ?> -->
                <?php tampiltabel($hasilrangkingTable); ?>
                <br />
                <!-- <h4 class="heading">
                    Alternatif Ranking :
                </h4>
                <?php tampilkolom($alternatifrangking); ?>
                <br /> -->
                <?= $this->lang->line('calc_text_best_alt') ?> : <h4 class="heading"> <span class="label label-primary"> <?php echo $alternatifrangking[0]; ?></span></h4> <?= $this->lang->line('calc_text_higest_score') ?> : <h4 class="heading"> <span class="label label-success"> <?php echo $hasilrangking[0]; ?></span></h4><br />
                <a class="btn btn-info" href="javascript:;" onClick="(function(){
    $('#perhitungan').css('display','none');
})();">Close</a>
            </div>
            <!-- <br /> -->
            <!-- <input type="button" class="btn btn-success" value="Perhitungan" onclick="document.getElementById('perhitungan').style.display='block';"/> -->
            <!-- <br />
<br /> -->
            <!-- <hr>             -->
            <!-- div.dataTables_borderWrap -->
            <h1><?= $this->lang->line('calc_t_result') ?></h1>
            <div class="dataTables_borderWrap">

                <table id="topsis_hasil" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?= $this->lang->line('calc_text_username') ?></th>
                            <th><?= $this->lang->line('calc_text_rank') ?></th>
                            <th><?= $this->lang->line('calc_text_calc_res') ?></th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
            <hr>
            <h1><?= $this->lang->line('calc_t_alternative') ?></h1>
            <div class="dataTables_borderWrap">

                <table id="topsis_alternatif" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?= $this->lang->line('calc_text_userid') ?></th>
                            <th><?= $this->lang->line('calc_text_username') ?></th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
            <hr>
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
                                <input type="hidden" id="kriteriaId" name="kriteriaId" />
                                <tr>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;"><?= $this->lang->line('calc_text_crit_name') ?></td>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;"><input type="text" placeholder="Ex: Daily" id="kriteria" name="kriteria" /></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;"><?= $this->lang->line('calc_text_weight') ?></td>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;"><input type="number" placeholder="Max: 100" max=100 id="kepentingan" name="kepentingan" /></td>
                                </tr>
                                <tr>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;"><?= $this->lang->line('calc_text_cost_benefit') ?></td>
                                    <td style="padding-left: 20px;  padding-bottom: 5px;">
                                        <select name="costBenefit" id="costBenefit">
                                            <option value="">-- Select --</option>
                                            <option value="Benefit"> Benefit</option>
                                            <option value="Cost">Cost</option>
                                        </select>
                                    </td>
                                </tr>
                                <tr>
                                    <td></td>
                                    <td>
                                        <button name="" id="" class="btn blue" onclick="inputKriteria()">Submit</button>&nbsp;
                                        <button name="" id="" class="btn blue" onclick="remove_toggle('toggle-add-group'); clearData();">Cancel</button>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>

                </div>
                <!-- PAGE CONTENT ENDS -->
            </div><!-- /.col -->
            <h1><?= $this->lang->line('calc_t_criteria') ?></h1>
            <div class="dataTables_borderWrap">

                <table id="topsis_kriteria" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?= $this->lang->line('calc_text_crit_name') ?></th>
                            <th><?= $this->lang->line('calc_text_weight') ?></th>
                            <th><?= $this->lang->line('calc_text_cost_benefit') ?></th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>

                    </tbody>
                </table>
            </div>
            <hr>
            <h1><?= $this->lang->line('calc_t_alt_crit') ?></h1>
            <div class="dataTables_borderWrap">

                <table id="topsis_alt_krit" class="table table-striped table-bordered table-hover">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th><?= $this->lang->line('calc_text_alt') ?></th>
                            <th><?= $this->lang->line('calc_text_crit') ?></th>
                            <th><?= $this->lang->line('calc_text_score') ?></th>
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
    function calculate() {
        sync_alternatif()
        sync_alternatif_kriteria()
        syn_hasil()
    }

    function syn_hasil() {
        $.ajax({
            url: '<?= base_url('topsis/calculate/') ?>',
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
                    $('#topsis_hasil').DataTable().ajax.reload(null, false);
                    $('#perhitungan').css('display', 'block');
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: response.message
                    })

                }

            },
            error: function(xhr, status, error) {
                //console.log(xhr);
                Toast.fire({
                    icon: 'error',
                    title: error
                })
            },
            timeout: 300000 // sets timeout to 5 minutes
        });
    }

    function sync_alternatif() {
        $.ajax({
            url: '<?= base_url('topsis/syncAlt/') ?>',
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
                    $('#topsis_alternatif').DataTable().ajax.reload(null, false);
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: response.message
                    })

                }

            },
            error: function(xhr, status, error) {
                //console.log(xhr);
                Toast.fire({
                    icon: 'error',
                    title: error
                })
            },
            timeout: 300000 // sets timeout to 5 minutes
        });
    }

    function sync_alternatif_kriteria() {
        $.ajax({
            url: '<?= base_url('topsis/syncAltKriteria/') ?>',
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
                    $('#topsis_alt_krit').DataTable().ajax.reload(null, false);
                } else {
                    Toast.fire({
                        icon: 'warning',
                        title: response.message
                    })

                }

            },
            error: function(xhr, status, error) {
                //console.log(xhr);
                Toast.fire({
                    icon: 'error',
                    title: error
                })
            },
            timeout: 300000 // sets timeout to 5 minutes
        });
    }
</script>
<script type="text/javascript">
    jQuery(function($) {
        //initiate dataTables plugin
        var topsis_alternatif =
            $('#topsis_alternatif')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .DataTable({
                bAutoWidth: false,
                "aoColumns": [{
                        "bSortable": false
                    },
                    null, null
                ],
                "aaSorting": [],


                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "<?= base_url("topsis/getAlternatif/"); ?>",
                    type: "POST",
                    data: function(d) {
                        // d.id_region = $('#region').val();
                    }
                },
                "initComplete": function(settings, json) {
                    $('#topsis_alternatif_filter input').unbind();
                    $('#topsis_alternatif_filter input').bind('keyup', function(e) {
                        if (e.keyCode == 13) {
                            topsis_alternatif.search(this.value).draw();
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

        var topsis_kriteria =
            $('#topsis_kriteria')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .DataTable({
                bAutoWidth: false,
                "aoColumns": [{
                        "bSortable": false
                    },
                    null, null, null,
                    {
                        "bSortable": false
                    },
                ],
                "aaSorting": [],


                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "<?= base_url("topsis/getKriteria/"); ?>",
                    type: "POST",
                    data: function(d) {}
                },
                "initComplete": function(settings, json) {
                    $('#topsis_kriteria_filter input').unbind();
                    $('#topsis_kriteria_filter input').bind('keyup', function(e) {
                        if (e.keyCode == 13) {
                            topsis_kriteria.search(this.value).draw();
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

        var topsis_alt_krit =
            $('#topsis_alt_krit')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .DataTable({
                bAutoWidth: false,
                "aoColumns": [{
                        "bSortable": false
                    },
                    null, null, null
                ],
                "aaSorting": [],


                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "<?= base_url("topsis/getAltKriteria/"); ?>",
                    type: "POST",
                    data: function(d) {}
                },
                "initComplete": function(settings, json) {
                    $('#topsis_alt_krit_filter input').unbind();
                    $('#topsis_alt_krit_filter input').bind('keyup', function(e) {
                        if (e.keyCode == 13) {
                            topsis_alt_krit.search(this.value).draw();
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

        var topsis_hasil =
            $('#topsis_hasil')
            //.wrap("<div class='dataTables_borderWrap' />")   //if you are applying horizontal scrolling (sScrollX)
            .DataTable({
                bAutoWidth: false,
                "aoColumns": [{
                        "bSortable": false
                    },
                    null, null, null
                ],
                "aaSorting": [],


                "bProcessing": true,
                "bServerSide": true,
                "ajax": {
                    url: "<?= base_url("topsis/getHasil/"); ?>",
                    type: "POST",
                    data: function(d) {}
                },
                "initComplete": function(settings, json) {
                    $('#topsis_hasil_filter input').unbind();
                    $('#topsis_hasil_filter input').bind('keyup', function(e) {
                        if (e.keyCode == 13) {
                            topsis_hasil.search(this.value).draw();
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

        new $.fn.dataTable.Buttons(topsis_alternatif, {
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
        topsis_alternatif.buttons().container().appendTo($('.tableTools-container'));

        //style the message box
        var defaultCopyAction = topsis_alternatif.button(1).action();
        topsis_alternatif.button(1).action(function(e, dt, button, config) {
            defaultCopyAction(e, dt, button, config);
            $('.dt-button-info').addClass('gritter-item-wrapper gritter-info gritter-center white');
        });


        var defaultColvisAction = topsis_alternatif.button(0).action();
        topsis_alternatif.button(0).action(function(e, dt, button, config) {

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





        topsis_alternatif.on('select', function(e, dt, type, index) {
            if (type === 'row') {
                $(topsis_alternatif.row(index).node()).find('input:checkbox').prop('checked', true);
            }
        });
        topsis_alternatif.on('deselect', function(e, dt, type, index) {
            if (type === 'row') {
                $(topsis_alternatif.row(index).node()).find('input:checkbox').prop('checked', false);
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
                if (th_checked) topsis_alternatif.row(row).select();
                else topsis_alternatif.row(row).deselect();
            });
        });

        //select/deselect a row when the checkbox is checked/unchecked
        $('#dynamic-table').on('click', 'td input[type=checkbox]', function() {
            var row = $(this).closest('tr').get(0);
            if (this.checked) topsis_alternatif.row(row).deselect();
            else topsis_alternatif.row(row).select();
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

    function inputKriteria() {
        if (jQuery('#kriteria').val() === '' || jQuery('#kepntingan').val() === '' || jQuery('#costBenefit').val() === '') {
            Toast.fire({
                icon: 'warning',
                title: 'Lengkapi Data'
            })
            return;
        }

        $('button[type=submit]').prop('disabled', true);
        // loading("tab-content");
        var kriteriaId = jQuery("#kriteriaId").val();
        var kriteria = jQuery("#kriteria").val();
        var kepentingan = jQuery("#kepentingan").val();
        var costBenefit = jQuery("#costBenefit").val();
        jQuery.ajax({
            url: "<?= base_url() ?>topsis/addKriteria",
            dataType: "json",
            type: "POST",
            // beforeSend: function() {$('#loading').show();},	
            // complete: function() {$('#loading').hide();	},
            data: {
                kriteriaId: kriteriaId,
                kriteria: kriteria,
                kepentingan: kepentingan,
                costBenefit: costBenefit,
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
                    $('#topsis_kriteria').DataTable().ajax.reload(null, false);
                } else {
                    alert(e)
                }
            }
        })
    }


    function clearData() {
        jQuery("#kriteriaId").val("");
        jQuery("#kriteria").val("");
        jQuery("#kepentingan").val("");
        jQuery("#costBenefit").val("");
        //	jQuery("#designation").val("");
    }


    function editData(e) {
        $('input:checkbox').removeAttr('checked');
        jQuery.ajax({
            type: "post",
            data: {
                id: e
            },
            url: "<?= base_url() ?>topsis/getOneKriteria",
            dataType: "json",
            success: function(e) {
                jQuery("#kriteriaId").val(e[0].topsis_kriteria_id);
                jQuery("#kriteria").val(e[0].nama_kriteria);
                jQuery("#kepentingan").val(e[0].kepentingan);
                jQuery("#costBenefit").val(e[0].costBenefit);
            }
        });
        jQuery(".toggle-add-group").show("slow")
    }
</script>


<script type="text/javascript">
    var type = 'Normal';
    jQuery(document).ready(function() {

        //LOAD FOR INPUT/EDIT
        jQuery('#add-group').click(function() {
            clearData();
            jQuery('.toggle-add-group').toggle('slow');
            return false;
        });
    });
</script>


<script>
</script>