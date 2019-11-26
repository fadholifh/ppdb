<?php require_once('../Connections/connect.php'); ?>
<?php include('auth.php'); ?>
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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<table width="1000" border="1" align="center">
  <tr>
    <td width="150" rowspan="4"><img src="../images/smk.png" /></td>
    <td width="614">PANITIA PENERIMAAN PESERTA DIDIK BARU</td>
    <td width="214">Nomor Pendaftaran</td>
  </tr>
  <tr>
    <td height="78">SMK NEGERI 1 BAWANG</td>
    <td><?php echo $row_ppdb_report['nomor_pendaftaran']; ?></td>
  </tr>
  <tr>
    <td>ALAMAT</td>
    <td><img src="../inc/barcode2.php?text=<?php echo $row_ppdb_report['nomor_pendaftaran']; ?>" /></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>

<br/>
<table width="1000" border="1" align="center">
  <tr>
    <td width="834"><h2>FORMULIR PENDAFTARAN JALUR REGULER</h2></td>
    <td width="150"><img src="../images/calon/<?php echo $row_ppdb_report['foto']; ?>" width="150px"/><br/>3x4</td>
  </tr>
</table>

<br/>
<table width="1000" border="1" align="center">
  <tr>
    <td colspan="5"><h3>BIODATA CALON SISWA BARU</h3></td>
  </tr>
  <tr>
    <td width="201">Tahun Lulus</td>
    <td colspan="4"><?php echo $row_ppdb_report['tahun_lulus']; ?></td>
  </tr>
  <tr>
    <td>Nama Lengkap</td>
    <td colspan="4"><?php echo $row_ppdb_report['nama_lengkap']; ?></td>
  </tr>
  <tr>
    <td>Program Studi</td>
    <td colspan="4"><?php echo $row_ppdb_report['nama_studi']; ?></td>
  </tr>
  <tr>
    <td>Jenis Kelamin</td>
    <td colspan="2"><?php echo $row_ppdb_report['jenis_kelamin']; ?></td>
    <td width="95">Agama</td>
    <td width="276"><?php echo $row_ppdb_report['nama']; ?></td>
  </tr>
  <tr>
    <td>Tempat Lahir</td>
    <td colspan="4"><?php echo $row_ppdb_report['tempat_lahir']; ?></td>
  </tr>
  <tr>
    <td>Tanggal Lahir</td>
    <td colspan="2"><?php echo $row_ppdb_report['tanggal_lahir']; ?></td>
    <td>Umur</td>
    <td><?php echo $row_ppdb_report['umur']; ?></td>
  </tr>
  <tr>
    <td>Alamat Rumah</td>
    <td colspan="4"><?php echo $row_ppdb_report['alamat_rumah']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td width="137">RT.</td>
    <td width="257"><?php echo substr($row_ppdb_report['rt_rw'],0,2); ?></td>
    <td>Kecamatan</td>
    <td><?php echo $row_ppdb_report['kecamatan']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>RW.</td>
    <td><?php echo substr($row_ppdb_report['rt_rw'],3,4); ?></td>
    <td>Kabupaten</td>
    <td><?php echo $row_ppdb_report['kabupaten']; ?></td>
  </tr>
  <tr>
    <td>No Hp Siswa</td>
    <td colspan="2"><?php echo $row_ppdb_report['no_hp_calon_siswa']; ?></td>
    <td>Kode Pos</td>
    <td><?php echo $row_ppdb_report['kode_pos']; ?></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>Tinggi Badam <?php echo $row_ppdb_report['tinggi_badan']; ?></td>
    <td>Berat Badan <?php echo $row_ppdb_report['berat_badan']; ?></td>
    <td>Golongan Darah</td>
    <td><?php echo $row_ppdb_report['golongan_darah']; ?></td>
  </tr>
  <tr>
    <td>Nama Ayah Kandung</td>
    <td colspan="4"><?php echo $row_ppdb_report['nama_ayah_kandung']; ?></td>
  </tr>
  <tr>
    <td>Pekerjaan Ayah Kandung</td>
    <td colspan="4"><?php echo $row_ppdb_report['nama_pekerjaan']; ?></td>
  </tr>
  <tr>
    <td>Nama Ibu Kandung</td>
    <td colspan="4"><?php echo $row_ppdb_report['nama_ibu_kandung']; ?></td>
  </tr>
  <tr>
    <td>Pekerjaan Ibu Kandung</td>
    <td colspan="4"><?php echo $row_ppdb_report['id_pekerjaan_ibu']; ?></td>
  </tr>
  <tr>
    <td>No. HP Orangtua</td>
    <td><?php echo $row_ppdb_report['no_hp_orang_tua']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>Asal Sekolah</td>
    <td colspan="4"><?php echo $row_ppdb_report['asal_sekolah']; ?></td>
  </tr>
</table>
<br/>
<table width="1000" border="1" align="center">
  <tr>
    <td colspan="2"><h3>DATA NILAI MAPEL UN</h3></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2"><h3>KELENGKAPAN DOKUMEN</h3></td>
  </tr>
  <tr>
    <td width="183">Matematika</td>
    <td width="253"><?php echo $row_ppdb_nilai['mapel_matematika']; ?></td>
    <td width="169">&nbsp;</td>
    <td width="8">&nbsp;</td>
    <td width="152">Piagam Prestasi</td>
    <td width="195"><?php echo $row_ppdb_report['piagam_prestasi']; ?></td>
  </tr>
  <tr>
    <td>Bahasa Indonesia</td>
    <td><?php echo $row_ppdb_nilai['mapel_bindonesia']; ?></td>
    <td>Total Nilai UN</td>
    <td>&nbsp;</td>
    <td>FC. Raport Smt 1-5</td>
    <td><?php echo $row_ppdb_report['fc_raport']; ?></td>
  </tr>
  <tr>
    <td>Bahasa Inggris</td>
    <td><?php echo $row_ppdb_nilai['mapel_binggris']; ?></td>
    <td><?php echo $row_ppdb_nilai['total_nilai']; ?></td>
    <td>&nbsp;</td>
    <td>Ijasah</td>
    <td><?php echo yesno($row_ppdb_report['ijasah']); ?></td>
  </tr>
  <tr>
    <td>Ilmu Pengetahuan Alam</td>
    <td><?php echo $row_ppdb_nilai['mapel_ilmupengetahuanalam']; ?></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>SKHUN</td>
    <td><?php echo yesno($row_ppdb_report['skhun']); ?></td>
  </tr>
</table>
<br/>
<table width="1000" border="1" align="center">
  <tr>
    <td width="485">Mengetahui,</td>
    <td width="61">&nbsp;</td>
    <td width="432">Banjarnegara,</td>
  </tr>
  <tr>
    <td>Orang Tua/Wali Calon Siswa</td>
    <td>&nbsp;</td>
    <td>Pendaftar</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><?php echo $row_ppdb_report['mengetahui']; ?></td>
    <td>&nbsp;</td>
    <td><?php echo $row_ppdb_report['nama_lengkap']; ?></td>
  </tr>
  <tr>
    <td>Tanda tangan dan Nama Terang</td>
    <td>&nbsp;</td>
    <td>Tanda tangan dan Nama terang</td>
  </tr>
</table>
<br/>
<br />
<br />
<br />
<table width="1000" border="1" align="center">
  <tr>
    <td>Contact Person: 082137741668 (Bu Istina), 081327510049 (Bu Eri Riastri), 085640084944 (Pak Sugi)</td>
  </tr>
</table>

</body>
</html>
<?php
mysql_free_result($ppdb_report);

mysql_free_result($ppdb_nilai);
?>
