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
$query_petugas = "SELECT * FROM ppdb_petugas";
$petugas = mysql_query($query_petugas, $connect) or die(mysql_error());
$row_petugas = mysql_fetch_assoc($petugas);
$totalRows_petugas = mysql_num_rows($petugas);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
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
<table border="0" align="center" cellpadding="4" cellspacing="4">
  <tr>
    <td>Id Petugas</td>
    <td>Nama Lengkap</td>
    <td>Username</td>
    <td>Password</td>
    <td>Level</td>
    <td>Status</td>
    <td colspan="2">Aksi</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_petugas['id_petugas']; ?></td>
      <td><?php echo $row_petugas['nama_lengkap']; ?></td>
      <td><?php echo $row_petugas['username']; ?></td>
      <td><?php echo $row_petugas['password']; ?></td>
      <td><?php echo adm($row_petugas['level']); ?></td>
      <td><?php echo yesno($row_petugas['status']); ?></td>
      <td><a href="edit_user.php?id=<?php echo $row_petugas['id_petugas']; ?>">Edit</a></td>
      <td><a href="hapus_user.php?id=<?php echo $row_petugas['id_petugas']; ?>">Delete</a></td>
    </tr>
    <?php } while ($row_petugas = mysql_fetch_assoc($petugas)); ?>
</table>
<a href="tampil_user.php">Tambah User</a>
</body>
</html>
<?php
mysql_free_result($petugas);
?>
