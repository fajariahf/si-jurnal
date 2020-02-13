<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dosen extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		$role_name = $this->session->userdata('role_name');
		$email = $this->session->userdata('email');
		if ($role_name == 'Dosen')
		{
			'<?php echo base_url();?>Dosen/';
		} else if ($role_name !== 'Dosen' && $email == NULL){			
				redirect('Auth');
		} 
		   else {
			redirect('Auth');
		}
	}

    public function index()
	{
		$data['judul'] 		= 'Dashboard Dosen';
		$data['getView']	= $this->Jurnal_model->view();
		// $data['getView']	= $this->Jurnal_model->jurnal();

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/dashboard_dosen', $data);
		$this->load->view('templates/footer');
	}

	public function search()
	{
		$data['judul'] 			= 'Halaman Jurnal Dosen';
		$keyword 				= $this->input->post('keyword');
		$data['getDataJurnal'] 	= $this->Jurnal_model->search($keyword);

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/halaman_jurnal', $data);
		$this->load->view('templates/footer');
	}

	public function jurnal_delete($id_jurnal)
	{
		$this->Jurnal_model->jurnal_delete($id_jurnal);
		redirect('Dosen/halaman_jurnal');
	}

///////////////////////////// data user ///////////////////////////////////

	public function operator()
	{
		$data['judul'] 		= 'Halaman Data Operator';
		$data['getuser'] 	= $this->User_model->getOperator();

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/halaman_operator', $data);
		$this->load->view('templates/footer');
	}

	public function reviewer()
	{
		$data['judul'] 		= 'Halaman Data Reviewer';
		$data['getuser'] 	= $this->User_model->getReviewer();

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/halaman_reviewer', $data);
		$this->load->view('templates/footer');
	}
	
	public function data_dosen()
	{
		$data['judul'] 		= 'Halaman Data Dosen';
		$data['getuser'] 	= $this->User_model->getDosen();

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/halaman_dosen', $data);
		$this->load->view('templates/footer');
	}

