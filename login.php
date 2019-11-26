<?php require_once('Connections/connect.php'); ?>
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
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "level";
  
  $MM_redirectLoginFailed = "login.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_connect, $connect);
  	
  $LoginRS__query=sprintf("SELECT username, password, level FROM ppdb_petugas WHERE username=%s AND password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $connect) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
    
    $loginStrGroup  = mysql_result($LoginRS,0,'level');
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	   
	if ($loginStrGroup == "2"){
		$MM_redirectLoginSuccess = "panel/index.php";
	}else if ($loginStrGroup == "1"){
		$MM_redirectLoginSuccess = "verifikator/index.php";
	}else if ($loginStrGroup == "0"){
		$MM_redirectLoginSuccess = "operator/index.php";
	}

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Login</title>
<link href="bs/css/bootstrap.css" rel="stylesheet" type="text/css" />
<link href="bs/css/modern-business.css" rel="stylesheet" type="text/css" />
<link href="bs/font-awesome/css/font-awesome.css" rel="stylesheet" type="text/css" />
<script src="bs/js/bootstrap.js"></script>
<script src="bs/js/jquery-1.10.2.js"></script>
</head>

<body>
<br />
<br />
<br />
<br />
<br />
<br />
<form id="form1" name="form1" method="POST" action="<?php echo $loginFormAction; ?>">
  <table width="400" border="0" align="center" class="table-condensed">
    <tr>
      <td height="10" colspan="2" align="center" class="bg-primary"><h4>Log In</h4></td>
    </tr>
    <tr>
      <td width="106"><h4>Username</h4></td>
      <td width="178"><label for="username2"></label>
        <input type="text" name="username" id="username2" class="form-control" /></td>
    </tr>
    <tr>
      <td><h4>Password</h4></td>
      <td><label for="password"></label>
        <input type="password" name="password" id="password" class="form-control" /></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td><input type="submit" name="button" id="button" value="Masuk" class="btn btn-primary" />
        <input type="reset" name="button2" id="button2" value="Reset" class=" btn btn-primary" /></td>
    </tr>
  </table>
</form>
</body>
</html>
