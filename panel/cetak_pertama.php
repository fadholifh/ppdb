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
$query_ppdb_biodata = "SELECT * FROM ppdb_biodata ORDER BY id_ppdb DESC  LIMIT 0 , 10";
$ppdb_biodata = mysql_query($query_ppdb_biodata, $connect) or die(mysql_error());
$row_ppdb_biodata = mysql_fetch_assoc($ppdb_biodata);
$totalRows_ppdb_biodata = mysql_num_rows($ppdb_biodata);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Pilih Cetak</title>
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
<form action="cetak.php" method="get" enctype="multipart/form-data" name="form1" id="form1">
  <label>Nama Peserta: </label>
  <select name="id_ppdb" id="id_ppdb">
    <?php
do {  
?>
    <option value="<?php echo $row_ppdb_biodata['id_ppdb']?>"><?php echo $row_ppdb_biodata['nomor_pendaftaran']?> - <?php echo $row_ppdb_biodata['nama_lengkap']?> (<?php echo $row_ppdb_biodata['asal_sekolah']; ?>)</option>
    <?php
} while ($row_ppdb_biodata = mysql_fetch_assoc($ppdb_biodata));
  $rows = mysql_num_rows($ppdb_biodata);
  if($rows > 0) {
      mysql_data_seek($ppdb_biodata, 0);
	  $row_ppdb_biodata = mysql_fetch_assoc($ppdb_biodata);
  }
?>
  </select>
  <input type="submit" value="Lihat" />
</form>
</body>
</html>
<?php
mysql_free_result($ppdb_biodata);
?>
