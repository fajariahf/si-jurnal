<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reviewer extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$role_name = $this->session->userdata('role_name');
		$email = $this->session->userdata('email');
		if ($role_name == 'Reviewer')
		{
			'<?php echo base_url();?>Reviewer/';
		} else if ($role_name !== 'Reviewer' && $email == NULL){			
				redirect('Auth');
		} 
		   else {
			redirect('Auth');
		}
	}

    public function index()
	{
		$data['judul'] 		= 'Dashboard Reviewer';
		$data['getView'] 	= $this->Nilai_model->view_nilai();

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/dashboard_reviewer', $data);
		$this->load->view('templates/footer');
	}
	
	public function nilai_delete($id_nilai)
	{
		$this->Nilai_model->nilai_delete($id_nilai);
		redirect('Reviewer/halaman_penilaian');
	}
	
	public function search_index()
	{
		$data['judul'] 		= 'Halaman Jurnal';
		$keyword 			= $this->input->post('keyword');
		$data['getView'] 	= $this->Nilai_model->search_index($keyword);

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/dashboard_reviewer', $data);
		$this->load->view('templates/footer');
	}

	public function search_jurnal()
	{
		$data['judul'] 		= 'Halaman Jurnal';
		$keyword 			= $this->input->post('keyword');
		$data['getData'] 	= $this->Nilai_model->search_jurnal($keyword);

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/halaman_jurnal', $data);
		$this->load->view('templates/footer');
	}
	///////////////////////////// data user ///////////////////////////////////

	public function operator()
	{
		$data['judul'] 		= 'Halaman Data Operator';
		$data['getuser'] 	= $this->User_model->getOperator();

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/halaman_operator', $data);
		$this->load->view('templates/footer');
	}

	public function data_reviewer()
	{
		$data['judul'] 		= 'Halaman Data Reviewer';
		$data['getuser'] 	= $this->User_model->getReviewer();

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/halaman_reviewer', $data);
		$this->load->view('templates/footer');
	}
	
	public function dosen()
	{
		$data['judul'] 		= 'Halaman Data Dosen';
		$data['getuser'] 	= $this->User_model->getDosen();

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/halaman_reviewer', $data);
		$this->load->view('templates/footer');
	}

