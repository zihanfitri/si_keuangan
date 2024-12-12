<div class="row">
    <div class="col-md-12">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Detail Uang Jajan <strong><?= $this->db->get_where('siswa', array('id' => $id_siswa))->row('name') ?></strong> </h3>
                <div style="display:flex; justify-content:flex-end">
                    <a href="<?php echo site_url('Jajan'); ?>" class="btn btn-primary">Kembali</a>
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
                    '</tr>';
            no++;
        }
        $('#tabel-detail tbody').html(html);
    },
    error: function (jqXHR, textStatus, errorThrown) {
        alert('Error get data from ajax');
    }
});



</script>
