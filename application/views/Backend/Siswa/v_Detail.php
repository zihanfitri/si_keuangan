<?php 

$id = $this->uri->segment(3);

$na = $this->db->query("SELECT name FROM siswa WHERE id = '$id'")->row_array();

?>

<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header">
           <h3> Nama Siswa : <?=$na['name']?> </h3> 
        </div>
        <!-- data spp -->
        <div class="box-body">
            <h4><strong>Data SPP</strong></h4>
            <div class="table-responsive">      
                <table  class="table tabel table-bordered table-hover">
                    <thead>
                        <tr>
                      <th style="width: 10px;">No</th>
                      <th>Waktu Pembayaran</th>
                      <th>SPP</th>
                      <th>Nominal</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no=1;
                    foreach ($spp as $key ) { ?>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?=tanggal($key->tanggal,'bulan').' - '.jam($key->tanggal).' WIB'?></td>
                            <td><?=$key->bulan?></td>
                            <td><?=rupiah($key->nominal)?></td>
                        </tr>
                    <?php  } ?>
                      
                    </tbody>
                </table>
            </div>
        </div>
        <!-- data jajan -->
        <div class="box-body">
            <h4><strong>Data Jajan</strong></h4>
            <div class="table-responsive">      
                <table  class="table tabel table-bordered table-hover">
                    <thead>
                        <tr>
                            <th style="width: 10px;">No</th>
                            <th>Tanggal</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Saldo</th>
                            <th>Keterangan</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no=1;
                    foreach ($jajan as $key ) { ?>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?=tanggal($key->tanggal,'bulan').' - '.jam($key->tanggal).' WIB'?></td>
                            <td><?=rupiah($key->masuk)?></td>
                            <td><?=rupiah($key->keluar)?></td>
                            <td><?=rupiah($key->saldo)?></td>
                            <td><?=$key->keterangan?></td>
                        </tr>
                    <?php  } ?>
                      
                    </tbody>
                </table>
            </div>
        </div>
        <!-- data tabungan -->
        <div class="box-body">
            <h4><strong>Data Tabungan</strong></h4>
            <div class="table-responsive">      
                <table  class="table tabel table-bordered table-hover">
                    <thead>
                        <tr>
                      <th style="width: 10px;">No</th>
                      <th>Tanggal</th>
                      <th>Masuk</th>
                      <th>Keluar</th>
                      <th>Saldo</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php 
                    $no=1;
                    foreach ($tabungan as $key ) { ?>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?=tanggal($key->tanggal,'bulan').' - '.jam($key->tanggal).' WIB'?></td>
                            <td><?= $key->status == 1 ? rupiah($key->nominal) : "-"?></td>
                            <td><?= $key->status == 2 ? rupiah($key->nominal) : "-"?></td>
                            <td><?= rupiah($key->saldo) ?></td>
                        </tr>
                    <?php  } ?>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>