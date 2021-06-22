<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Topsis extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        //Do your magic here
        $session_data = $this->session->userdata('logged_in');
        if (empty($session_data)) {
            redirect('auth/login', 'refresh');
        }
        $this->load->model('users_model', 'users');
        $this->load->model('topsis_model', 'topsis');
        $this->load->model('settings_model', 'setting');
        $this->system = $this->setting->getSystemSettings();
        $this->sessionUserDetail = $this->users->sessionUserDetail();
        $this->menu_body     = $this->Menu_model->getmenu($session_data['user_id'], $session_data['username']);


        // Menu Access MeetType
        $urlname    = strtolower($this->router->fetch_class());
        $menu_id       = $this->Menu_model->idMenu($urlname);
        $user_allow = $this->Menu_model->UserAllow($session_data['role_id']);
        $user_allow_menu = explode(",", $user_allow[0]['role_allow_menu']);
        $this->data['menu_allow'] = '';
        $this->data['user_allow_menu'] = $user_allow_menu;
        if (@in_array($menu_id[0]['menu_id'], $user_allow_menu)) {
            $this->data['menu_allow'] = 'level_' . $menu_id[0]['menu_id'];
        } else {
            redirect('home', 'refresh');
        }
    }

    public function index()
    {
        $data = array(
            'title' => $this->lang->line('calc_head_topsis'),
            'menu_body' => $this->menu_body,
            'usDetail' => $this->sessionUserDetail,
            'system' => $this->system
        );
        $this->template->load('default', 'topsis/index', $data);
    }

    public function getAlternatif()
    {
        $cond = array();
        $table = "topsis_alternatif";
        $orderSearch = array(
            'user_id',
            'user_id',
            'username'
        );
        $list = $this->topsis->getList($cond, $table, $orderSearch);
        // print_r($this->db->last_query());die;
        // print_r($list);die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $chkBox;
            $row[] = $no;
            $row[] = $field->user_id;
            $row[] = $field->username;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->topsis->count_new($cond, $table, $orderSearch),
            "recordsFiltered" => $this->topsis->count_filtered_new($cond, $table, $orderSearch),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    public function getKriteria()
    {
        $cond = array();
        $table = "topsis_kriteria";
        $orderSearch = array(
            'topsis_kriteria_id',
            'nama_kriteria',
            'kepentingan',
            'costBenefit',
        );
        $list = $this->topsis->getList($cond, $table, $orderSearch);
        // print_r($this->db->last_query());die;
        // print_r($list);die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $chkBox;
            $row[] = $no;
            $row[] = $field->nama_kriteria;
            $row[] = $field->kepentingan;
            $row[] = $field->costBenefit;
            $row[] = '<a class="info" data-rel="tooltip" data-placement="bottom" href="javascript:;" onclick="editData(\'' . $field->topsis_kriteria_id . '\')" title="' . $this->lang->line('calc_edit_crit') . '">
                            <i class="ace-icon fa fa-edit bigger-130"></i>
                        </a>';
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->topsis->count_new($cond, $table, $orderSearch),
            "recordsFiltered" => $this->topsis->count_filtered_new($cond, $table, $orderSearch),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    function syncAlt(){
        $altUser = $this->topsis->getAltUser();
        $dataAlt = array();
        foreach ($altUser as $key => $user){
            $dataAlt[$key]['user_id'] = $user['user_id'];
            $dataAlt[$key]['username'] = $user['user_username'];
        }
        $this->db->trans_begin();
        $this->topsis->syncAlt($dataAlt);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $err = $this->db->error();
            $res = array(
                'is_success' => false,
                'message' =>  $err,
            );
        } else {
            $this->db->trans_commit();
            $res = array(
                'is_success' => true,
                'message' =>  $this->lang->line('calc_succecc_sync_alt'),
            );
        }
        echo json_encode($res);
    }

    function addKriteria(){
        $kriteriaId = $this->input->post('kriteriaId');
        $kriteria = $this->input->post('kriteria');
        $kepentingan = $this->input->post('kepentingan');
        $costBenefit = $this->input->post('costBenefit');
        $updateKriteria = null;
        $addKriteria = null;

        $data = array(
            'nama_kriteria' => $kriteria,
            'kepentingan' => $kepentingan, 
            'costBenefit' => $costBenefit, 
        );

        if($kriteriaId){
            $cond = array(
                'topsis_kriteria_id' => $kriteriaId
            );
            $updateKriteria = $this->topsis->updateKriteria($data, $cond);
            $res = array(
                'is_success' => true,
                'message' =>  $this->lang->line('calc_succecc_edit_crit'),
            );
        } else {
            $addKriteria = $this->topsis->addKriteria($data);
            $res = array(
                'is_success' => true,
                'message' =>  $this->lang->line('calc_succecc_add_crit'),
            );
        }

        echo json_encode($res);
    }

    function getOneKriteria(){
        $kriteriaId = $this->input->post('id');
        $data = $this->topsis->getOneKriteria($kriteriaId);
        echo json_encode($data);
    }

    function syncAltKriteria(){
        $dataAlternatif = $this->topsis->getAlternatif();
        $dataKriteria = $this->topsis->getKriteria();
        $cUploadDocByAlt = $this->topsis->cUploadDocByAlt();
        $cForumByAlt = $this->topsis->cForumByAlt();
        $cForumReplyByAlt = $this->topsis->cForumReplyByAlt();
        $i = 0;
        $dataAltKrit = array();
        foreach ($dataKriteria as $krit) {
            // $dataAltKrit[$j]['topsis_kriteria_id'] = $krit['topsis_kriteria_id'];
            foreach ($dataAlternatif as $alt) {
                $dataAltKrit[$i]['topsis_kriteria_id'] = $krit['topsis_kriteria_id'];
                $dataAltKrit[$i]['topsis_alternatif_id'] = $alt['topsis_alternatif_id'];
                $i++;
            }
        }
        foreach($dataAltKrit as $key => $data){
            foreach($cUploadDocByAlt as $cUpload){
                if(($cUpload['user_id']==$data['topsis_alternatif_id']) && ($data['topsis_kriteria_id']==1)){
                    $dataAltKrit[$key]['nilai'] = $cUpload['nilai'];
                } 
            }
            foreach ($cForumByAlt as $cForum) {
                if (($cForum['user_id'] == $data['topsis_alternatif_id']) && ($data['topsis_kriteria_id'] == 2)) {
                    $dataAltKrit[$key]['nilai'] = $cForum['nilai'];
                } 
            }
            foreach ($cForumReplyByAlt as $cReply) {
                if (($cReply['user_id'] == $data['topsis_alternatif_id']) && ($data['topsis_kriteria_id'] == 3)) {
                    $dataAltKrit[$key]['nilai'] = $cReply['nilai'];
                } 
            }
        }

        foreach ($dataAltKrit as $key => $val){
            if(array_key_exists('nilai', $val)){
                $dataAltKrit[$key]['nilai'] = $val['nilai'];
            } else {
                $dataAltKrit[$key]['nilai'] = 0;
            }
            $dataAltKrit[$key]['topsis_kriteria_id'] = $val['topsis_kriteria_id'];
            $dataAltKrit[$key]['topsis_alternatif_id'] = $val['topsis_alternatif_id'];
        }
        $this->db->trans_begin();
        $this->topsis->inputAltKrit($dataAltKrit);
        if ($this->db->trans_status() === FALSE) {
            $this->db->trans_rollback();
            $err = $this->db->error();
            $res = array(
                'is_success' => false,
                'message' =>  $err,
            );
        } else {
            $this->db->trans_commit();
            $res = array(
                'is_success' => true,
                'message' =>  $this->lang->line('calc_succecc_sync_alt_crit'),
            );
        }
        echo json_encode($res);
    }

    function getAltKriteria(){
        $cond = array();
        $table = "topsis_alternatif_kriteria tak";
        $orderSearch = array(
            'tak.topsis_alt_krit_id',
            'ta.username',
            'tk.nama_kriteria',
            'tak.nilai',
        );
        $list = $this->topsis->getList($cond, $table, $orderSearch);
        // print_r($this->db->last_query());die;
        // print_r($list);die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $chkBox;
            $row[] = $no;
            $row[] = $field->username;
            $row[] = $field->nama_kriteria;
            $row[] = $field->nilai;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->topsis->count_new($cond, $table, $orderSearch),
            "recordsFiltered" => $this->topsis->count_filtered_new($cond, $table, $orderSearch),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }

    public function calculate()
    {
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
                $alternatif[$i]['user_id'] = $dataalternatif['user_id'];
                $alternatif[$i]['username'] = $dataalternatif['username'];
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
                if($pembagi[$j]==0){
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

        for ($i = 0; $i < count($alternatif); $i++) {
            if(($dmin[$i] + $dplus[$i])==0){
                $hasil[$i] = 0;
            } else {
                $hasil[$i] = $dmin[$i] / ($dmin[$i] + $dplus[$i]);
            }
            // $hasil[$i]['username'] = $alternatif[$i]['username'];
        }
        // print_r($hasil);die;
        $alternatifrangking = array();
        $hasilrangking = array();

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
        $this->db->query("TRUNCATE TABLE topsis_hasil");
        $hasil = array();
        for ($i = 0; $i < count($hasilrangking); $i++) {
            $rank = $i + 1;
            $user_id = $alternatifrangking[$i]['user_id'];
            $nilai = $hasilrangking[$i];
            
            $hasil[$i]['ranking'] = $rank; 
            $hasil[$i]['user_id'] = $user_id; 
            $hasil[$i]['hasil'] = $nilai; 
        }
        if($this->db->insert_batch("topsis_hasil", $hasil)){
            $res = array(
                'is_success' => true,
                'message' =>  'Perhitungan Berhasil',
            );
        }else{
            $err = $this->db->error();
            $res = array(
                'is_success' => false,
                'message' =>  $err,
            );
        }
        echo json_encode($res);
    }

    function getHasil(){
        $cond = array();
        $table = "topsis_hasil th";
        $orderSearch = array(
            'th.topsis_hasil_id',
            'ta.username',
            'th.ranking',
            'th.hasil',
        );
        $list = $this->topsis->getList($cond, $table, $orderSearch);
        // print_r($this->db->last_query());die;
        // print_r($list);die;
        $data = array();
        $no = $_POST['start'];
        foreach ($list as $field) {
            $no++;
            $row = array();
            // $row[] = $chkBox;
            $row[] = $no;
            $row[] = $field->username;
            $row[] = $field->ranking;
            $row[] = $field->hasil;
            $data[] = $row;
        }

        $output = array(
            "draw"            => $_POST['draw'],
            "recordsTotal"    => $this->topsis->count_new($cond, $table, $orderSearch),
            "recordsFiltered" => $this->topsis->count_filtered_new($cond, $table, $orderSearch),
            "data"            => $data,
        );
        //output dalam format JSON

        echo json_encode($output);
    }
}
