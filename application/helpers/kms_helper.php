<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


if (!function_exists('getNamaJenisSurat')) {
	function getNamaJenisSurat($id)
	{
		if ($id == 1) {
			return  "Surat Masuk";
		} else  if ($id == 2) {
			return  "Surat Keluar";
		}
	}
}
