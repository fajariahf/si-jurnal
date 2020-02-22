<link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css');?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.9/dist/css/bootstrap-select.min.css">

<div class="main-panel">
    <div class="content">

        <div class="col-12">
            <div class="card">
                <div class="card-header">

                <div class="d-flex align-items-center">
                        <h4 class="card-title">Detail Penulis Jurnal</h4>
                    </div>

                    <div class="card-body">
                    <div class="table">
                        <div class="row">
                            <div class="col-md-12 col-table">
                                <table id="basic-datatables" class="table table-striped table-bordered">
                                    <thead>
                                        <tr>
                                            <td align="center">No.</td>
                                            <td align="center">Id Jurnal</td>
                                            <td align="center">Judul Jurnal</td>
                                            <td align="center">Nip Penulis</td>
                                            <td align="center">Jumlah Penulis</td>
                                            <td align="center">Action</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            $count=0;
                                            foreach ($jurnal->result() as $row) :
                                                $count++;
                                        ?>
                                        <tr>
                                            <td align="center"><?php echo $count;?></td>
                                            <td align="center"><?php echo $row->id_jurnal; ?></td>
                                            <td align="center"><?php echo $row->judul_jurnal; ?></td>
                                            <td align="center"><?php echo $row->nip; ?></td>
                                            <td align="center"><?php echo $jml_penulis.' Orang'; ?></td>
                                        <td>            
                                            <a href="<?= base_url();?>Dosen/tambah_penulis/<?php echo $row->id_jurnal; ?>" type="button" class="btn btn-info btn-sm update-record">
                                                <i class="fa fa-plus">  Tambah Penulis</i>
                                            </a>
                                        </td>
                                        </tr>
                                        <?php endforeach;?>
                                    </tbody>
                                </table>
                                </div>
            </div>						
        </div>
    </div>
</div>				
