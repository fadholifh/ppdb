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

$maxRows_ppdb_nilai = 10;
$pageNum_ppdb_nilai = 0;
if (isset($_GET['pageNum_ppdb_nilai'])) {
  $pageNum_ppdb_nilai = $_GET['pageNum_ppdb_nilai'];
}
$startRow_ppdb_nilai = $pageNum_ppdb_nilai * $maxRows_ppdb_nilai;

mysql_select_db($database_connect, $connect);
$query_ppdb_nilai = "SELECT ppdb_biodata.nama_lengkap, ppdb_nilai.mapel_matematika, ppdb_nilai.mapel_bindonesia, ppdb_nilai.mapel_binggris, ppdb_nilai.mapel_ilmupengetahuanalam,  ppdb_nilai.sah FROM ppdb_nilai, ppdb_biodata WHERE ppdb_nilai.id_ppdb = ppdb_biodata.id_ppdb";
$query_limit_ppdb_nilai = sprintf("%s LIMIT %d, %d", $query_ppdb_nilai, $startRow_ppdb_nilai, $maxRows_ppdb_nilai);
$ppdb_nilai = mysql_query($query_limit_ppdb_nilai, $connect) or die(mysql_error());
$row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai);

if (isset($_GET['totalRows_ppdb_nilai'])) {
  $totalRows_ppdb_nilai = $_GET['totalRows_ppdb_nilai'];
} else {
  $all_ppdb_nilai = mysql_query($query_ppdb_nilai);
  $totalRows_ppdb_nilai = mysql_num_rows($all_ppdb_nilai);
}
$totalPages_ppdb_nilai = ceil($totalRows_ppdb_nilai/$maxRows_ppdb_nilai);
$pageNum_ppdb_nilai = 0;
if (isset($_GET['pageNum_ppdb_nilai'])) {
  $pageNum_ppdb_nilai = $_GET['pageNum_ppdb_nilai'];
}
$startRow_ppdb_nilai = $pageNum_ppdb_nilai * $maxRows_ppdb_nilai;

mysql_select_db($database_connect, $connect);
$query_ppdb_nilai = "SELECT ppdb_biodata.id_ppdb, ppdb_biodata.nama_lengkap, ppdb_nilai.mapel_matematika, ppdb_nilai.mapel_bindonesia, ppdb_nilai.mapel_binggris, ppdb_nilai.mapel_ilmupengetahuanalam,  ppdb_nilai.sah,  ppdb_nilai.status FROM ppdb_nilai, ppdb_biodata WHERE ppdb_nilai.id_ppdb = ppdb_biodata.id_ppdb";
$query_limit_ppdb_nilai = sprintf("%s LIMIT %d, %d", $query_ppdb_nilai, $startRow_ppdb_nilai, $maxRows_ppdb_nilai);
$ppdb_nilai = mysql_query($query_limit_ppdb_nilai, $connect) or die(mysql_error());
$row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai);

if (isset($_GET['totalRows_ppdb_nilai'])) {
  $totalRows_ppdb_nilai = $_GET['totalRows_ppdb_nilai'];
} else {
  $all_ppdb_nilai = mysql_query($query_ppdb_nilai);
  $totalRows_ppdb_nilai = mysql_num_rows($all_ppdb_nilai);
}
$totalPages_ppdb_nilai = ceil($totalRows_ppdb_nilai/$maxRows_ppdb_nilai)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tampil Nilai</title>
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
<table border="0" align="center">
  <tr>
    <td>Nama Lengkap</td>
    <td>Mapel Matematika</td>
    <td>Mapel B.indonesia</td>
    <td>Mapel_B.inggris</td>
    <td>Mapel_IPA</td>
    <td>Sah</td>
    <td>Status</td>
    <td>Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ppdb_nilai['nama_lengkap']; ?></td>
      <td><?php echo $row_ppdb_nilai['mapel_matematika']; ?></td>
      <td><?php echo $row_ppdb_nilai['mapel_bindonesia']; ?></td>
      <td><?php echo $row_ppdb_nilai['mapel_binggris']; ?></td>
      <td><?php echo $row_ppdb_nilai['mapel_ilmupengetahuanalam']; ?></td>
      <td><?php echo yesno($row_ppdb_nilai['sah']); ?></td>
      <td><?php echo yesno($row_ppdb_nilai['status']); ?></td>
      <td><a href="edit_nilai.php?id=<?php echo $row_ppdb_nilai['id_ppdb']; ?>">edit</a> - deactive - <a href="hapus_nilai.php?id=<?php echo $row_ppdb_nilai['id_ppdb']; ?>">hapus</a></td>
    </tr>
    <?php } while ($row_ppdb_nilai = mysql_fetch_assoc($ppdb_nilai)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ppdb_nilai);
?>
