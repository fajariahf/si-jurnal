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
		$data['getView'] 	= $this->Jurnal_model->view();

		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/dashboard_reviewer', $data);
		$this->load->view('templates/footer');
	}
	
	public function nilai_delete($id_nilai)
	{
		$this->Jurnal_model->nilai_delete($id_nilai);
		redirect('Reviewer/halaman_penilaian');
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

	// public function give_nilai()
	// {
	// 	$data['judul'] 			= 'Halaman Jurnal Dosen';

	// 	$this->load->view('reviewer/header_reviewer', $data);
	// 	$this->load->view('reviewer/sidebar_reviewer');
	// 	$this->load->view('reviewer/form_penilaian', $data);
	// 	$this->load->view('templates/footer');
	
	// }

	// public function nilai_save()
	// {
	// 	$data['id_nilai']				= $this->input->post('id_nilai',true);
	// 	$data['id_jurnal']				= $this->input->post('id_jurnal',true);
	// 	$data['id_reviewer']			= $this->input->post('id_reviewer',true);
	// 	$data['stat_reviewer']			= $this->input->post('stat_reviewer',true);
	// 	$data['kelengkapan_isi']		= $this->input->post('kelengkapan_isi',true);
	// 	$data['ruanglingkup']			= $this->input->post('ruanglingkup',true);
	// 	$data['kecukupan']				= $this->input->post('kecukupan',true);
	// 	$data['kelengkapan_unsur']		= $this->input->post('kelengkapan_unsur',true);
	// 	$data['keterangan']				= "Sudah dinilai";
	// 	// $data['file_penilaian']			= $_FILES['file_penilaian']['name'];
	// 	$data['date_created']			= time();


	// 	// if($_FILES['file_jurnal']['name'] != ""){
	// 	// 	$config['upload_path']          = 'assets/file';
	// 	// 	$config['allowed_types']        = 'pdf';
	// 	// 	$config['max_size']             = '5000';
	// 	// 	$config['remove_space']			= false;
	// 	// 	$config['overwrite']			= true;
	// 	// 	$config['encrypt_name']			= false;
	// 	// 	$config['max_width'] 			= '';
	// 	// 	$config['max_height']			= '';
			
	// 	// 	$this->load->library('upload',$config);
	// 	// 	$this->upload->initialize($config);
	// 	// 	if(!$this->upload->do_upload('file_jurnal'))
	// 	// 	{
	// 	// 		print_r('Ukuran file terlalu besar. Maksimal 5 MB | Periksa Kembali File yang diupload');
	// 	// 		exit();
	// 	// 		}
	// 	// 	else
	// 	// 	{
	// 	// 		$image = $this->upload->data();
	// 	// }

	// // }
	// // $this->Jurnal_model->jurnal($data);
	// $this->Jurnal_model->nilai_save($data);
	// redirect('Reviewer/halaman_penilaian');

	// }

	public function give_nilai($kode = 0)
	{
		$data['getDataJurnal']	= $this->Jurnal_model->jurnal();
		$data_nilai			= $this->Jurnal_model->getNilai("where id_jurnal = '$kode'")->result_array();
		
		$data				= array(
			'judul'					=> 'Halaman Upload Nilai Jurnal',
			'kode'					=> $data_nilai[0]['id_nilai'],
			'id_nilai'				=> $data_nilai[0]['id_nilai'],
			'id_jurnal'				=> $data_nilai[0]['id_jurnal'],		
			'id_reviewer'			=> $data_nilai[0]['id_reviewer'],
			'stat_reviewer'			=> $data_nilai[0]['stat_reviewer'],	
			'kelengkapan_isi'		=> $data_nilai[0]['kelengkapan_isi'],
			'ruanglingkup'			=> $data_nilai[0]['ruanglingkup'],
			'kecukupan'				=> $data_nilai[0]['kecukupan'],
			'kelengkapan_unsur'		=> $data_nilai[0]['kelengkapan_unsur'],
		);

        $this->load->view('reviewer/header_reviewer', $data);
		// $this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/form_penilaian', $data);
		$this->load->view('templates/footer');	
	}


	public function nilai_save()
	{
		// $kode					= $this->input->post('kode');
		$id_nilai				= $this->input->post('id_nilai');
		$id_jurnal				= $this->input->post('id_jurnal');
		$id_reviewer			= $this->input->post('id_reviewer');
		$stat_reviewer			= $this->input->post('stat_reviewer');
		$kelengkapan_isi		= $this->input->post('kelengkapan_isi');
		$ruanglingkup			= $this->input->post('ruanglingkup');
		$kecukupan				= $this->input->post('kecukupan');
		$kelengkapan_unsur		= $this->input->post('kelengkapan_unsur');
		$alamat_web_jurnal		= $this->input->post('alamat_web_jurnal');


		$this->db->where('id_jurnal',$kode);
			$query	= $this->db->get('nilai_jurnal');

				$data = array(
					'id_nilai'				=> $id_nilai,
					'id_jurnal'				=> $id_jurnal,
					'id_reviewer'			=> $id_reviewer,
					'stat_reviewer'			=> $stat_reviewer,	
					'kelengkapan_isi'		=> $kelengkapan_isi,
					'ruanglingkup'			=> $ruanglingkup,
					'kecukupan'				=> $kecukupan,
					'kelengkapan_unsur'		=> $kelengkapan_unsur
					);

		$this->Jurnal_model->updatedata('nilai_jurnal',$data, array('id_nilai' => $kode));
	  	redirect('Reviewer/halaman_penilaian');
	}

	public function halaman_penilaian()
	{
		$data['judul'] 			= 'Halaman Penilaian Jurnal Dosen';
		// $this->load->model('Jurnal_model');
		$data['getNilaiJurnal']	= $this->Jurnal_model->nilai_jurnal();
		$data['sum']			= $this->Jurnal_model->get_total();
		
		$this->load->view('reviewer/header_reviewer', $data);
		$this->load->view('reviewer/sidebar_reviewer');
		$this->load->view('reviewer/halaman_penilaian', $data);
		$this->load->view('templates/footer');
	}

	
}