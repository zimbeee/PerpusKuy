<?php if(! defined('BASEPATH')) exit('Akses langsung tidak diperbolehkan'); 

class Simple_login {
	// SET SUPER GLOBAL
	var $CI = NULL;
	public function __construct() {
		$this->CI =& get_instance();
	}
	// Fungsi login
	public function login($username, $password) {
		$query = $this->CI->db->get_where('tbl_admin',array('username'=>$username,'password' => $password));
		if($query->num_rows() == 1) {
			$row 	= $this->CI->db->query('SELECT kd_admin FROM tbl_admin where username = "'.$username.'"');
			$id = $row->row()->id_user;
			$this->CI->session->set_userdata('username', $username);
			$this->CI->session->set_userdata('id_login', uniqid(rand()));
			$this->CI->session->set_userdata('username', $username);
			redirect(base_url('index.php/dasbor_admin'));
		}else{
			$this->CI->session->set_flashdata('sukses','Oops... Username/password salah');
			redirect(base_url('index.php/login'));
		}
		return false;
	}
	// Proteksi halaman
	public function cek_login() {
		if($this->CI->session->userdata('username') == '') {
			$this->CI->session->set_flashdata('sukses','Anda belum login');
			redirect(base_url('index.php/login'));
		}
	}
	// Fungsi logout
	public function logout() {
		$this->CI->session->unset_userdata('username');
		$this->CI->session->unset_userdata('id_login');
		$this->CI->session->unset_userdata('id');
		$this->CI->session->set_flashdata('sukses','Anda berhasil logout');
		redirect(base_url('index.php/login'));
	}
}