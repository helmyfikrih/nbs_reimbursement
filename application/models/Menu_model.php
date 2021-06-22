<?php

class Menu_model extends CI_Model
{
	function getmenu($user_id, $username)
	{

		$uri = $this->uri->segment(1);
		if (!$uri) {
			$uri = 'home';
		}
		$isparentActive = "";
		if (empty($user_id) or empty($username)) {
			return FALSE;
		}
		$sqlmenu0 		= "select role_id from m_user where user_id = " . $user_id . " and user_username = '" . $username . "'";

		$result0		= $this->db->query($sqlmenu0) or die('died 1');
		foreach ($result0->result_array() as $line0) {
			// $allow_menu = $line0['allow_menu'];
			$role_id = $line0['role_id'];
		}
		// die($role_id);
		$sqlmenu 		= "select role_allow_menu from m_role where role_id = $role_id";
		$result		= $this->db->query($sqlmenu) or die('died 1');
		foreach ($result->result_array() as $line0) {
			$allow_menu = $line0['role_allow_menu'];
		}

		if (strtolower($allow_menu) == 'all') {
			$in_menu = '';
		} else {
			$menu_no 	= str_replace(',', '","', $allow_menu);
			$in_menu	= 'and menu_id in ("' . $menu_no . '")';
		}

		// if ( strtolower($role_id) == '1' ) {
		// 	$in_menu = '';
		// 	$like_menu = '';
		// } else {
		// 	// $menu_no 	= str_replace(',',',',$allow_menu);
		// 	// $in_menu	= 'and id in ('.$menu_no.')';
		// 	$like_menu	= 'and menu_role like (\'%'.$role_id.'%\')';
		// }

		// $menu_no 	= str_replace(',','","',$allow_menu);
		$body		= '';
		$sqlmenu 	= 'select menu_id, menu_url, menu_name, menu_nama, menu_parent, menu_child, menu_icon from m_menu where menu_status = 1 and menu_parent = 0 ' . $in_menu . ' order by menu_sort asc';
		// die($sqlmenu);
		$result		= $this->db->query($sqlmenu) or die('died 2');
		// print_r($result->result_array());die;
		// echo "getMenu"; die;
		// print_r($result->result_array()); die;
		foreach ($result->result_array() as $line) {
			// die($line['child']);
			if ($line['menu_child'] == 0) {
				$classActive = '';
				if ($uri == $line['menu_url']) {
					$classActive = 'active';
				}
				$body .= '<li class="' . $classActive	. '"><a href="' . base_url() . $line['menu_url'] . '"><i class="menu-icon ' . $line['menu_icon'] . '"></i><span class="menu-text">' . ucwords($this->session->userdata('logged_in')['language'] == 'indonesia' ? $line['menu_nama'] : $line['menu_name']) . '</span></a><b class="arrow"></b></li>';
				$classActive = '';
			} else if ($uri != 'profiles') {

				$sqlGetParentFromUri2 = "select * from m_menu where menu_url like '%" . $uri . "%'";
				$prentId2 = $this->db->query($sqlGetParentFromUri2)->row();
				$sqlGetParentFromUri = "select * from m_menu where menu_id = " . $prentId2->menu_parent;
				$prentId = $this->db->query($sqlGetParentFromUri)->row();
				// print_r($sqlGetParentFromUri);
				// print_r($line['id'].'_');
				if (isset($prentId)) {
					if ($prentId->menu_parent == $line['menu_id']) {
						// print_r($prentId->parent. '_');
						$classActive = 'active';
					}
					if ($prentId->menu_id == $line['menu_id']) {
						// print_r($prentId->parent. '_');
						$classActive = 'active';
					}

					$sqlMenuParentActive = "SELECT * FROM m_menu WHERE menu_url = '$uri' AND menu_status=1";
					$parentActive = $this->db->query($sqlMenuParentActive)->result_array() or die('died 66');
					$idParentActive = $parentActive[0]['menu_parent'];

					$sqlMenuParentActive2 = "SELECT * FROM m_menu WHERE menu_id = '$idParentActive' AND menu_status=1";
					$parentActive2 = $this->db->query($sqlMenuParentActive2)->result_array() or die('died 66');
					$idParentActive2 = $parentActive2[0]['menu_parent'];
					// print_r($line);
					if (($idParentActive == $line['menu_id']) || ($idParentActive2 == $line['menu_id'])) {
						$isparentActive = "active open";
					}
				}

				$body .= '<li class="' . $isparentActive . '">
						<a href="#" class="dropdown-toggle"><i class="menu-icon ' . $line['menu_icon'] . '"></i> <span class="menu_text ">' . ucwords($this->session->userdata('logged_in')['language'] == 'indonesia' ? $line['menu_nama'] : $line['menu_name']) . '</span>
							<b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
						<ul class="submenu">';
				$classActive = '';
				$isparentActive = '';
				$sqlmenu2 	= 'select * from m_menu where menu_status = 1 and menu_parent = ' . $line['menu_id'] . ' ' . $in_menu . ' order by menu_sort asc';
				$result2	= $this->db->query($sqlmenu2) or die('died 3');
				foreach ($result2->result_array() as $line2) {

					if ($line2['menu_child'] == 0) {
						if ($uri == $line2['menu_url']) {
							$classActive = 'active';
						}
						$body .= '<li class="' . $classActive . '"><a href="' . base_url() . $line2['menu_url'] . '"><i class="menu-icon ' . $line2['menu_icon'] . '"></i><span class="menu_text">' . ucwords($this->session->userdata('logged_in')['language'] == 'indonesia' ? $line2['menu_nama'] : $line2['menu_name']) . '</span></a><b class="arrow"></b></li>';
						$classActive = '';
					} else {
						// print_r($prentId2->id);
						if (isset($prentId)) {
							if ($prentId->menu_id == $line2['menu_id']) {
								$classActive = 'active';
							}
						}
						$sqlMenuParentActive = "SELECT * FROM m_menu WHERE menu_url = '$uri' AND menu_status=1";
						$parentActive = $this->db->query($sqlMenuParentActive)->result_array() or die('died 6');
						$idParentActive = $parentActive[0]['menu_parent'];
						// print_r($line2['menu_id']);die;
						if ($idParentActive == $line2['menu_id']) {
							$isparentActive = "active open";
						}
						$body .= '<li class="' . $isparentActive . '">
						<a href="#" class="dropdown-toggle"><i class="menu-icon ' . $line2['menu_icon'] . '"></i> <span class="menu_text">' . ucwords($this->session->userdata('logged_in')['language'] == 'indonesia' ? $line2['menu_nama'] : $line2['menu_name']) . '</span>
							<b class="arrow fa fa-angle-down"></b>
                        </a>
                        <b class="arrow"></b>
						<ul class="submenu">';
						$classActive = '';
						$isparentActive = '';
						// $body .= '<li>
						// <a><i class="' . $line2['icon'] . '"></i>' . $line2['name'] . '<span class="fa fa-chevron-down"></a>
						// <ul class="nav child_menu">';

						$sqlmenu3 	= 'select * from m_menu where menu_status = 1 and  menu_parent = ' . $line2['menu_id'] . ' ' . $in_menu . ' order by menu_sort asc';
						// die($sqlmenu3);
						$result3	= $this->db->query($sqlmenu3) or die('died 4');
						foreach ($result3->result_array() as $line3) {

							if ($line3['menu_child'] == 0) {
								if ($uri == $line3['menu_url']) {
									$classActive = 'active';
								}
								$body .= '<li class="' . $classActive . '"><a href="' . base_url() . $line3['menu_url'] . '"><i class="menu-icon ' . $line3['menu_icon'] . '"></i><span class="menu_text">' . ucwords($this->session->userdata('logged_in')['language'] == 'indonesia' ? $line3['menu_nama'] : $line3['menu_name']) . '</span></a><b class="arrow"></b></li>';
								$classActive = '';
							} else {


								$body .= '<li class="dropdown-submenu">
												<a class="dropdown-toggle" href="#">' . $line3['name'] . '<span class="arrow"></span></a>
												<ul class="dropdown-menu">';

								$sqlmenu4 	= 'select * from m_menu where status = 1 and  menu_parent = ' . $line3['menu_id'] . ' ' . $in_menu . ' order by menu_sort asc';
								$result4	= $this->db->query($sqlmenu4) or die('died 5');
								foreach ($result4->result_array() as $line4) {
									if ($line4['menu_child'] == 0) {
										$body .= '<li><a href="' . base_url() . $line4['menu_url'] . '">' . $line4['menu_name'] . '</a></li>';
									} else {


										$body .= '<li class="dropdown-submenu">
														<a class="dropdown-toggle" href="#">' . $line4['name'] . '<span class="arrow"></span></a>
														<ul class="dropdown-menu">';

										$sqlmenu5 	= 'select id, url, name, parent, child from menu where status = 1 and  parent = ' . $line4['menu_id'] . ' ' . $in_menu . ' order by sort asc';
										$result5	= $this->db->query($sqlmenu5) or die('died 6');
										foreach ($result5->result_array() as $line5) {
											$body .= '<li><a href="' . base_url() . $line5['url'] . '">' . $line5['name'] . '</a></li>';
										}

										$body .= '
												</ul>
											</li>';
									}
								}

								$body .= '
												</ul>
											</li>';
							}
						}

						$body .= '
								</ul>
								</li>';
					}
				}


				$body .= '                
                        </ul>                    
						</li>';
			}
		}
		// die;
		return $body;
	}

