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
    // kode untuk nominal
    $kode = base64_encode($key->spp.'-'.$key->makan.'-'.$key->air);

    ?>
                        <tr>
                            <td><?=$no++;?></td>
                            <td><?=tanggal($key->tanggal,'bulan').' - '.jam($key->tanggal).' WIB'?></td>
                            <td><?=$key->bulan?></td>
                            <td><?=rupiah($key->nominal)?></td>
                            <td>
                                <a href="javascript:void(0)" onclick="Hapus(<?=$key->id?>)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a>
                                <a href="javascript:void(0)" onclick="Edit(<?=$key->id?>)" class="btn btn-warning btn-xs"><i class="fa fa-edit"></i> Edit</a>
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

<!-- Modal Tambah -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Edit Data</h4>
            </div>
            <div class="modal-body">
                <form action="javascript:void(0)" method="post" id="form-edit">
                    <input type="hidden" name="id" id="id">
                    <input type="hidden" name="id_siswa" id="id_siswa" value="<?=$id?>">
                    <div class="form-group">
                        <label for="tanggal">Tanggal</label>
                        <input type="date" name="tanggal" id="tanggal" class="form-control">
                    </div>
                    <div class="form-group">
                        <button type="button" onclick="prosesEdit()" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
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


    function Edit(id){
        $('#id').val(id);
        $('#modal-form').modal('show');
        $('#tanggal').val('');
    }
    function prosesEdit(){
        $.ajax({
            url : "<?=base_url('SPP/edit')?>",
            type: "POST",
            dataType: "JSON",
            data: $('#form-edit').serialize(),
            success: function(data){
                location.reload();
                sweet('Berhasil !','Berhasil Edit Data','success');
            }
        });
    }
</script>