<?php require_once('../Connections/connect.php'); ?>
<?php include('../inc/fungsi.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$ambil_idppdb_ppdb_report = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_ppdb_report = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_report = sprintf("SELECT * FROM ppdb_biodata, ext_agama, ext_pekerjaan_ortu, ext_program_studi WHERE ext_agama.id_agama = ppdb_biodata.id_agama AND  ext_pekerjaan_ortu.id_pekerjaan_ortu = ppdb_biodata.id_pekerjaan_ayah AND  ext_program_studi.id_program_studi = ppdb_biodata.id_program_studi AND ppdb_biodata.id_ppdb = %s", GetSQLValueString($ambil_idppdb_ppdb_report, "int"));
$ppdb_report = mysql_query($query_ppdb_report, $connect) or die(mysql_error());
$row_ppdb_report = mysql_fetch_assoc($ppdb_report);
$totalRows_ppdb_report = mysql_num_rows($ppdb_report);

$ambil_idppdb_ppdb_nilai = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_ppdb_nilai = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_nilai = sprintf("SELECT * FROM `ppdb_nilai` WHERE `id_ppdb` = %s", GetSQLValueString($ambil_idppdb_ppdb_nilai, "int"));
$ppdb_nilai = mysql_query($query_ppdb_nilai, $connect) or die(mysql_error());
$row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai);
$totalRows_ppdb_nilai = mysql_num_rows($ppdb_nilai);

mysql_select_db($database_connect, $connect);
$query_ppdb_setting = "SELECT * FROM ppdb_setting";
$ppdb_setting = mysql_query($query_ppdb_setting, $connect) or die(mysql_error());
$row_ppdb_setting = mysql_fetch_assoc($ppdb_setting);
$totalRows_ppdb_setting = mysql_num_rows($ppdb_setting);

$ambil_idppdb_pekerjaan_ibu = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_pekerjaan_ibu = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_pekerjaan_ibu = sprintf("SELECT ext_pekerjaan_ortu.nama_pekerjaan FROM ppdb_biodata, ext_pekerjaan_ortu WHERE   ext_pekerjaan_ortu.id_pekerjaan_ortu = ppdb_biodata.id_pekerjaan_ibu AND ppdb_biodata.id_ppdb = %s", GetSQLValueString($ambil_idppdb_pekerjaan_ibu, "int"));
$pekerjaan_ibu = mysql_query($query_pekerjaan_ibu, $connect) or die(mysql_error());
$row_pekerjaan_ibu = mysql_fetch_assoc($pekerjaan_ibu);
$totalRows_pekerjaan_ibu = mysql_num_rows($pekerjaan_ibu);

mysql_select_db($database_connect, $connect);
$query_ppdb_instansi = "SELECT * FROM ppdb_instansi";
$ppdb_instansi = mysql_query($query_ppdb_instansi, $connect) or die(mysql_error());
$row_ppdb_instansi = mysql_fetch_assoc($ppdb_instansi);
$totalRows_ppdb_instansi = mysql_num_rows($ppdb_instansi);
?>

<html>
<head>
<style>
.lineatas{
	top: -10px;
	left: 0px;
	width: 100%;
	height: 2px;
	display: block;
	
}
.logo{
	left: 0px;
	top: 0px;
	width: 90px;
	height: 160px;
	padding: 10px;
	display: block;
	position: relative;
	float:left;
	}
	.logo img{
		width: 90px;
		height:90px;
		position:relative;
	}
.kotakheader{
	top: 5px;
	left: 110px;
	width: 500px;
	height: 140px;
	display:block;
	position: absolute;
	}
	.kotakheader h1{
		line-height:16px;
		margin-top: 8px;
		color: #000;
		font-size: 37px;
	}
	.kotakheader h2{
		line-height:0px;
		font-size: 20px;
	}
	.kotakheader p{
	}
.nomor_code{
	right: 0px;
	top: 20px;
	width: 150px;
	height: 25px;
	display:block;
	position:absolute;
	background-color:#000;
	}
	.nomor_code p{
		margin-top: 4px;
		line-height:4px;
		text-align:center;
		color: #fff;
	}
	.nomor_code span img{
		width: 150px;
	}
.judul_formulir{
	top: 160px;
	width: 100%;
	display: block;
	position: absolute;
	}
	.judul_formulir h2{
		margin-top: 5px;
		text-align: center;
		line-height: 0px;
		font-size: 20px;
	}
.foto{
	right: 15px;
	top: 100px;
	width: 120px;
	height: 160px;
	display: block;
	position: absolute;
	border: 1px solid #000;
	background-image: url(../images/calon/default.png);
	background-size: 120px auto;
	}
	.foto p{
		text-align: center;
		margin-top: 65px;
		margin-left: -3px;
	}