	function UserAllow($role_id)
	{
		$query = "SELECT * FROM m_role WHERE role_id = $role_id LIMIT 1";
		$q = $this->db->query($query);
		return $q->result_array();
	}

	function idMenu($urlmenu)
	{
		$query = "SELECT menu_id, menu_access FROM m_menu WHERE menu_status = 1 and menu_url = '$urlmenu' ORDER BY menu_id ASC LIMIT 1";
		$q = $this->db->query($query);
		return $q->result_array();
	}

	function routing($id)
	{
		$query = "SELECT menu_id,menu_url,menu_name,menu_access FROM m_menu WHERE menu_status = 1 and menu_parent = $id AND menu_id<>$id  ORDER BY menu_sort";
		$q = $this->db->query($query);
		return $q->result();
	}

	function getmenujson()
	{

		$menu = array();
		$menu_top = $this->routing(0);
		$menu = $menu_top;

		$n1 = 0;
		foreach ($menu as $top) {
			$menu['root'][$n1]['menu_id'] = $top->menu_id;
			$menu['root'][$n1]['menu_url'] = $top->menu_url;
			$menu['root'][$n1]['menu_name'] = $top->menu_name;

			$col = $this->routing($top->menu_id);
			if (count($col) <> 0) {
				$menu['sub_' . $top->menu_id] = $col;
			}

			$n2 = 0;
			foreach ($col as $top2) {
				$col2 = $this->routing($top2->menu_id);
				if (count($col2) <> 0) {
					$menu['sub_' . $top->menu_id . '_' . $top2->menu_id] = $col2;
				}
				$n3 = 0;
				foreach ($col2 as $top3) {
					$col3 = $this->routing($top3->menu_id);
					if (count($col3) <> 0) {
						$menu['sub_' . $top->menu_id . '_' . $top2->menu_id . '_' . $top3->menu_id] = $col3;
					}

					$n3++;
				}
				$n2++;
			}

			$n1++;
		}

		return $menu;
	}

