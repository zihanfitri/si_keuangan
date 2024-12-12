<?php $aktif = $this->uri->segment(1); ?>
<ul class="sidebar-menu" data-widget="tree">
    <li class="header">MENU UTAMA</li>
    <li class = "<?php echo activate_menu('Beranda')?>"><a href="<?= base_url()?>Beranda"><i class="fa fa-dashboard"></i> <span>Beranda</span><span class="pull-right-container"></span></a></li>
    <li class="treeview <?php if ($aktif == 'Guru' || $aktif == 'Siswa' || $aktif == 'Kelas' || $aktif == 'Transaksi' || $aktif == 'Tanggal') echo 'active' ?>">
        <a href="#"><i class="fa fa-database"></i> <span>Data Master</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li class = "<?php echo activate_menu('Guru')?>"><a href="<?= base_url()?>Guru"><i class="fa fa-circle-o"></i>Data Guru</a></li>
            <li class = "<?php echo activate_menu('Kelas')?>"><a href="<?= base_url()?>Kelas"><i class="fa fa-circle-o"></i>Data Kelas</a></li>
            <li class = "<?php echo activate_menu('Siswa')?>"><a href="<?= base_url()?>Siswa"><i class="fa fa-circle-o"></i>Data Santri</a></li>
            <li class = "<?php echo activate_menu('Transaksi')?>"><a href="<?= base_url()?>Transaksi"><i class="fa fa-circle-o"></i>Jenis Transaksi</a></li>
            <li class = "<?php echo activate_menu('Tanggal')?>"><a href="<?= base_url()?>Tanggal"><i class="fa fa-circle-o"></i>Tanggal Merah</a></li>
        </ul>
    </li>
    <li class="header">KAS UMUM</li>
    <li class="treeview <?php if ($aktif == 'SPP' || $aktif == 'Pendaftaran' || $aktif == 'Ujian' || $aktif == 'Snack' || $aktif == 'Catering' || $aktif == 'Lainnya' ) echo 'active' ?>">
        <a href="#"><i class="fa fa-arrow-down"></i> <span>Kas Masuk</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <!-- <li class = "<?php echo activate_menu('Pendaftaran')?>"><a href="<?= base_url()?>Pendaftaran"><i class="fa fa-circle-o"></i>Pendaftaran</a></li> -->
            <li class = "<?php echo activate_menu('SPP')?>"><a href="<?= base_url()?>SPP"><i class="fa fa-circle-o"></i>Uang SPP</a></li>
            <!-- <li class = "<?php echo activate_menu('Ujian')?>"><a href="<?= base_url()?>Ujian"><i class="fa fa-circle-o"></i>Uang Ujian</a></li> -->
            <!-- <li class = "<?php echo activate_menu('Snack')?>"><a href="<?= base_url()?>Snack"><i class="fa fa-circle-o"></i>Uang Snack</a></li> -->
            <!-- <li class = "<?php echo activate_menu('Catering')?>"><a href="<?= base_url()?>Catering"><i class="fa fa-circle-o"></i>Uang Catering</a></li> -->
             <li class = "<?php echo activate_menu('Lainnya')?>"><a href="<?= base_url()?>Lainnya"><i class="fa fa-circle-o"></i>Pemasukan Lainnya</a></li>
        </ul>
    </li>
    <li class="treeview <?php if ($aktif == 'Gaji' || $aktif == 'Pengeluaran') echo 'active' ?>">
        <a href="#"><i class="fa fa-arrow-up"></i> <span>Kas Keluar</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
            <li class = "<?php echo activate_menu('Gaji')?>"><a href="<?= base_url()?>Gaji"><i class="fa fa-circle-o"></i>Pembayaran Gaji</a></li>
             <li class = "<?php echo activate_menu('Pengeluaran')?>"><a href="<?= base_url()?>Pengeluaran"><i class="fa fa-circle-o"></i>Pengeluaran Lainnya</a></li>
        </ul>
    </li>

    <li class="header">KAS JAJAN</li>   
    <li class = "<?php echo activate_menu('Jajan')?>"><a href="<?= base_url()?>Jajan"><i class="fa fa-money"></i> <span>Kas Jajan</span><span class="pull-right-container"></span></a></li>

    
    <li class="header">KAS TABUNGAN</li>
    <li class = "<?php echo activate_menu('Tabungan')?>"><a href="<?= base_url()?>Tabungan"><i class="fa fa-book"></i> <span>Kas Tabungan</span><span class="pull-right-container"></span></a></li>


    <li class="header">LAPORAN</li>
    <li class="treeview <?php if ($aktif == 'Laporan' || $aktif == 'Laporan_jajan'|| $aktif == 'Laporan_tabungan') echo 'active'  ?>">
        <a href="#"><i class="fa fa-line-chart"></i> <span>Laporan</span>
            <span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span>
        </a>
        <ul class="treeview-menu">
             <li class = "<?php echo activate_menu('Laporan')?>"><a href="<?= base_url()?>Laporan"><i class="fa fa-line-chart"></i> <span>Laporan Kas Umum</span><span class="pull-right-container"></span></a></li>
             <li class = "<?php echo activate_menu('Laporan_jajan')?>"><a href="<?= base_url()?>Laporan_jajan"><i class="fa fa-line-chart"></i> <span>Laporan Jajan</span><span class="pull-right-container"></span></a></li>
             <li class = "<?php echo activate_menu('Laporan_tabungan')?>"><a href="<?= base_url()?>Laporan_tabungan"><i class="fa fa-line-chart"></i> <span>Laporan Tabungan</span><span class="pull-right-container"></span></a></li>
        </ul>
    </li>
</ul>