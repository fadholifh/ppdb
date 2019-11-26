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
  $updateSQL = sprintf("UPDATE ppdb_petugas SET nama_lengkap=%s, username=%s, password=%s, `level`=%s, status=%s WHERE id_petugas=%s",
                       GetSQLValueString($_POST['nama_lengkap'], "text"),
                       GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"),
                       GetSQLValueString($_POST['level'], "int"),
                       GetSQLValueString(isset($_POST['status']) ? "true" : "", "defined","1","0"),
                       GetSQLValueString($_POST['id_petugas'], "int"));

  mysql_select_db($database_connect, $connect);
  $Result1 = mysql_query($updateSQL, $connect) or die(mysql_error());

  $updateGoTo = "tampil_user.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_petugas = "-1";
if (isset($_GET['id'])) {
  $colname_petugas = $_GET['id'];
}
mysql_select_db($database_connect, $connect);
$query_petugas = sprintf("SELECT * FROM ppdb_petugas WHERE id_petugas = %s", GetSQLValueString($colname_petugas, "int"));
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
<form action="<?php echo $editFormAction; ?>" method="post" name="form1" id="form1">
  <table align="center">
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Id Petugas:</td>
      <td><?php echo $row_petugas['id_petugas']; ?></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Nama Lengkap:</td>
      <td><input type="text" name="nama_lengkap" value="<?php echo htmlentities($row_petugas['nama_lengkap'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Username:</td>
      <td><input type="text" name="username" value="<?php echo htmlentities($row_petugas['username'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Password:</td>
      <td><input type="text" name="password" value="<?php echo htmlentities($row_petugas['password'], ENT_COMPAT, 'utf-8'); ?>" size="32" /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Level:</td>
      <td><select name="level">
        <option value="2" <?php if (!(strcmp(2, htmlentities($row_petugas['level'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Admin</option>
        <option value="1" <?php if (!(strcmp(1, htmlentities($row_petugas['level'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Verifikator</option>
        <option value="0" <?php if (!(strcmp(0, htmlentities($row_petugas['level'], ENT_COMPAT, 'utf-8')))) {echo "SELECTED";} ?>>Operator</option>
      </select></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">Status:</td>
      <td><input type="checkbox" name="status" value=""  <?php if (!(strcmp(htmlentities($row_petugas['status'], ENT_COMPAT, 'utf-8'),0))) {echo "checked=\"checked\"";} ?> /></td>
    </tr>
    <tr valign="baseline">
      <td nowrap="nowrap" align="left">&nbsp;</td>
      <td><input type="submit" value="Update record" /></td>
    </tr>
  </table>
  <input type="hidden" name="MM_update" value="form1" />
  <input type="hidden" name="id_petugas" value="<?php echo $row_petugas['id_petugas']; ?>" />
</form>
<p>&nbsp;</p>
</body>
</html>
<?php
mysql_free_result($petugas);
?>
