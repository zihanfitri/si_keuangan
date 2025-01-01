<script>
// mengasumsikan Anda menggunakan jQuery
$(document).ready(function() {
$('.confirm-div').hide();
<?php if($this->session->flashdata('pesan')){ ?>
Swal.fire({
  title: 'Pesan',
  text: '<?php echo $this->session->flashdata('pesan'); ?>',
  icon: 'info',
  confirmButtonText: 'OK'
});
<?php } ?>
});
</script>



<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-aqua"><i class="glyphicon glyphicon-inbox"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Saldo UMUM</span>
            <span class="info-box-number"><small><?=rupiah($umum)?></small></span>
        </div>
    </div>
</div>
<div class="col-md-4 col-sm-6 col-xs-12">
    <div class="info-box">
        <span class="info-box-icon bg-green"><i class="glyphicon glyphicon-import"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Saldo Jajan</span>
            <span class="info-box-number"><small><?=rupiah($jajan)?></small></span>
        </div>
    </div>
</div>
<div class="clearfix visible-sm-block"></div>
<div class="col-md-4 col-sm-6 col-xs-12">
	<div class="info-box">
        <span class="info-box-icon bg-red"><i class="glyphicon glyphicon-export"></i></span>
        <div class="info-box-content">
            <span class="info-box-text">Saldo Tabungan</span>
            <span class="info-box-number"><small><?=rupiah($tabungan)?></small></span>
        </div>
    </div>
</div>

<div class="col-xs-12">
    <div class="box box-danger">
        <div class="box-header"> 
        	<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
           	</div>
        </div>
        <div class="box-body text-center">
            <div class="jumbotron jumbotron-fluid" style="background-color:white;">
                <div class="container">
                 	<img style="width: 15%" src="<?=base_url('assets/dist/img/logo_al_muhajirin.png')?>">
                    <h2 class="display-4 text-blue">SISTEM INFORMASI KEUANGAN</h2>
                    <p class="lead text-primary">PONDOK PESANTREN MODERN AL-MUHAJIRIN</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="col-xs-12">
    <div class="box box-danger">
        <div class="box-header"> 
        	<div class="box-tools pull-right">
                <button type="button" class="btn btn-box-tool" data-widget="collapse"><i class="fa fa-plus"></i></button>
                <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i></button>
           	</div>
        </div>
        <div class="box-body">
            <div class="jumbotron jumbotron-fluid" style="background-color:white;">
                <div class="container">
                <div class="form-group">
                        <input type="text" class="form-control" id="cariSantri" placeholder="Cari Nama Santri..." onkeydown="if (event.keyCode == 13) cariSantri();">
                        <button type="button" class="btn btn-primary" onclick="cariSantri()">Cari</button>
                        
                </div>
				</div>
				<table class="table table-bordered table-striped" style="margin-top: 10px;">
					<thead>
						<tr>
							<th>No</th>
							<th>Nama</th>
							<th>Kelas</th>
							<th>Saldo Jajan</th>
							<th>Saldo Tabungan</th>
						</tr>
					</thead>
					<tbody id="hasilCari">
					</tbody>
				</table>
				<div id="tombol">
				</div>
            </div>
        </div>
    </div>
</div>

	<div class="col-xs-12">
		<div class="col-lg-4 col-xs-6 text-left">
	          	<div class="small-box bg-aqua">
	            	<div class="inner">
	              		<?php $count = $this->M_General->countAll('guru') ?>
	              		<h3><?=$count?></h3>
	              		<p>Data Guru</p>
	            	</div>
	            	<div class="icon">
	              		<i class="fa fa-graduation-cap"></i>
	            	</div>
	            	<a href="<?=base_url('Guru')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	            </div>
        	</div>
            <div class="col-lg-4 col-xs-6 text-left">
	          	<div class="small-box bg-yellow">
	            	<div class="inner">
	              		<?php $count = $this->M_General->countAll('kelas') ?>
	              		<h3><?=$count?></h3>
	              		<p>Data Kelas</p>
	            	</div>
	            	<div class="icon">
	              		<i class="fa fa-institution"></i>
	            	</div>
	            	<a href="<?=base_url('Kelas')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	            </div>
        	</div>
            <div class="col-lg-4 col-xs-6 text-left">
	          	<div class="small-box bg-blue">
	            	<div class="inner">
	              		<?php $count = $this->M_General->countAll('siswa') ?>
	              		<h3><?=$count?></h3>
	              		<p>Data Santri</p>
	            	</div>
	            	<div class="icon">
	              		<i class="fa fa-users"></i>
	            	</div>
	            	<a href="<?=base_url('Siswa')?>" class="small-box-footer">More info <i class="fa fa-arrow-circle-right"></i></a>
	            </div>
        	</div>