/////////////////////// menu ///////////////////////////////////
	public function halaman_jurnal()
	{
		$data['judul'] 			= 'Halaman Jurnal Dosen';
		$data['getDataJurnal']	= $this->Jurnal_model->view_penulisjurnal();

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/halaman_jurnal', $data);
		$this->load->view('templates/footer');
	}

	public function upload_jurnal()
	{
		$data['judul'] 		= 'Halaman Jurnal Dosen';

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/form_upload_jurnal', $data);
		$this->load->view('templates/footer');
	}

	public function jurnal_save()
	{
		
		$data['id_jurnal']			= $this->input->post('id_jurnal',true);
		$data['id']					= $this->input->post('id',true);
		$data['nip_penulis']		= $this->input->post('nip_penulis',true);
		$data['judul_jurnal']		= $this->input->post('judul_jurnal',true);
		$data['nama_jurnal']		= $this->input->post('nama_jurnal',true);
		$data['ISSN']				= $this->input->post('ISSN',true);
		$data['volume']				= $this->input->post('volume',true);
		$data['nomor']				= $this->input->post('nomor',true);
		$data['bulan']				= $this->input->post('bulan',true);
		$data['tahun']				= $this->input->post('tahun',true);
		$data['penerbit']			= $this->input->post('penerbit',true);
		$data['DOI']				= $this->input->post('DOI',true);
		$data['alamat_web_jurnal']	= $this->input->post('alamat_web_jurnal',true);
		$data['alamat_web_artikel']	= $this->input->post('alamat_web_artikel',true);
		$data['terindeks_di']		= $this->input->post('terindeks_di',true);
		$data['status']				= $this->input->post('status',true);
		$data['keterangan']			= $this->input->post('keterangan',true);
		$data['file_jurnal']		= $_FILES['file_jurnal']['name'];
		$data['date_created']		= time();


		if($_FILES['file_jurnal']['name'] != ""){
			$config['upload_path']          = 'assets/file';
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = '5000';
			$config['remove_space']			= false;
			$config['overwrite']			= true;
			$config['encrypt_name']			= false;
			$config['max_width'] 			= '';
			$config['max_height']			= '';
			
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file_jurnal'))
			{
				print_r('Ukuran file terlalu besar. Maksimal 5 MB | Periksa Kembali File yang diupload');
				exit();
				}
			else
			{
				$image = $this->upload->data();
		}

	}
		
		$this->Jurnal_model->jurnal_save($data);
		redirect('Dosen/halaman_jurnal');

	}

	public function download()
	{
		$this->load->helper(array('url','download'));

		$name = $this->uri->segment(3);
		$data = file_get_contents("assets/file/".$name);
		force_download($name, $data);
	}

	public function tambah_penulis($kode = 0)
	{
		$data['getDataJurnal']	= $this->Jurnal_model->jurnal();
		$data_jurnal			= $this->Jurnal_model->getJurnal("where id_jurnal = '$kode'")->result_array();
		
		$data				= array(
			'judul'					=> 'Halaman Edit Jurnal',
			'kode'					=> $data_jurnal[0]['id_jurnal'],
			'id_jurnal'				=> $data_jurnal[0]['id_jurnal'],
			'id'					=> $data_jurnal[0]['id'],
			'judul_jurnal'			=> $data_jurnal[0]['judul_jurnal'],
			'nip_penulis'			=> $data_jurnal[0]['nip_penulis'],
			'nama_jurnal'			=> $data_jurnal[0]['nama_jurnal'],	
			'ISSN'					=> $data_jurnal[0]['ISSN'],
			'volume'				=> $data_jurnal[0]['volume'],	
			'nomor'					=> $data_jurnal[0]['nomor'],	
			'bulan'					=> $data_jurnal[0]['bulan'],
			'tahun'					=> $data_jurnal[0]['tahun'],
			'penerbit'				=> $data_jurnal[0]['penerbit'],
			'DOI'					=> $data_jurnal[0]['DOI'],
			'alamat_web_jurnal'		=> $data_jurnal[0]['alamat_web_jurnal'],
			'alamat_web_artikel'	=> $data_jurnal[0]['alamat_web_artikel'],
			'terindeks_di'			=> $data_jurnal[0]['terindeks_di'],
			'status'				=> $data_jurnal[0]['status'],
			'keterangan'			=> $data_jurnal[0]['keterangan'],
			'file_jurnal'			=> $data_jurnal[0]['file_jurnal'],
		);

        $this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/tambah_penulis', $data);
		$this->load->view('templates/footer');	
	}

	public function tambah_penulis_save()
	{
		
		$data['id_jurnal']			= $this->input->post('id_jurnal',true);
		$data['id']					= $this->input->post('id',true);
		$data['nip_penulis']		= $this->input->post('nip_penulis',true);
		$data['judul_jurnal']		= $this->input->post('judul_jurnal',true);
		$data['nama_jurnal']		= $this->input->post('nama_jurnal',true);
		$data['ISSN']				= $this->input->post('ISSN',true);
		$data['volume']				= $this->input->post('volume',true);
		$data['nomor']				= $this->input->post('nomor',true);
		$data['bulan']				= $this->input->post('bulan',true);
		$data['tahun']				= $this->input->post('tahun',true);
		$data['penerbit']			= $this->input->post('penerbit',true);
		$data['DOI']				= $this->input->post('DOI',true);
		$data['alamat_web_jurnal']	= $this->input->post('alamat_web_jurnal',true);
		$data['alamat_web_artikel']	= $this->input->post('alamat_web_artikel',true);
		$data['terindeks_di']		= $this->input->post('terindeks_di',true);
		$data['status']				= $this->input->post('status',true);
		$data['keterangan']			= $this->input->post('keterangan',true);
		$data['file_jurnal']		= $_FILES['file_jurnal']['name'];
		$data['date_created']		= time();


		if($_FILES['file_jurnal']['name'] != ""){
			$config['upload_path']          = 'assets/file';
			$config['allowed_types']        = 'pdf';
			$config['max_size']             = '5000';
			$config['remove_space']			= false;
			$config['overwrite']			= true;
			$config['encrypt_name']			= false;
			$config['max_width'] 			= '';
			$config['max_height']			= '';
			
			$this->load->library('upload',$config);
			$this->upload->initialize($config);
			if(!$this->upload->do_upload('file_jurnal'))
			{
				print_r('Ukuran file terlalu besar. Maksimal 5 MB | Periksa Kembali File yang diupload');
				exit();
				}
			else
			{
				$image = $this->upload->data();
		}

	}

		$this->Jurnal_model->jurnal_save($data);
		redirect('Dosen/halaman_jurnal');

}

	public function edit_jurnal($kode = 0)
	{
		$data['getDataJurnal']	= $this->Jurnal_model->jurnal();
		$data_jurnal			= $this->Jurnal_model->getJurnal("where id_jurnal = '$kode'")->result_array();
		
		$data				= array(
			'judul'					=> 'Halaman Edit Jurnal',
			'kode'					=> $data_jurnal[0]['id_jurnal'],
			'id_jurnal'				=> $data_jurnal[0]['id_jurnal'],
			'nip_penulis'			=> $data_jurnal[0]['nip_penulis'],
			'stat_penulis'			=> $data_jurnal[0]['stat_penulis'],
			'judul_jurnal'			=> $data_jurnal[0]['judul_jurnal'],	
			'nama_jurnal'			=> $data_jurnal[0]['nama_jurnal'],	
			'ISSN'					=> $data_jurnal[0]['ISSN'],
			'volume'				=> $data_jurnal[0]['volume'],	
			'nomor'					=> $data_jurnal[0]['nomor'],	
			'bulan'					=> $data_jurnal[0]['bulan'],
			'tahun'					=> $data_jurnal[0]['tahun'],
			'penerbit'				=> $data_jurnal[0]['penerbit'],
			'DOI'					=> $data_jurnal[0]['DOI'],
			'alamat_web_jurnal'		=> $data_jurnal[0]['alamat_web_jurnal'],
			'alamat_web_artikel'	=> $data_jurnal[0]['alamat_web_artikel'],
			'terindeks_di'			=> $data_jurnal[0]['terindeks_di'],
			'status'				=> $data_jurnal[0]['status'],
			'file_jurnal'			=> $data_jurnal[0]['file_jurnal'],
		);

        $this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/jurnal_edit', $data);
		$this->load->view('templates/footer');	
	}


	public function jurnal_save_edit()
	{
		$kode					= $this->input->post('kode');
		$id_jurnal				= $this->input->post('id_jurnal');
		$nip_penulis			= $this->input->post('nip_penulis');
		$stat_penulis			= $this->input->post('stat_penulis');
		$judul_jurnal			= $this->input->post('judul_jurnal');
		$nama_jurnal			= $this->input->post('nama_jurnal');
		$ISSN					= $this->input->post('ISSN');
		$volume					= $this->input->post('volume');
		$nomor					= $this->input->post('nomor');
		$bulan					= $this->input->post('bulan');
		$tahun					= $this->input->post('tahun');
		$penerbit				= $this->input->post('penerbit');
		$DOI					= $this->input->post('DOI');
		$alamat_web_jurnal		= $this->input->post('alamat_web_jurnal');
		$alamat_web_artikel		= $this->input->post('alamat_web_artikel');
		$terindeks_di			= $this->input->post('terindeks_di');
		$status					= $this->input->post('status');
		$file_jurnal			= $this->input->post('file_jurnal');


		$this->db->where('id_jurnal',$kode);
			$query	= $this->db->get('jurnal');
			$row	= $query->row();
			
			unlink(".assets/file/$row->file_jurnal");
			if($_FILES['file_jurnal']['name'] != ""){
				$config['upload_path']          = 'assets/file';
				$config['allowed_types']        = 'pdf';
				$config['max_size']             = '5000';
				$config['remove_space']			= true;
				$config['overwrite']			= true;
				$config['encrypt_name']			= false;
				$config['max_width'] 			= '';
				$config['max_height']			= '';
				
				$this->load->library('upload',$config);
				$this->upload->initialize($config);
				if(!$this->upload->do_upload('file_jurnal'))
				{
					print_r('Ukuran file terlalu besar. Maksimal 5 MB | Masukkan file dengan tipe data ".pdf"');
					exit();
					}
				else
				{
					$file_jurnal = $this->upload->data();
					if($file_jurnal['file_name'])
					{
					$data['file'] = $file_jurnal['file_name'];
					}
					$file_jurnal = $data['file'];
					}
				}

				$data = array(
					'id_jurnal'				=> $id_jurnal,
					'nip_penulis'			=> $nip_penulis,
					'stat_penulis'			=> $stat_penulis,
					'judul_jurnal'			=> $judul_jurnal,	
					'nama_jurnal'			=> $nama_jurnal,
					'ISSN'					=> $ISSN,
					'volume'				=> $volume,	
					'nomor'					=> $nomor,	
					'bulan'					=> $bulan,
					'tahun'					=> $tahun,
					'penerbit'				=> $penerbit,
					'DOI'					=> $DOI,
					'alamat_web_jurnal'		=> $alamat_web_jurnal,
					'alamat_web_artikel'	=> $alamat_web_artikel,
					'terindeks_di'			=> $terindeks_di,
					'status'				=> $status,
					'file_jurnal'			=> $file_jurnal
					);

		$this->Jurnal_model->updatedata('jurnal',$data, array('id_jurnal' => $kode));
	  	redirect('Dosen/halaman_jurnal');
	}

	public function halaman_penilaian()
	{
		$data['judul'] 			= 'Halaman Penilaian Jurnal Dosen';
		$data['getNilaiJurnal']	= $this->Jurnal_model->nilai_jurnal();
		$data['sum']			= $this->Jurnal_model->get_total();

		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/halaman_penilaian', $data);
		$this->load->view('templates/footer');
	}

//////////////////////////// pengaturan ////////////////////////////

	public function profil()
	{
		$data['judul'] 		= 'Halaman Profil';
		$data['user'] 		= $this->db->get_where('user',['email' => $this->session->userdata('email')])->row_array();
		
		$this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/profil', $data);
		$this->load->view('templates/footer');
	}

	public function edit_profil($kode = 0)
	{
		$data['judul'] 		= 'Halaman Edit Profil';
		$data['user'] 		= $this->User_model->user();
		$data_user			= $this->User_model->getUser("where id = '$kode'")->result_array();
		
		$data				= array(
			'judul'					=> 'Halaman Edit Profil',
			'kode'					=> $data_user[0]['id'],
			'id'					=> $data_user[0]['id'],
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

        $this->load->view('dosen/header_dosen', $data);
		$this->load->view('dosen/sidebar_dosen');
		$this->load->view('dosen/profil_edit', $data);
		$this->load->view('templates/footer');	
	}


	public function profil_save_edit()
	{
		$kode					= $this->input->post('kode');
		$id						= $this->input->post('id');
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

		$this->db->where('id',$kode);
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
					'id'					=> $id,
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

	  $this->User_model->updatedata('user',$data, array('id' => $kode));
	  redirect('Dosen/profil');
	}
}