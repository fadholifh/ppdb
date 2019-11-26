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
  $updateSQL = sprintf("UPDATE ext_pekerjaan_ortu SET tipe_pekerjaan=%s, nama_pekerjaan=%s, status=%s WHERE id_pekerjaan_ortu=%s",
                       GetSQLValueString($_POST['tipe_pekerjaan'], "int"),
                       GetSQLValueString($_POST['nama_pekerjaan'], "text"),
                       GetSQLValueString(isset($_POST['status']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_pekerjaan_ortu'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());
      $updateGoTo = "tampil_pekerjaan_ortu.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

mysql_select_db($database_connect, $connect);
$query_ext_pekerjaan_ortu = "SELECT * FROM ext_pekerjaan_ortu";
$ext_pekerjaan_ortu = mysql_query($query_ext_pekerjaan_ortu, $connect) or die(mysql_error());
$row_ext_pekerjaan_ortu = mysql_fetch_assoc($ext_pekerjaan_ortu);
$colname_ext_pekerjaan_ortu = "-1";
if (isset($_GET['id'])) {
  $colname_ext_pekerjaan_ortu = $_GET['id'];
}
mysql_select_db($database_connect, $connect);
$query_ext_pekerjaan_ortu = sprintf("SELECT * FROM ext_pekerjaan_ortu WHERE id_pekerjaan_ortu = %s", GetSQLValueString($colname_ext_pekerjaan_ortu, "int"));
$ext_pekerjaan_ortu = mysql_query($query_ext_pekerjaan_ortu, $connect) or die(mysql_error());
$row_ext_pekerjaan_ortu = mysql_fetch_assoc($ext_pekerjaan_ortu);
$totalRows_ext_pekerjaan_ortu = mysql_num_rows($ext_pekerjaan_ortu);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Pekerjaan</title>
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Tipe Pekerjaan</td>
      <td><select name="tipe_pekerjaan">
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_ext_pekerjaan_ortu['tipe_pekerjaan'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Ayah</option>
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_ext_pekerjaan_ortu['tipe_pekerjaan'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Ibu</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Nama Pekerjaan</td>
      <td><input type="text" name="nama_pekerjaan" value="<?php echo htmlentities($row_ext_pekerjaan_ortu['nama_pekerjaan'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">Status:</td>
      <td><input type="checkbox" name="status" value=""  <?php if (!(strcmp(htmlentities($row_ext_pekerjaan_ortu['status'], ENT_COMPAT, 'utf-8'),1))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="right">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_pekerjaan_ortu" value="<?php echo $row_ext_pekerjaan_ortu['id_pekerjaan_ortu']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($ext_pekerjaan_ortu);
?>
