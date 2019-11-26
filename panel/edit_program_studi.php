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
  $updateSQL = sprintf("UPDATE ext_program_studi SET no_studi=%s, nama_studi=%s, alias_studi=%s, jumlah_kelas=%s, jumlah_siswa=%s, status=%s WHERE id_program_studi=%s",
                       GetSQLValueString($_POST['no_studi'], "int"),
                       GetSQLValueString($_POST['nama_studi'], "text"),
                       GetSQLValueString($_POST['alias_studi'], "text"),
                       GetSQLValueString($_POST['jumlah_kelas'], "int"),
                       GetSQLValueString($_POST['jumlah_siswa'], "int"),
                       GetSQLValueString(isset($_POST['status']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_program_studi'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());
      $updateGoTo = "tampil_program_studi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_ext_program_studi = "-1";
if (isset($_GET['id'])) {
  $colname_ext_program_studi = $_GET['id'];
}
mysql_select_db($database_connect, $connect);
$query_ext_program_studi = sprintf("SELECT * FROM ext_program_studi WHERE id_program_studi = %s", GetSQLValueString($colname_ext_program_studi, "int"));
$ext_program_studi = mysql_query($query_ext_program_studi, $connect) or die(mysql_error());
$row_ext_program_studi = mysql_fetch_assoc($ext_program_studi);
$totalRows_ext_program_studi = mysql_num_rows($ext_program_studi);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Program Studi</title>
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
      <td nowrap="nowrap" align="right">No Studi</td>
      <td><input type="text" name="no_studi" value="<?php echo htmlentities($row_ext_program_studi['no_studi'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama Studi</td>
      <td><input type="text" name="nama_studi" value="<?php echo htmlentities($row_ext_program_studi['nama_studi'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Alias Stud</td>
      <td><input type="text" name="alias_studi" value="<?php echo htmlentities($row_ext_program_studi['alias_studi'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jumlah Kelas</td>
      <td><select name="jumlah_kelas">
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_ext_program_studi['jumlah_kelas'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>1</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_ext_program_studi['jumlah_kelas'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>2</option>
        <option value="3" <?php if (!(strcmp(3, htmlentities($row_ext_program_studi['jumlah_kelas'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>3</option>
        <option value="4" <?php if (!(strcmp(4, htmlentities($row_ext_program_studi['jumlah_kelas'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>4</option>
        <option value="" ></option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Jumlah Siswa</td>
      <td><input type="text" name="jumlah_siswa" value="<?php echo htmlentities($row_ext_program_studi['jumlah_siswa'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status</td>
      <td><input type="checkbox" name="status" value=""  <?php if (!(strcmp(htmlentities($row_ext_program_studi['status'], ENT_COMPAT, 'utf-8'),1))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Simpan" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_program_studi" value="<?php echo $row_ext_program_studi['id_program_studi']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ext_program_studi);
?>