/////////////////////// menu ///////////////////////////////////
	public function halaman_jurnal()
	{
		$data['judul'] 			= 'Halaman Jurnal Dosen';
		$data['getData']	= $this->Jurnal_model->jurnal();

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/halaman_jurnal', $data);
		$this->load->view('templates/footer');
	}

	public function give_nilai()
	{
		$data['judul'] 			= 'Halaman Jurnal Dosen';
		$data['jurnal'] 		= $this->Jurnal_model->jurnal();
		$data['jurnal'] 		= $this->Nilai_model->nilai_jurnal();

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/form_penilaian', $data);
		$this->load->view('templates/footer');
	
	}

	public function nilai_save()
	{
		$data['id_nilai']				= $this->input->post('id_nilai',true);
		$data['id_jurnal']				= $this->input->post('id_jurnal',true);
		$data['id_reviewer']			= $this->input->post('id_reviewer',true);
		$data['stat_reviewer']			= $this->input->post('stat_reviewer',true);
		$data['kelengkapan_isi']		= $this->input->post('kelengkapan_isi',true);
		$data['ruanglingkup']			= $this->input->post('ruanglingkup',true);
		$data['kecukupan']				= $this->input->post('kecukupan',true);
		$data['kelengkapan_unsur']		= $this->input->post('kelengkapan_unsur',true);
		// $data['keterangan']				= "Sudah dinilai";
		$data['date_created']			= time();

	$this->Nilai_model->nilai_save($data);
	redirect('Reviewer/halaman_penilaian');
	}

	public function halaman_penilaian()
	{
		$data['judul'] 			= 'Halaman Penilaian Jurnal Dosen';
		$data['getNilaiJurnal']	= $this->Nilai_model->nilai_jurnal();
		$data['sum']			= $this->Nilai_model->get_total();
		
		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/halaman_penilaian', $data);
		$this->load->view('templates/footer');
	}

	public function download()
	{
		$this->load->helper(array('url','download'));

		$name = $this->uri->segment(3);
		$data = file_get_contents("assets/file/".$name);
		force_download($name, $data);
	}


	//////////////////////////// pengaturan ////////////////////////////

	public function profil()
	{
		$data['judul'] 		= 'Halaman Profil';
		$data['user'] 		= $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
		
		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/profil', $data);
		$this->load->view('templates/footer');
	}

	public function edit_profil($kode = 0)
	{
		$data['judul'] 		= 'Halaman Edit Profil';
		$data['user'] 		= $this->User_model->user();
		$data_user			= $this->User_model->getUser("where id_user = '$kode'")->result_array();
		
		$data				= array(
			'judul'					=> 'Halaman Edit Profil',
			'kode'					=> $data_user[0]['id_user'],
			'id_user'				=> $data_user[0]['id_user'],
			'nip'					=> $data_user[0]['nip'],
			'image'					=> $data_user[0]['image'],	
			'name'					=> $data_user[0]['name'],	
			'email'					=> $data_user[0]['email'],	
			'pendidikan_tertinggi'	=> $data_user[0]['pendidikan_tertinggi'],
			'pangkat'				=> $data_user[0]['pangkat'],	
			'gol_ruang'				=> $data_user[0]['gol_ruang'],	
			'jab_fungsional'		=> $data_user[0]['jab_fungsional'],
			'fakultas'				=> $data_user[0]['fakultas'],
			'jurusan'				=> $data_user[0]['jurusan'],
			'unit_kerja'			=> $data_user[0]['unit_kerja'],
		);

        $this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/profil_edit', $data);
		$this->load->view('templates/footer');	
	}


	public function profil_save_edit()
	{
		$kode					= $this->input->post('kode');
		$id_user				= $this->input->post('id_user');
		$nip					= $this->input->post('nip');
		$name					= $this->input->post('name');
		$email					= $this->input->post('email');
		$image					= $this->input->post('image');
		$pendidikan_tertinggi	= $this->input->post('pendidikan_tertinggi');
		$pangkat				= $this->input->post('pangkat');
		$gol_ruang				= $this->input->post('gol_ruang');
		$jab_fungsional			= $this->input->post('jab_fungsional');
		$fakultas				= $this->input->post('fakultas');
		$jurusan				= $this->input->post('jurusan');
		$unit_kerja				= $this->input->post('unit_kerja');

		$this->db->where('id_user',$kode);
			$query	= $this->db->get('user');
			$row	= $query->row();
			
			unlink(".assets/img/profile/$row->image");
			if($_FILES['image']['name'] != ""){
				$config['upload_path']          = 'assets/img/profile';
				$config['allowed_types']        = 'jpeg|jpg|png|pdf';
				$config['max_size']             = '2000';
				$config['remove_space']			= true;
				$config['overwrite']			= true;
				$config['encrypt_name']			= false;
				$config['max_width'] 			= '';
				$config['max_height']			= '';
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('image'))
				{
					print_r('Ukuran file terlalu besar. Maksimal 2 MB');
					exit();
					}
				else
				{
					$image = $this->upload->data();
					if($image['file_name'])
					{
					$data['file'] = $image['file_name'];
					}
					$image = $data['file'];
					}
				}

				$data = array(
					'id_user'				=> $id_user,
					'nip'					=> $nip,
					'name'					=> $name,
					'email'					=> $email,
					'image'					=> $image,
					'pendidikan_tertinggi'	=> $pendidikan_tertinggi,
					'pangkat'				=> $pangkat,
					'gol_ruang'				=> $gol_ruang,
					'jab_fungsional'		=> $jab_fungsional,
					'fakultas'				=> $fakultas,
					'jurusan'				=> $jurusan,
					'unit_kerja'			=> $unit_kerja
					);

	  $this->User_model->updatedata('user',$data, array('id_user' => $kode));
	  redirect('Reviewer/profil');
	}


}