<?php require_once('../Connections/connect.php'); ?>
<?php include('auth.php'); ?>
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

$ambil_idppdb_ppdb_all = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_ppdb_all = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_all = sprintf("SELECT * FROM ppdb_biodata, ext_agama, ext_pekerjaan_ortu, ext_program_studi WHERE ext_agama.id_agama = ppdb_biodata.id_agama AND  ext_pekerjaan_ortu.id_pekerjaan_ortu = ppdb_biodata.id_pekerjaan_ayah AND  ext_pekerjaan_ortu.id_pekerjaan_ortu = ppdb_biodata.id_pekerjaan_ibu AND  ext_program_studi.id_program_studi = ppdb_biodata.id_program_studi AND ppdb_biodata.id_ppdb = %s", GetSQLValueString($ambil_idppdb_ppdb_all, "int"));
$ppdb_all = mysql_query($query_ppdb_all, $connect) or die(mysql_error());
$row_ppdb_all = mysql_fetch_assoc($ppdb_all);
$totalRows_ppdb_all = "-1";
if (isset($_GET['id_ppdb'])) {
  $totalRows_ppdb_all = $_GET['id_ppdb'];
}
$ambil_idppdb_ppdb_all = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_ppdb_all = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_all = sprintf("SELECT * FROM ppdb_biodata, ext_agama, ext_pekerjaan_ortu, ext_program_studi WHERE  ext_agama.id_agama = ppdb_biodata.id_agama AND  ext_pekerjaan_ortu.id_pekerjaan_ortu = ppdb_biodata.id_pekerjaan_ayah AND  ext_program_studi.id_program_studi = ppdb_biodata.id_program_studi AND ppdb_biodata.id_ppdb = %s", GetSQLValueString($ambil_idppdb_ppdb_all, "int"));
$ppdb_all = mysql_query($query_ppdb_all, $connect) or die(mysql_error());
$row_ppdb_all = mysql_fetch_assoc($ppdb_all);
$totalRows_ppdb_all = mysql_num_rows($ppdb_all);

$ambil_idppdb_ppdb_nilai = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_ppdb_nilai = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_nilai = sprintf("SELECT * FROM `ppdb_nilai` WHERE `id_ppdb` = %s", GetSQLValueString($ambil_idppdb_ppdb_nilai, "int"));
$ppdb_nilai = mysql_query($query_ppdb_nilai, $connect) or die(mysql_error());
$row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai);
$totalRows_ppdb_nilai = mysql_num_rows($ppdb_nilai);

