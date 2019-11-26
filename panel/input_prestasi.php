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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO ppdb_prestasi (id_ppdb, nama_prestasi, peringkat_juara, tingkat_prestasi) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_ppdb'], "int"),
                       GetSQLValueString($_POST['nama_prestasi'], "text"),
                       GetSQLValueString($_POST['peringkat_juara'], "int"),
                       GetSQLValueString($_POST['tingkat_prestasi'], "text"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($insertSQL, $connect) or die(mysql_error());
}

$ambil_idppdb_ppdb_biodata = "-1";
if (isset($_GET['id_ppdb'])) {
  $ambil_idppdb_ppdb_biodata = $_GET['id_ppdb'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_biodata = sprintf("SELECT ppdb_biodata.id_ppdb, ppdb_biodata.nama_lengkap, ppdb_biodata.nomor_pendaftaran, ppdb_biodata.id_program_studi, ext_program_studi.nama_studi, ppdb_biodata.tempat_lahir, ppdb_biodata.tanggal_lahir FROM ppdb_biodata, ext_program_studi WHERE ext_program_studi.id_program_studi = ppdb_biodata.id_program_studi AND id_ppdb = %s", GetSQLValueString($ambil_idppdb_ppdb_biodata, "int"));
$ppdb_biodata = mysql_query($query_ppdb_biodata, $connect) or die(mysql_error());
$row_ppdb_biodata = mysql_fetch_assoc($ppdb_biodata);
$totalRows_ppdb_biodata = mysql_num_rows($ppdb_biodata);

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
<title>input Prestasi</title>
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
<table width="400" border="0" align="center">
  <tr>
    <td>Nomor Pendaftaran</td>
    <td><?php echo $row_ppdb_biodata['nomor_pendaftaran']; ?></td>
  </tr>
  <tr>
    <td>Nama Lengkap</td>
    <td><?php echo $row_ppdb_biodata['nama_lengkap']; ?></td>
  </tr>
  <tr>
    <td>Program Studi</td>
    <td><?php echo $row_ppdb_biodata['nama_studi']; ?></td>
  </tr>
  <tr>
    <td>TTL</td>
    <td><?php echo $row_ppdb_biodata['tempat_lahir']; ?>, <?php echo $row_ppdb_biodata['tanggal_lahir']; ?></td>
  </tr>
  <tr>
    <td>Status Nilai</td>
    <td><?php if ($totalRows_ppdb_nilai > 0) { // Show if recordset not empty ?>
        Sudah Ada! 
    <?php } // Show if recordset not empty ?></td>
  </tr>
  <tr>
    <td>Status Prestasi</td>
    <td><?php if ($totalRows_ppdb_prestasi == 0) { // Show if recordset empty ?>
        Belum Ada
  <?php } // Show if recordset empty ?>
      <?php if ($totalRows_ppdb_prestasi > 0) { // Show if recordset not empty ?>
        Sudah Ada
  <?php } // Show if recordset not empty ?></td>
  </tr>
</table>
<p>&nbsp;</p>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <?php if ($totalRows_ppdb_prestasi == 0) { // Show if recordset empty ?>
  <table width="400" align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Nama Prestasi</td>
      <td><input type="text" name="nama_prestasi" value="" size="32" /></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Peringkat Juara</td>
      <td><select name="peringkat_juara">
        <option value="1" <?php if (!(strcmp(1, ""))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, ""))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, ""))) {echo "SELECTED";} ?>>3</option>
        </select></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Tingkat Prestasi</td>
      <td><select name="tingkat_prestasi">
        <option value="KAB" <?php if (!(strcmp("KAB", ""))) {echo "SELECTED";} ?>>Kabupaten</option>
        <option value="PROV" <?php if (!(strcmp("PROV", ""))) {echo "SELECTED";} ?>>Provinsi</option>
        <option value="NAS" <?php if (!(strcmp("NAS", ""))) {echo "SELECTED";} ?>>Nasional</option>
        <option value="INTL" <?php if (!(strcmp("INTL", ""))) {echo "SELECTED";} ?>>Internasional</option>
        </select></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td><input type="submit" value="Simpan" /></td>
      </tr>
  </table>
  <?php } // Show if recordset empty ?>
<input type="hidden" name="id_ppdb" value="<?php echo $row_ppdb_biodata['id_ppdb']; ?>" />
  <input type="hidden" name="MM_insert" value="form1" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ppdb_biodata);

mysql_free_result($ppdb_nilai);

mysql_free_result($ppdb_prestasi);
?>
