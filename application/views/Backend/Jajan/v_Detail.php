<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Uang Jajan <strong><?= $this->db->get_where('siswa', array('id' => $id_siswa))->row('name') ?></strong> </h3>
                <div class="row">
                    <div class="col-md-3">
                        <form action="<?= base_url('Jajan/print')?>" method="post">                            
                            <input type="hidden" name="id_siswa" value="<?= $this->uri->segment(3) ?>">
                            <input type="text" name="tanggal" class="form-control datepicker" autocomplete="off" placeholder="Tanggal">
                            <button type="submit" onclick="_blank" class="btn btn-sm btn-success">Print</button>
                        </form>
                    </div>
                </div>
                <div style="display:flex; justify-content:flex-end">
                    <a href="<?php echo site_url('Jajan'); ?>" class="btn btn-sm btn-primary">Kembali</a>
                </div>
            </div>
            <div class="box-body">
                <table id="tabel-detail" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Masuk</th>
                            <th>Keluar</th>
                            <th>Saldo</th>
                            <th>Keterangan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script>
$.ajax({
    url : "<?php echo site_url('Jajan/getDetail/'). $id_siswa?>",
    type: "GET",
    dataType: "JSON",
    data: {id_siswa: <?= $id_siswa ?>},
    success: function(data) {
        console.log(data);
        var html = '';
        var no = 1;
        var saldo = 0;
        for (var i = 0; i < data.length; i++) {
            if (data[i].masuk != 0) {
                saldo += parseInt(data[i].masuk);
            } else {
                saldo -= parseInt(data[i].keluar);
            }
            html += '<tr>' +
                        '<td>' + data[i].tanggal + '</td>' +
                        '<td>' + (data[i].masuk != 0 ? 'Rp ' + data[i].masuk.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 'Rp 0') + '</td>' +
                        '<td>' + (data[i].keluar != 0 ? 'Rp ' + data[i].keluar.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 'Rp 0') + '</td>' +
                        '<td>' + 'Rp ' + saldo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '</td>' +
                        '<td>' + data[i].keterangan + '</td>' +
                        '<td><a href="javascript:void(0)" onclick="Hapus('+data[i].id+','+data[i].id_siswa+')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> Hapus</a></td>' +
                    '</tr>';
            no++;
        }
        $('#tabel-detail tbody').html(html);
    },
    error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
    }
});

function Hapus(id, id_siswa){
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
                    url : "<?=base_url($this->uri->segment(1).'/Hapus')?>/"+id+"/"+id_siswa,
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
