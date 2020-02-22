<div class="main-panel">
    <div class="content">

        <div class="col-12">
            <div class="card">
                <div class="card-header">
    
                    <div class="col-lg-6">
                        <form action="<?= base_url();?>Reviewer/search_jurnal" method="post">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="submit" class="btn btn-search pr-1" id="tombolCari">
                                        <i class="fa fa-search search-icon-center"></i>
                                    </button>
                                </div>
                                <input type="text" class="form-control" placeholder="Masukkan ID Jurnal ..." name="keyword" id="keyword" autocomplete="off">
                                </div>
                            </div>
                        </form>
                    </div>

                <div class="card-body">
                <!-- table responsive -->
                <div class="table-responsive">
                    <div class="row">
                        <div class="col-12">
                            <table id="basic-datatables" class="table table-striped table-bordered">
                                <thead>
                                <tr>
                                    <td align="center">No.</td>
                                    <td align="center">Id Dosen</td>
                                    <td align="center">Id Jurnal</td>
                                    <td align="center">Judul</td>
                                    <td align="center">Nomor ISSN</td>
                                    <td align="center">Volume/Nomor Bulan/Tahun</td>
                                    <td align="center">File Jurnal</td>
                                    <td align="center">Action</td>
                                </tr>
                                </thead>
                                
                                <tbody>
                                    <?php $no=1; ?>
                                    <?php foreach ($getData as $p) { ?>
                                <tr>
                                    <td align="center"><?php echo $no++; ?></td>
                                    <td align="center"><?php echo $p->id_user; ?></td>
                                    <td align="center"><?php echo $p->id_jurnal; ?></td>
                                    <td align="center"><?php echo $p->judul_jurnal; ?> </td>
                                    <td align="center"><?php echo $p->ISSN; ?></td>
                                    <td align="center"><?php echo $p->volume; ?>/<?php echo $p->nomor; ?><br><?php echo $p->bulan; ?>/<?php echo $p->tahun; ?></td>
                                    <td align="center"><?php echo $p->file_jurnal; ?></td>
                                    <td>
                                        <div class="form-button-action">
                                            <a href="<?php echo base_url();?>Reviewer/download/<?php echo $p->file_jurnal; ?>" type="submit" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Download Jurnal">
                                                <i class="fa fa-download"></i>
                                            </a>
                                            <a href="<?= base_url();?>Reviewer/give_nilai/<?php echo $p->id_jurnal; ?>" type="button" data-toggle="tooltip" title="" class="btn btn-link btn-simple-primary btn-lg" data-original-title="Beri Nilai Jurnal">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            </button>                                                        
                                        </div>
                                    </td>

                                </tr>
                                    <?php } ?>
                                </tbody>
                            </table>

                        </div>
					</div>
                </div>
				<!-- table responsive -->	

			</div>						
        </div>
    </div>
</div>				