<script>
	function cariSantri(){
		if($('#cariSantri').val() == ''){
			Swal.fire({
				icon: 'error',
				title: 'Oops...',
				text: 'Form pencarian tidak boleh kosong!'
			});
			return;
		}
		$('#hasilCari').empty(); // Reset hasil sebelumnya
		$.ajax({
			url : "<?=base_url('Beranda/cariSantri')?>",
			type: "POST",
			data: {cari: $('#cariSantri').val()},
			success: function(data){
				if(data.length == 0){
					$('#hasilCari').append('<tr><td colspan="3">Tidak ada data yang ditemukan.</td></tr>');
				}
				$.each(data, function(index, item){
					var url = '<?= base_url('uploads/')?>'
					$('#hasilCari').append(`
					<tr>
						<td>`+(index+1)+`</td>
						<td><img src="`+url+item.foto+`" alt="Foto Profil" width="40" height="40" style="border-radius:50%"> `+item.name+`</td>
						<td>`+item.nama+`</td>
						data ? 'Rp ' + data.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 'Rp 0'
						<td>Rp `+(item.saldo_jajan ? item.saldo_jajan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 'Rp 0')+`</td>
						<td>Rp `+(item.saldo_tabungan ? item.saldo_tabungan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ".") : 'Rp 0')+`</td>
					</tr>
					<tr>
						<td colspan="5">
							<div class="col-xs-12" style="margin-top: 10px;">
								<button class="btn btn-primary" onclick="detailSantri(`+item.id+`,'jajan')">
									<i class="fa fa-money"></i><span class="text-white"> Jajan</span>
								</button>
								<button class="btn btn-warning" onClick="detailSantri(`+item.id+`,'tabungan')">
									<i class="fa fa-money"></i><span class="text-white"> Tabungan</span>
								</button>
								<button class="btn btn-success" onClick="detailSantri(`+item.id+`,'spp')">
									<i class="fa fa-money"></i><span class="text-white"> SPP</span>
								</button>
							</div>
						</td>
					</tr>`);
				});
			}
		});
		$('#cariSantri').val(''); // Reset input setelah pencarian
	}
	function detailSantri(id, jenis){
		$.ajax({
			url: "<?=base_url('Beranda/detailSantri')?>/" + id,
			type: "GET",
			success: function(data){
				if(jenis == 'jajan'){
					title = 'Data Jajan Santri';
					url = '<?=base_url('Beranda/SimpanJajan')?>';
					Swal.fire({
				title: title,
				html: `
				<form id="form-jajan" method="post" action="`+url+`">
                <div class="modal-body">
                    <input type="hidden" name="id_siswa" value="`+data.santri.id+`" id="id">
                    <div class="form-group">
                        <label>Santri</label>
                        <input type="text" class="form-control" id="nama" name="nama" value="`+data.santri.name+`" required>
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
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                </div>
            </form>
				`,
				showCancelButton: false,
				showConfirmButton:false, 
			});
				}else if(jenis == 'tabungan'){
					title = 'Data Tabungan Santri';
					url = '<?=base_url('Beranda/SimpanTabungan')?>';
					Swal.fire({
					title: title,
					html: `
					<form id="form-jajan" method="post" action="`+url+`">
					<div class="modal-body">
						<input type="hidden" name="id_siswa" value="`+data.santri.id+`" id="id">
						<div class="form-group">
							<label>Santri</label>
							<input type="text" class="form-control" id="nama" name="nama" value="`+data.santri.name+`" required>
						</div>
						<div class="form-group">
                        <label>Jenis Transaksi</label>
                        <div class="form-group">
							<input type="radio" name="jenis_transaksi" id="uang_masuk" value="masuk"> <label for="uang_masuk">Uang Masuk</label>
							<input type="radio" name="jenis_transaksi" id="uang_keluar" value="keluar"> <label for="uang_keluar">Uang Keluar</label>
						</div>
						</div>
						<div class="form-group">
							<label>Nominal</label>
							<input type="number" class="form-control" id="nominal" name="nominal" required>
						</div>
					</div>
					<div class="modal-footer">
                    	<button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                	</div>
					</form>
						`,
						showCancelButton: false,
						showConfirmButton:false, 
					});
				}else if(jenis == 'spp'){
					title = 'Data SPP Santri';
					url = '<?=base_url('Beranda/SimpanSPP')?>';
					Bayar(data.santri.id);
					
					Swal.fire({
					title: title,
					html: `
					<form id="form-jajan" method="post" action="`+url+`">
					<div class="modal-body">
						<input type="hidden" name="id_siswa" value="`+data.santri.id+`" id="id">
						<div class="form-group">
							<label>Santri</label>
							<input type="text" class="form-control" id="nama" name="nama" value="`+data.santri.name+`" required>
						</div>
						<div class="form-group">
							<label class="control-label">Bulan Pembayaran</label>
							<select name="bulan" required="" data-placeholder="--Pilih--" class="form-control">
								<option value="">--Pilih--</option>
								<?php $t = Date('Y'); 
									$b = array('Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember');
								?>
							<?php foreach ($b as $i) { ?>
								<option value="<?=$i.'-'.$t?>"><?=$i.'-'.$t?></option>
							<?php } ?>
							</select>
						</div>

						<div class="form-group">
							<label class="control-label">Jenis Pembayaran</label>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="spp"> SPP ( <span class="spp"></span> )
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="makan"> Makan ( <span class="makan"></span> )
								</label>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="air"> Air ( <span class="air"></span> )
								</label>
							</div>
						</div>
					</div>
					<div class="modal-footer">
                    	<button type="submit" class="btn btn-primary" id="btn-simpan">Simpan</button>
                	</div>
					</form>
						`,
						showCancelButton: false,
						showConfirmButton:false, 
					});
				}
				
			}
		});
	}

	function formatRupiah(angka, prefix){
	var number_string = angka.replace(/[^,\d]/g, '').toString(),
	split   		= number_string.split(','),
	sisa     		= split[0].length % 3,
	rupiah     		= split[0].substr(0, sisa),
	ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
 
	// tambahkan titik jika yang di input sudah menjadi angka ribuan
	if(ribuan){
		separator = sisa ? '.' : '';
		rupiah += separator + ribuan.join('.');
	}
 
	rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
	return prefix == undefined ? rupiah : (rupiah ? 'Rp. ' + rupiah : '');
}

function Bayar(id){

        $.ajax({

            url: "<?=base_url('SPP/GetSPP/')?>"+id,
            type:"GET",
            dataType:"JSON",
            success:function(data){
                
                $('[name="id"]').val(id);
                $('[name="spp"]').val(data.spp);
                $('.spp').text('Rp ' + data.spp.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('[name="makan"]').val(data.makan);
                $('.makan').text('Rp ' + data.makan.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                $('[name="air"]').val(data.air);
                $('.air').text('Rp ' + data.air.toString().replace(/\B(?=(\d{3})+(?!\d))/g, "."));
                if(data.dispen == 0){
                    $('[name="spp"]').prop('checked', true);
                    $('[name="makan"]').prop('checked', true);
                    $('[name="air"]').prop('checked', true);
                }
            }
        });

    }

</script>

