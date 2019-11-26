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

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE ppdb_prestasi SET id_ppdb=%s, nama_prestasi=%s, peringkat_juara=%s, tingkat_prestasi=%s, sah=%s WHERE id_prestasi=%s",
                       GetSQLValueString($_POST['id_ppdb'], "int"),
                       GetSQLValueString($_POST['nama_prestasi'], "text"),
                       GetSQLValueString($_POST['peringkat_juara'], "int"),
                       GetSQLValueString($_POST['tingkat_prestasi'], "text"),
                       GetSQLValueString(isset($_POST['sah']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_prestasi'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());

  $updateGoTo = "tampil_prestasi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_ppdb_prestasi = "-1";
if (isset($_GET['id'])) {
  $colname_ppdb_prestasi = $_GET['id'];
}
mysql_select_db($database_connect, $connect);
$query_ppdb_prestasi = sprintf("SELECT * FROM ppdb_prestasi WHERE id_prestasi = %s", GetSQLValueString($colname_ppdb_prestasi, "int"));
$ppdb_prestasi = mysql_query($query_ppdb_prestasi, $connect) or die(mysql_error());
$row_ppdb_prestasi = mysql_fetch_assoc($ppdb_prestasi);
$totalRows_ppdb_prestasi = mysql_num_rows($ppdb_prestasi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Prestasi</title>
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Id_ppdb:</td>
      <td><input type="text" name="id_ppdb" value="<?php echo htmlentities($row_ppdb_prestasi['id_ppdb'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama Prestasi:</td>
      <td><input type="text" name="nama_prestasi" value="<?php echo htmlentities($row_ppdb_prestasi['nama_prestasi'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Peringkat Juara:</td>
      <td><select name="peringkat_juara">
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_ppdb_prestasi['peringkat_juara'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_ppdb_prestasi['peringkat_juara'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, htmlentities($row_ppdb_prestasi['peringkat_juara'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>3</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tingkat Prestasi:</td>
      <td><select name="tingkat_prestasi">
        <option value="KAB" <?php if (!(strcmp("KAB", htmlentities($row_ppdb_prestasi['tingkat_prestasi'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Kabupaten</option>
        <option value="PROV" <?php if (!(strcmp("PROV", htmlentities($row_ppdb_prestasi['tingkat_prestasi'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Provinsi</option>
        <option value="NAS" <?php if (!(strcmp("NAS", htmlentities($row_ppdb_prestasi['tingkat_prestasi'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Nasional</option>
        <option value="INTL" <?php if (!(strcmp("INTL", htmlentities($row_ppdb_prestasi['tingkat_prestasi'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Internasional</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Sah:</td>
      <td><input type="checkbox" name="sah" value=""  <?php if (!(strcmp(htmlentities($row_ppdb_prestasi['sah'], ENT_COMPAT, 'utf-8'),""))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_prestasi" value="<?php echo $row_ppdb_prestasi['id_prestasi']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ppdb_prestasi);
?>
