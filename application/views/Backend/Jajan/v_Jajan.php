<div class="col-xs-12">
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Data Kas Jajan</h3>
            <div class="pull-right">
                <button class="btn btn-primary btn-sm" onclick="tambah()">
                    <i class="fa fa-plus"></i> Tambah
                </button>
            </div>
        </div>
        <div class="box-body">
            <div class="table-responsive">
                <table id="list-data" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Tanggal</th>
                            <th>Santri</th>
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

<!-- Modal Tambah/Edit -->
<div class="modal fade" id="modal-form">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title"></h4>
            </div>
            <form id="form-jajan" method="post">
                <div class="modal-body">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label>Santri</label>
                        <select class="form-control select2" id="id_siswa" name="id_siswa" style="width: 100%;" required>
                            <option value="">Pilih Santri</option>
                            <?php foreach($siswa as $s): ?>
                                <option value="<?php echo $s->id; ?>"><?php echo $s->name; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="control-label"> Tanggal</label>
                        <div><input type="text" placeholder="Tanggal Jajan" autocomplete="off" name="tanggal" class="form-control datepicker"></div>
                    </div>
                        
                    <div class="form-group">
                        <label>Jenis Transaksi</label><br>
                        <input type="radio" name="jenis_transaksi" id="uang_masuk" value="masuk"> <label for="uang_masuk">Uang Masuk</label>
                        <input type="radio" name="jenis_transaksi" id="uang_keluar" value="keluar"> <label for="uang_keluar">Uang Keluar</label>
                    </div>
                    <div class="form-group">
                        <label>Nominal</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" required>
                    </div>
                    <div class="form-group">
                        <label>Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
	var label;
	var table;

$(document).ready(function() {
    $.fn.dataTableExt.oApi.fnPagingInfo = function(oSettings){
            return {
                "iStart": oSettings._iDisplayStart,
                "iEnd": oSettings.fnDisplayEnd(),
                "iLength": oSettings._iDisplayLength,
                "iTotal": oSettings.fnRecordsTotal(),
                "iFilteredTotal": oSettings.fnRecordsDisplay(),
                "iPage": Math.ceil(oSettings._iDisplayStart / oSettings._iDisplayLength),
                "iTotalPages": Math.ceil(oSettings.fnRecordsDisplay() / oSettings._iDisplayLength)
            };
        };

    load_data ();

    function load_data(is_kelas){

       table =  $("#list-data").DataTable({
            initComplete: function() {
                var api = this.api();
                $('#list-data input')
                    .off('.DT')
                    .on('keyup.DT', function(e) {
                        api.search(this.value).draw();
                    });
            },
            oLanguage: {
                sSearch       :"<i class='fa fa-search fa-fw'></i> Cari: ",
                sLengthMenu   :"Tampilkan _MENU_ data",
                sInfo         :"Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                sInfoFiltered :"(disaring dari _MAX_ total data)", 
                sZeroRecords  :"Oops..data kosong", 
                sEmptyTable   :"Data kosong.", 
                sInfoEmpty    :"Menampilkan 0 sampai 0 data",
                sProcessing   :"Sedang memproses...", 
                oPaginate: {
                    sPrevious :"Sebelumnya",
                    sNext     :"Selanjutnya",
                    sFirst    :"Pertama",
                    sLast     :"Terakhir"
                }
            },
            processing: true,
            serverSide: true,
            ajax: {
                "url": "<?= base_url().$this->uri->segment(1).'/getData'?>",
                "type": "POST",
                "data":{is_kelas : is_kelas }
            },
            columns: [
                {
                    "data": "id",
                    "orderable": false,
                    "searchable": false
                },
                {"data": "tanggal"},
                {"data": "name",
                    "render": function(data, type, row) {
                        var url = '<?= base_url('uploads/') ?>'
                        return '<img src="'+url+''+ row.foto + '" alt="Foto Profil" width="50" height="50" style="border-radius:50%"> ' + data;
                    }
                },
                {"data": "saldo", "render": function(data, type, row) {
                    return data ? 'Rp ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 'Rp 0';
                }},
                {"data": "keterangan"},
                {
                    "data": "view",
                    "orderable": false,
                    "searchable": false
                }
            ],
            order: [[1, 'asc']],
            rowId: function(a){
                return a;
            },
            rowCallback: function(row, data, iDisplayIndex) {
                var info = this.fnPagingInfo();
                var page = info.iPage;
                var length = info.iLength;
                var index = page * length + (iDisplayIndex + 1);
                $('td:eq(0)', row).html(index);
            }
        });
    }
});

function tambah() {
    $('#form-jajan')[0].reset();
    $('.modal-title').text('Tambah Data Jajan');
    $('#modal-form').modal('show');
}

function edit(id) {
    $.ajax({
        url : "<?php echo site_url('Jajan/edit/')?>/" + id,
        type: "GET",
        dataType: "JSON",
        success: function(data) {
            $('[name="id"]').val(data.id);
            $('[name="tanggal"]').val(data.tanggal);
            $('[name="nominal"]').val(data.nominal);
            $('[name="keterangan"]').val(data.keterangan);
            
            $('.modal-title').text('Edit Data Jajan');
            $('#modal-form').modal('show');
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error get data from ajax');
        }
    });
}
function detail(id) {
    document.location.href= "<?php echo base_url('Jajan/Detail/')?>"+id;
}


$('#form-jajan').submit(function(e) {
    e.preventDefault();
    var url;
    if($('#id').val() == '') {
        url = "<?php echo site_url('Jajan/Simpan')?>";
    } else {
        url = "<?php echo site_url('Jajan/Update')?>";
    }
    $.ajax({
        url : url,
        type: "POST",
        data: $('#form-jajan').serialize(),
        dataType: "JSON",
        success: function(data) {
            if(data.status) {
                $('#modal-form').modal('hide');
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: 'Data jajan berhasil disimpan!',
                });
                reload_table();
            } else {
                for (var i = 0; i < data.inputerror.length; i++) {
                    $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error');
                    $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]);
                }
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            alert('Error adding / update data');
        }
    });
});

function reload_table() {
    table.ajax.reload(null,false);
}
</script>
