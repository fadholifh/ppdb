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

$maxRows_ext_agama = 10;
$pageNum_ext_agama = 0;
if (isset($_GET['pageNum_ext_agama'])) {
  $pageNum_ext_agama = $_GET['pageNum_ext_agama'];
}
$startRow_ext_agama = $pageNum_ext_agama * $maxRows_ext_agama;

mysql_select_db($database_connect, $connect);
$query_ext_agama = "SELECT * FROM `ext_agama`";
$query_limit_ext_agama = sprintf("%s LIMIT %d, %d", $query_ext_agama, $startRow_ext_agama, $maxRows_ext_agama);
$ext_agama = mysql_query($query_limit_ext_agama, $connect) or die(mysql_error());
$row_ext_agama = mysql_fetch_assoc($ext_agama);

if (isset($_GET['totalRows_ext_agama'])) {
  $totalRows_ext_agama = $_GET['totalRows_ext_agama'];
} else {
  $all_ext_agama = mysql_query($query_ext_agama);
  $totalRows_ext_agama = mysql_num_rows($all_ext_agama);
}
$totalPages_ext_agama = ceil($totalRows_ext_agama/$maxRows_ext_agama)-1;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tampil Agama</title>
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
    <td>Id Agama</td>
    <td>Nama</td>
    <td>Status</td>
    <td>Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_ext_agama['id_agama']; ?></td>
      <td><?php echo $row_ext_agama['nama']; ?></td>
      <td><?php echo yesno($row_ext_agama['status']); ?></td>
      <td><a href="edit_agama.php?id=<?php echo $row_ext_agama['id_agama']; ?>">edit</a> - <a href="deactive_agama.php?id=<?php echo $row_ext_agama['id_agama']; ?>">deactive</a> - <a href="hapus_agama.php?id=<?php echo $row_ext_agama['id_agama']; ?>">hapus</a></td>
    </tr>
    <?php } while ($row_ext_agama = mysql_fetch_assoc($ext_agama)); ?>
</table>
<p><a href="input_agama.php">Tambah Agama</a></p>
</body>
</html>
<?php
mysql_free_result($ext_agama);
?>
