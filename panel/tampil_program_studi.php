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

$maxRows_ext_program_studi = 10;
$pageNum_ext_program_studi = 0;
if (isset($_GET['pageNum_ext_program_studi'])) {
  $pageNum_ext_program_studi = $_GET['pageNum_ext_program_studi'];
}
$startRow_ext_program_studi = $pageNum_ext_program_studi * $maxRows_ext_program_studi;

mysql_select_db($database_connect, $connect);
$query_ext_program_studi = "SELECT * FROM ext_program_studi";
$query_limit_ext_program_studi = sprintf("%s LIMIT %d, %d", $query_ext_program_studi, $startRow_ext_program_studi, $maxRows_ext_program_studi);
$ext_program_studi = mysql_query($query_limit_ext_program_studi, $connect) or die(mysql_error());
$row_ext_program_studi = mysql_fetch_assoc($ext_program_studi);

if (isset($_GET['totalRows_ext_program_studi'])) {
  $totalRows_ext_program_studi = $_GET['totalRows_ext_program_studi'];
} else {
  $all_ext_program_studi = mysql_query($query_ext_program_studi);
  $totalRows_ext_program_studi = mysql_num_rows($all_ext_program_studi);
}
$totalPages_ext_program_studi = ceil($totalRows_ext_program_studi/$maxRows_ext_program_studi)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Program Studi</title>
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
    <td>Id program_studi</td>
    <td>No Studi</td>
    <td>Nama Studi</td>
    <td>Alias Studi</td>
    <td>Jumlah Kelas</td>
    <td>Jumlah Siswa</td>
    <td>Status</td>
    <td>Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ext_program_studi['id_program_studi']; ?></td>
      <td><?php echo $row_ext_program_studi['no_studi']; ?></td>
      <td><?php echo $row_ext_program_studi['nama_studi']; ?></td>
      <td><?php echo $row_ext_program_studi['alias_studi']; ?></td>
      <td><?php echo $row_ext_program_studi['jumlah_kelas']; ?></td>
      <td><?php echo $row_ext_program_studi['jumlah_siswa']; ?></td>
      <td><?php echo yesno($row_ext_program_studi['status']); ?></td>
      <td><a href="edit_program_studi.php?id=<?php echo $row_ext_program_studi['id_program_studi']; ?>">edit</a> - <a href="deactive_program_studi.php?id=<?php echo $row_ext_program_studi['id_program_studi']; ?>">deactive</a> - <a href="hapus_program_studi.php?id=<?php echo $row_ext_program_studi['id_program_studi']; ?>">hapus</a></td>
    </tr>
    <?php } while ($row_ext_program_studi = mysql_fetch_assoc($ext_program_studi)); ?>
</table>
<p><a href="input_program_studi.php">Tambah Program Studi</a></p>
</body>
</html>
<?php
mysql_free_result($ext_program_studi);
?>