$ambil_idppdb_ppdb_prestasi = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_ppdb_prestasi = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_prestasi = sprintf("SELECT * FROM `ppdb_prestasi` WHERE `id_ppdb` = %s", GetSQLValueString($ambil_idppdb_ppdb_prestasi, "int"));
$ppdb_prestasi = mysql_query($query_ppdb_prestasi, $connect) or die(mysql_error());
$row_ppdb_prestasi = mysql_fetch_assoc($ppdb_prestasi);
$totalRows_ppdb_prestasi = mysql_num_rows($ppdb_prestasi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pengesahan Data</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="nav">
    <table width="73%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include('../inc/header.php') ?></td>
  </tr>
</table>
</div>
<br />
<br />
<br />
<br />
<table width="1000" border="0" align="center">
  <tr>
    <td>Tahun Lulus</td>
    <td><?php echo $row_ppdb_all['tahun_lulus']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Lengkap</td>
    <td><?php echo $row_ppdb_all['nama_lengkap']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Program Studi</td>
    <td><?php echo $row_ppdb_all['nama_studi']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Jenis Kelamin</td>
    <td><?php echo $row_ppdb_all['jenis_kelamin']; ?></td>
    <td align="right">Agama</td>
    <td><?php echo $row_ppdb_all['nama']; ?></td>
  </tr>
  <tr>
    <td>Tempat Lahir</td>
    <td><?php echo $row_ppdb_all['tempat_lahir']; ?></td>
    <td align="right">Umur</td>
    <td><?php echo $row_ppdb_all['umur']; ?></td>
  </tr>
  <tr>
    <td>Tanggal Lahir</td>
    <td><?php echo $row_ppdb_all['tanggal_lahir']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Alamat Rumah</td>
    <td><?php echo $row_ppdb_all['alamat_rumah']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>RT. / RW.</td>
    <td><?php echo $row_ppdb_all['rt_rw']; ?></td>
    <td align="right">Kecamatan</td>
    <td><?php echo $row_ppdb_all['kecamatan']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td align="right">Kabupaten</td>
    <td><?php echo $row_ppdb_all['kabupaten']; ?></td>
  </tr>
  <tr>
    <td>No. HP Calon Siswa</td>
    <td><?php echo $row_ppdb_all['no_hp_calon_siswa']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Tinggi Badan <?php echo $row_ppdb_all['tinggi_badan']; ?></td>
    <td align="right">Berat Badan <?php echo $row_ppdb_all['berat_badan']; ?></td>
    <td>Golongan Darah <?php echo $row_ppdb_all['golongan_darah']; ?></td>
  </tr>
  <tr>
    <td>Nama Ayah Kandung</td>
    <td><?php echo $row_ppdb_all['nama_ayah_kandung']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pekerjaan Ayah Kandung</td>
    <td><?php echo $row_ppdb_all['nama_pekerjaan']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Nama Ibu Kandung</td>
    <td><?php echo $row_ppdb_all['nama_ibu_kandung']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Pekerjaan Ibu Kandung</td>
    <td><?php echo $row_ppdb_all['id_pekerjaan_ibu']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>No. HP Orang Tua</td>
    <td><?php echo $row_ppdb_all['no_hp_orang_tua']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Asal Sekolah</td>
    <td><?php echo $row_ppdb_all['asal_sekolah']; ?></td>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right">Apakah Data Sah?</td>
    <td><input name="sah_biodata" type="checkbox" id="sah_biodata" value="1" />
    <label for="sah_biodata"></label></td>
  </tr>
</table>
<br/>
<table width="1000" border="1" align="center">
  <tr>
    <td width="150">Matematika</td>
    <td width="253"><?php echo $row_ppdb_nilai['mapel_matematika']; ?></td>
    <td width="249" align="center">&nbsp;</td>
    <td width="131" align="right">Piagam Prestasi</td>
    <td width="183"><?php echo $row_ppdb_all['piagam_prestasi']; ?></td>
  </tr>
  <tr>
    <td>Bahasa Indonesia</td>
    <td><?php echo $row_ppdb_nilai['mapel_bindonesia']; ?></td>
    <td align="center">Total NIlai UN</td>
    <td align="right">FC. Raport Smt 1-5</td>
    <td><?php echo $row_ppdb_all['fc_raport']; ?></td>
  </tr>
  <tr>
    <td>Bahasa Inggris</td>
    <td><?php echo $row_ppdb_nilai['mapel_binggris']; ?></td>
    <td align="center"><?php echo $row_ppdb_nilai['total_nilai']; ?></td>
    <td align="right">Ijasah</td>
    <td><?php echo $row_ppdb_all['ijasah']; ?></td>
  </tr>
  <tr>
    <td>Ilmu Pengetahuan Alam</td>
    <td><?php echo $row_ppdb_nilai['mapel_ilmupengetahuanalam']; ?></td>
    <td align="center">&nbsp;</td>
    <td align="right">SKHUN</td>
    <td><?php echo $row_ppdb_all['skhun']; ?></td>
  </tr>
  <tr>
    <td colspan="4" align="right">Apakah Data Sah?</td>
    <td><input name="sah_nilai" type="checkbox" id="sah_nilai" value="1" />
    <label for="sah_nilai"></label></td>
  </tr>
</table>
<br/>
<table width="1000" border="1" align="center">
  <tr>
    <td width="107">Nama Prestasi</td>
    <td width="771"><?php echo $row_ppdb_prestasi['nama_prestasi']; ?></td>
    <td width="100" align="left">&nbsp;</td>
  </tr>
  <tr>
    <td>Peringkat </td>
    <td><?php echo $row_ppdb_prestasi['peringkat_juara']; ?></td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td>Tingkat</td>
    <td><?php echo $row_ppdb_prestasi['tingkat_prestasi']; ?></td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td>Nilai</td>
    <td><?php echo $row_ppdb_prestasi['nilai_prestasi']; ?></td>
    <td align="left">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td align="right">Apakah Data Sah?</td>
    <td align="left"><input name="sah_prestasi" type="checkbox" id="sah_prestasi" value="1" />
    <label for="sah_prestasi"></label></td>
  </tr>
</table>

<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ppdb_all);

mysql_free_result($ppdb_nilai);

mysql_free_result($ppdb_prestasi);
?>
