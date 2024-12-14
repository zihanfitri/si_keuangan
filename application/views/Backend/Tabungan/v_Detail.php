<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Tabungan <strong><?= $this->db->get_where('siswa', array('id' => $id_siswa))->row('name') ?></strong> </h3>
                <div style="display:flex; justify-content:flex-end">
                    <a href="<?php echo site_url('Tabungan'); ?>" class="btn btn-primary">Kembali</a>
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
    url : "<?php echo site_url('Tabungan/getDetail/'). $id_siswa?>",
    type: "GET",
    dataType: "JSON",
    data: {id_siswa: <?= $id_siswa ?>},
    success: function(data) {
        console.log(data);
        var html = '';
        var no = 1;
        var saldo = 0;
        for (var i = 0; i < data.length; i++) {
            var nominal = data[i].nominal.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".");
            var status = data[i].status;
            if (status == 1) {
                var masuk = nominal;
                var keluar = '-';
                saldo += parseInt(nominal.replace(/\./g, '')); // Tambahkan nominal ke saldo

            } else {
                var masuk = '-';
                var keluar = nominal;
                saldo -= parseInt(nominal.replace(/\./g, '')); // Kurangkan nominal dari saldo

            }
            html += '<tr>' +
                        '<td>' + data[i].tanggal + '</td>' +
                        '<td>' + 'Rp ' + masuk + '</td>' +
                        '<td>' + 'Rp ' + keluar + '</td>' +
                        '<td>' + 'Rp ' + saldo.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") + '</td>' +
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