.biodata{
	margin-top: 10px;
	position: relative;	
	}
	.biodata .judul{
		width: auto;
		padding: 4px 10px;
		padding-left: 2px;
		height: 10px;
		display: block;
		border-radius: 0px 0px 0px 0px;
		background-color: #000;
	}
	.biodata h3{
		line-height: 3px;
		font-size:16px;
		margin: 3px;
		color: #fff;
	}
	.biodata table tr td{
		border-bottom: 1px solid #ddd;
		padding:3px;
	}
	.biodata .bold{
		font-weight: bold;
	}


.ttd{
	margin-top: 50px;
	position: relative;	
	}
	.ttd table tr td{
		text-align: center;
	}
	.ttd table tr td small{
		border-top: 1px solid #000;
	}
	.ttd .line{
		width: 180px;
		height:2px;
		margin: 0px;
		margin-left: -10px;
		display:block;
		border-top: 1px solid #000;
	}
.contact{
	bottom: 0px;
	margin: 0px;	
	width: 100%;
	height: 20px;
	display:block;
	position: absolute;
	background-color: #000;
	}
	.contact p{
		color: #fff;
		text-align: center;
		margin: 3px;
		font-size: 12px;
	}
</style>
</head>
<body>
	<div class="lineatas"></div>
    <div class="logo">
    	<img src="../images/<?php echo $row_ppdb_instansi['logo']; ?>"/>
    </div>
    <h3></h3>
    <div class="kotakheader">
    	<h2><?php echo $row_ppdb_setting['judul_kegiatan']; ?></h2>
        <h1><?php echo $row_ppdb_instansi['nama_instansi']; ?></h1>
        <p><?php echo $row_ppdb_instansi['alamat_instansi']; ?></p>
    </div>
    
    <div class="nomor_code">
    	<p>Nomor Pendaftaran</p>
        <span><img src="http://<?php echo $_SERVER['HTTP_HOST'].dirname($_SERVER['PHP_SELF']); ?>/barcode.php?text=<?php echo $row_ppdb_report['nomor_pendaftaran']; ?>"></span>
    </div>
	<div class="judul_formulir">
		<h2><?php echo $row_ppdb_setting['judul_form']; ?> <?php echo $row_ppdb_report['jalur']; ?></h2>
	</div>
	<div class="foto"><p>3x4</p></div>
	<div class="biodata">
		<div class="judul"><h3><?php echo $row_ppdb_setting['h1_01']; ?></h3></div>
		<table width="900" border="0" align="center">
		  <tr>
			<td colspan="5"></td>
		  </tr>
		  <tr>
			<td width="151" class="bold">Tahun Lulus</td>
			<td colspan="4"><?php echo $row_ppdb_report['tahun_lulus']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Nama Lengkap</td>
			<td colspan="4"><?php echo $row_ppdb_report['nama_lengkap']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Program Studi</td>
			<td colspan="4"><?php echo $row_ppdb_report['nama_studi']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Jenis Kelamin</td>
			<td colspan="2"><?php echo $row_ppdb_report['jenis_kelamin']; ?></td>
			<td width="95" class="bold">Agama</td>
			<td width="150"><?php echo $row_ppdb_report['nama']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Tempat Lahir</td>
			<td colspan="4"><?php echo $row_ppdb_report['tempat_lahir']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Tanggal Lahir</td>
			<td colspan="2"><?php echo $row_ppdb_report['tanggal_lahir']; ?></td>
			<td class="bold">Umur</td>
			<td><?php echo $row_ppdb_report['umur']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Alamat Rumah</td>
			<td colspan="4"><?php echo $row_ppdb_report['alamat_rumah']; ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td width="137" class="bold">RT.</td>
			<td width="130"><?php echo substr($row_ppdb_report['rt_rw'],0,2); ?></td>
			<td class="bold">Kecamatan</td>
			<td><?php echo $row_ppdb_report['kecamatan']; ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td class="bold">RW.</td>
			<td><?php echo substr($row_ppdb_report['rt_rw'],3,5); ?></td>
			<td class="bold">Kabupaten</td>
			<td><?php echo $row_ppdb_report['kabupaten']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">No Hp Siswa</td>
			<td colspan="2"><?php echo $row_ppdb_report['no_hp_calon_siswa']; ?></td>
			<td class="bold">Kode Pos</td>
			<td><?php echo $row_ppdb_report['kode_pos']; ?></td>
		  </tr>
		  <tr>
			<td>&nbsp;</td>
			<td class="bold">Tinggi Badam <?php echo $row_ppdb_report['tinggi_badan']; ?>cm</td>
			<td class="bold">Berat Badan <?php echo $row_ppdb_report['berat_badan']; ?>kg</td>
			<td class="bold">Golongan Darah</td>
			<td><?php echo $row_ppdb_report['golongan_darah']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Nama Ayah Kandung</td>
			<td colspan="4"><?php echo $row_ppdb_report['nama_ayah_kandung']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Pekerjaan Ayah Kandung</td>
			<td colspan="4"><?php echo $row_ppdb_report['nama_pekerjaan']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Nama Ibu Kandung</td>
			<td colspan="4"><?php echo $row_ppdb_report['nama_ibu_kandung']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">Pekerjaan Ibu Kandung</td>
			<td colspan="4"><?php echo $row_pekerjaan_ibu['nama_pekerjaan']; ?></td>
		  </tr>
		  <tr>
			<td class="bold">No. HP Orangtua</td>
			<td><?php echo $row_ppdb_report['no_hp_orang_tua']; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td class="bold">Asal Sekolah</td>
			<td colspan="4"><?php echo $row_ppdb_report['asal_sekolah']; ?></td>
		  </tr>
		</table>
	</div>
	<div class="biodata">
		<table width="900" border="0" align="left">
		  <tr>
			<td colspan="2"><div class="judul"><h3><?php echo $row_ppdb_setting['h1_02']; ?></h3></div></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td colspan="2"><div class="judul"><h3><?php echo $row_ppdb_setting['h1_03']; ?></h3></div></td>
		  </tr>
		  <tr>
			<td width="183" class="bold">Matematika</td>
			<td width="50"><?php echo $row_ppdb_nilai['mapel_matematika']; ?></td>
			<td width="120">&nbsp;</td>
			<td width="60">&nbsp;</td>
			<td width="192" class="bold">Piagam Prestasi</td>
			<td width="60"><?php echo yesno($row_ppdb_report['piagam_prestasi']); ?></td>
		  </tr>
		  <tr>
			<td class="bold">Bahasa Indonesia</td>
			<td><?php echo $row_ppdb_nilai['mapel_bindonesia']; ?></td>
			<td class="bold" align="center">Total Nilai UN</td>
			<td>&nbsp;</td>
			<td class="bold">FC. Raport Smt 1-5</td>
			<td><?php echo yesno($row_ppdb_report['fc_raport']); ?></td>
		  </tr>
		  <tr>
			<td class="bold">Bahasa Inggris</td>
			<td><?php echo $row_ppdb_nilai['mapel_binggris']; ?></td>
			<td class="bold" align="center"><?php echo $row_ppdb_nilai['total_nilai']; ?></td>
			<td>&nbsp;</td>
			<td class="bold">Ijasah</td>
			<td><?php echo yesno($row_ppdb_report['ijasah']); ?></td>
		  </tr>
		  <tr>
			<td class="bold">Ilmu Pengetahuan Alam</td>
			<td><?php echo $row_ppdb_nilai['mapel_ilmupengetahuanalam']; ?></td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
			<td class="bold">SKHUN</td>
			<td><?php echo yesno($row_ppdb_report['skhun']); ?></td>
		  </tr>
		</table>
	</div>
	<div class="ttd">
		<table width="900" border="0" align="center">
		  <tr>
			<td width="300">Mengetahui,</td>
			<td width="61">&nbsp;</td>
			<td width="300">Banjarnegara, <?php echo $row_ppdb_report['tanggal_daftar'],3; ?></td>
		  </tr>
		  <tr>
			<td>Orang Tua/Wali Calon Siswa</td>
			<td>&nbsp;</td>
			<td>Pendaftar</td>
		  </tr>
		  <tr>
			<td height="50">&nbsp;</td>
			<td>&nbsp;</td>
			<td>&nbsp;</td>
		  </tr>
		  <tr>
			<td><?php echo $row_ppdb_report['mengetahui']; ?></td>
			<td>&nbsp;</td>
			<td><?php echo $row_ppdb_report['nama_lengkap']; ?></td>
		  </tr>
		  <tr>
			<td><div class="line"><small>Tanda tangan dan Nama Terang</small></div></td>
			<td>&nbsp;</td>
			<td><div class="line"><small>Tanda tangan dan Nama Terang</small></div></td>
		  </tr>
		</table>
	</div>
	<div class="contact">
		<p>
			<?php echo $row_ppdb_setting['footer']; ?>
		</p>
	</div>
</body>
<?php
mysql_free_result($ppdb_report);

mysql_free_result($ppdb_setting);

mysql_free_result($pekerjaan_ibu);

mysql_free_result($ppdb_instansi);
?>