	function cektreeup($id)
	{
		$this->db->where('menu_id', $id);
		$this->db->where('menu_status', '1');
		$data = $this->db->get('m_menu')->result_array();

		//GALIH FIXING undefined xx 
		//START
		$xx['menu_id'] = '';
		$xx['menu_parent'] = '';
		//GALIH END

		foreach ($data as $item) {
			$xx['menu_id'] = $item['menu_id'];
			$xx['menu_parent'] = $item['menu_parent'];
		}
		return $xx;
	}

	function _load_region()
	{
		$query = "SELECT * from data_region";
		$q = $this->db->query($query);
		return $q->result_array();
	}

	function _load_branch_old($id_region)
	{
		$query = "SELECT * from data_branch where id_region in($id_region)";
		$q = $this->db->query($query);
		return $q->result_array();
	}

	function _load_branch($id_subbranch)
	{
		$query = "SELECT a.id_branch, b.code_branch, b.name_branch FROM  data_territory_distributor a 
				join data_branch b ON a.id_branch = b.id_branch  
				where a.id_subbranch IN ($id_subbranch)";

		$q = $this->db->query($query);
		return $q->result_array();
	}

	function _load_subbranch_old($id_branch)
	{
		$query = "SELECT * from data_subbranch where id_branch in($id_branch)";
		$q = $this->db->query($query);
		return $q->result_array();
	}

	function _load_subbranch_old2($id_branch)
	{
		$query = "SELECT b.* FROM  data_territory_distributor a 
				join data_subbranch b ON a.id_subbranch = b.id_subbranch  
				where a.id_branch in($id_branch)";

		$q = $this->db->query($query);
		return $q->result_array();
	}

	function _load_subbranch($id_region)
	{
		$query = "SELECT * from data_subbranch where id_region in($id_region)";
		$q = $this->db->query($query);
		return $q->result_array();
	}

	function _load_salesman($id_subbranch)
	{
		$query = "SELECT * from data_salesman where id_subbranch in($id_subbranch)";

		$q = $this->db->query($query);

		return $q->result_array();
	}
}
