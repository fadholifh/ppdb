<?php require_once('../Connections/connect.php'); ?>
<?php require_once('../Connections/connect.php'); ?>
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
  $insertSQL = sprintf("INSERT INTO ppdb_nilai (id_ppdb, mapel_matematika, mapel_bindonesia, mapel_binggris, mapel_ilmupengetahuanalam) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['id_ppdb'], "int"),
                       GetSQLValueString($_POST['mapel_matematika'], "double"),
                       GetSQLValueString($_POST['mapel_bindonesia'], "double"),
                       GetSQLValueString($_POST['mapel_binggris'], "double"),
                       GetSQLValueString($_POST['mapel_ilmupengetahuanalam'], "double"));

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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Input Nilai</title>
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
    <td><?php if ($totalRows_ppdb_nilai == 0) { // Show if recordset empty ?>
        Belum Ada
  <?php } // Show if recordset empty ?>
      <?php if ($totalRows_ppdb_nilai > 0) { // Show if recordset not empty ?>
        Sudah Ada! Tidak Bisa Menginput Lagi!
        <?php } // Show if recordset not empty ?></td>
  </tr>
  <tr>
    <td colspan="2"><h3>
      <?php if ($totalRows_ppdb_nilai > 0) { // Show if recordset not empty ?>
        Klik Disini untuk mengisi <a href="input_prestasi.php?id_ppdb=<?php echo $row_ppdb_biodata['id_ppdb']; ?>">Prestasi</a>
        <?php } // Show if recordset not empty ?>
    </h3></td>
  </tr>
</table>
<h3>&nbsp;</h3>
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <?php if ($totalRows_ppdb_nilai == 0) { // Show if recordset empty ?>
  <table width="400" align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Matematika</td>
      <td><input type="text" name="mapel_matematika" value="0" size="32" /></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Bahasa Indonesia</td>
      <td><input type="text" name="mapel_bindonesia" value="0" size="32" /></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Bahasa Inggris</td>
      <td><input type="text" name="mapel_binggris" value="0" size="32" /></td>
      </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Ilmu Pengetahuan Alam</td>
      <td><input type="text" name="mapel_ilmupengetahuanalam" value="0" size="32" /></td>
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
?>
