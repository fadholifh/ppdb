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

mysql_select_db($database_connect, $connect);
$query_ppdb_prestasi = "SELECT * FROM ppdb_prestasi ORDER BY id_prestasi DESC";
$ppdb_prestasi = mysql_query($query_ppdb_prestasi, $connect) or die(mysql_error());
$row_ppdb_prestasi = mysql_fetch_assoc($ppdb_prestasi);
$totalRows_ppdb_prestasi = mysql_num_rows($ppdb_prestasi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tampil Prestasi</title>
<link href="../css/style.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="nav">
    <table width="73%" border="0" cellspacing="0" cellpadding="0" align="center">
  <tr>
    <td><?php include('menu.php') ?></td>
  </tr>
</table>
</div>
<br />
<br />
<br />
<br />
<table border="0" align="center">
  <tr>
    <td>Id Prestasi</td>
    <td>Id Ppdb</td>
    <td>Nama Prestasi</td>
    <td>Peringkat Juara</td>
    <td>Tingkat Prestasi</td>
    <td>Nilai Prestasi</td>
    <td>Sah</td>
    <td>Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ppdb_prestasi['id_prestasi']; ?></td>
      <td><?php echo $row_ppdb_prestasi['id_ppdb']; ?></td>
      <td><?php echo $row_ppdb_prestasi['nama_prestasi']; ?></td>
      <td><?php echo $row_ppdb_prestasi['peringkat_juara']; ?></td>
      <td><?php echo $row_ppdb_prestasi['tingkat_prestasi']; ?></td>
      <td><?php echo $row_ppdb_prestasi['nilai_prestasi']; ?></td>
      <td><?php echo yesno($row_ppdb_prestasi['sah']); ?></td>
      <td><a href="edit_prestasi.php?id=<?php echo $row_ppdb_prestasi['id_prestasi']; ?>">edit</a> - <a href="hapus_prestasi.php?id=<?php echo $row_ppdb_prestasi['id_prestasi']; ?>">hapus</a></td>
    </tr>
    <?php } while ($row_ppdb_prestasi = mysql_fetch_assoc($ppdb_prestasi)); ?>
</table>
</body>
</html>
<?php
mysql_free_result($ppdb_prestasi);
?>
