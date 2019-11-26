<?php require_once('../Connections/connect.php'); ?>
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

mysql_select_db($database_connect, $connect);
$query_ext_program_studi = "SELECT *  FROM `ext_program_studi`";
$ext_program_studi = mysql_query($query_ext_program_studi, $connect) or die(mysql_error());
$row_ext_program_studi = mysql_fetch_assoc($ext_program_studi);
$totalRows_ext_program_studi = mysql_num_rows($ext_program_studi);

$ambil_idstudi_ppdb_nilai = "-1";
if (isset($_GET['id_studi'])) {
  $ambil_idstudi_ppdb_nilai = $_GET['id_studi'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_nilai = sprintf("SELECT ppdb_biodata.nomor_pendaftaran, ppdb_biodata.nama_lengkap, ppdb_biodata.jenis_kelamin, ppdb_biodata.asal_sekolah,  ppdb_nilai.mapel_matematika,  	 ppdb_nilai.mapel_bindonesia,  ppdb_nilai.mapel_binggris,  ppdb_nilai.mapel_ilmupengetahuanalam,  (ppdb_nilai.total_nilai+ppdb_prestasi.nilai_prestasi) AS nilai_akhir FROM ppdb_nilai,  ppdb_prestasi,  ppdb_biodata WHERE ppdb_biodata.id_program_studi = %s AND 	 ppdb_biodata.id_ppdb = ppdb_nilai.id_ppdb AND ppdb_prestasi.id_ppdb = ppdb_nilai.id_ppdb AND	 ppdb_biodata.status_sah = 1 AND 	 ppdb_nilai.sah = 1 ORDER BY nilai_akhir DESC,  	 ppdb_nilai.mapel_matematika DESC,  	 ppdb_nilai.mapel_bindonesia DESC,  	 ppdb_nilai.mapel_binggris DESC,  	 ppdb_nilai.mapel_ilmupengetahuanalam DESC", GetSQLValueString($ambil_idstudi_ppdb_nilai, "int"));
$ppdb_nilai = mysql_query($query_ppdb_nilai, $connect) or die(mysql_error());
$row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai);
$totalRows_ppdb_nilai = mysql_num_rows($ppdb_nilai);

$ambil_idstudi_ext_program_studi_2 = "-1";
if (isset($_GET['id_studi'])) {
  $ambil_idstudi_ext_program_studi_2 = $_GET['id_studi'];
}
mysql_select_db($database_connect, $connect);
$query_ext_program_studi_2 = sprintf("SELECT nama_studi FROM ext_program_studi WHERE id_program_studi = %s", GetSQLValueString($ambil_idstudi_ext_program_studi_2, "int"));
$ext_program_studi_2 = mysql_query($query_ext_program_studi_2, $connect) or die(mysql_error());
$row_ext_program_studi_2 = mysql_fetch_assoc($ext_program_studi_2);
$totalRows_ext_program_studi_2 = mysql_num_rows($ext_program_studi_2);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Jurnal</title>
<link href="../bs/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="../bs/css/modern-business.css" rel="stylesheet" type="text/css" />
<link href="../bs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
<script src="../bs/js/bootstrap.js"></script>
<script src="../bs/js/jquery-1.10.2.js"></script>
</head>

<body>
<table width="100%" border="0" cellspacing="1" cellpadding="1" class="bg-primary">
  <tr>
    <td align="center"><h2>Jurnal</h2></td>
  </tr>
</table>
<br />
<form id="form1" name="form1" method="get" action="">
  <label for="id_studi"></label>
 <select name="id_studi" class="form-control-static" id="id_studi">
    <?php
do {  
?>
    <option value="<?php echo $row_ext_program_studi['id_program_studi']?>"><?php echo $row_ext_program_studi['nama_studi']?></option>
    <?php
} while ($row_ext_program_studi = mysql_fetch_assoc($ext_program_studi));
  $rows = mysql_num_rows($ext_program_studi);
  if($rows > 0) {
      mysql_data_seek($ext_program_studi, 0);
	  $row_ext_program_studi = mysql_fetch_assoc($ext_program_studi);
  }
?>
  </select><input type="submit" value="+" class="btn btn-primary "" />
</form>
<div class="container">
<center><?php echo $row_ext_program_studi_2['nama_studi']; ?></center>
<marquee direction="up" scrollamount="4">
<?php if ($totalRows_ppdb_nilai > 0) { // Show if recordset not empty ?>
  <table width="950" border="0" align="center" class="table">
    <tr class="bg-primary">
      <td>No</td>
      <td>Nama</td>
      <td>ASAL SEKOLAH</td>
      <td>MTK</td>
      <td>IND</td>
      <td>ING</td>
      <td>IPA</td>
      <td>TOTAL</td>
    </tr>
    <?php do { ?>
      <tr>
        <td><?php @$no++; echo @$no; ?></td>
        <td><?php echo $row_ppdb_nilai['nama_lengkap']; ?></td>
        <td><?php echo $row_ppdb_nilai['asal_sekolah']; ?></td>
        <td><?php echo $row_ppdb_nilai['mapel_matematika']; ?></td>
        <td><?php echo $row_ppdb_nilai['mapel_bindonesia']; ?></td>
        <td><?php echo $row_ppdb_nilai['mapel_binggris']; ?></td>
        <td><?php echo $row_ppdb_nilai['mapel_ilmupengetahuanalam']; ?></td>
        <td><?php echo $row_ppdb_nilai['nilai_akhir']; ?></td>
      </tr>
      <?php } while ($row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai)); ?>
  </table>
  <?php } // Show if recordset not empty ?>
</marquee>
</div>
</body>
</html>
<?php
mysql_free_result($ext_program_studi);

mysql_free_result($ppdb_nilai);

mysql_free_result($ext_program_studi_2);
?>
