<?php 

$id = $this->uri->segment(3);

$na = $this->db->query("SELECT name FROM siswa WHERE id = '$id'")->row_array();

?>

<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header">
           <h3> Nama Siswa : <?=$na['name']?> </h3> 
        </div>
        <div class="box-body">
            <div class="table-responsive">      
                <table  class="table tabel table-bordered table-hover">
                    <thead>
                        <tr>
                      <th style="width: 10px;">No</th>
                      <th>Waktu Pembayaran</th>
                      <th>SPP</th>
                      <th>Nominal</th>
                      <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
<?php 
$no=1;
foreach ($isi as $key ) { 
    $kode = base64_encode($key->spp.'-'.$key->makan.'-'.$key->air);

    ?>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?=tanggal($key->tanggal,'bulan').' - '.jam($key->tanggal).' WIB'?></td>
                            <td><?=$key->bulan?></td>
                            <td><?=rupiah($key->nominal)?></td>
                            <td>
                                <a href="javascript:void(0)" onclick="Hapus(<?=$key->id?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
                                <a href="<?= base_url('SPP/LoadReceipt/').$key->id.'?n='.$kode ?>" target="_blank" rel="noopener noreferrer" class="btn btn-success btn-xs"><i class="fa fa-print"></i> Print</a>
                            </td>
                            
                        </tr>
<?php  } ?>
                      
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
    function Hapus(id){
        Swal({
            title: 'Ingin menghapus data?',
            type: 'question',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Ya'
        }).then((result) => {
            if(result.value) {
                $.ajax({
                    url : "<?=base_url($this->uri->segment(1).'/Hapus')?>/"+id,
                    type: "POST",
                    dataType: "JSON",
                    success: function(data){
                        location.reload();
                        sweet('Dihapus !','Berhasil Hapus Data','success');
                    },
                    error: function (jqXHR, textStatus, errorThrown){
                        sweet('Oops...','Gagal Hapus Data','error');
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }
</script>