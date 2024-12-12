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
        </div>
    </div>