<?php

//
//
//      Copyright (C) 2016 Paul Halliday <paul.halliday@gmail.com>
//
//      This program is free software: you can redistribute it and/or modify
//      it under the terms of the GNU General Public License as published by
//      the Free Software Foundation, either version 3 of the License, or
//      (at your option) any later version.
//
//      This program is distributed in the hope that it will be useful,
//      but WITHOUT ANY WARRANTY; without even the implied warranty of
//      MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
//      GNU General Public License for more details.
//
//      You should have received a copy of the GNU General Public License
//      along with this program.  If not, see <http://www.gnu.org/licenses/>.
//
//

include '.inc/config.php';

$username = $password = $err = '';
$focus = 'username';
session_set_cookie_params(0, NULL, NULL, NULL, TRUE);

function cleanUp($string) {
    if (get_magic_quotes_gpc()) {
        $string = stripslashes($string);
    }
    $string = mysql_real_escape_string($string);
    return $string;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
    $username = $_REQUEST['username'];
    $password = $_REQUEST['password'];
    $ua       = $_SERVER['HTTP_USER_AGENT'];
    $rqt      = $_SERVER['REQUEST_TIME'];
    $rqaddr   = $_SERVER['REMOTE_ADDR'];
    $max      = mt_getrandmax();
    $rqt     .= mt_rand(0,$max);
    $rqaddr  .= mt_rand(0,$max);
    $ua      .= mt_rand(0,$max);
    $cmpid    = $rqt . $rqaddr . $ua;
    $styleSelect = $_REQUEST['styleSelect'];
    $id       = md5($cmpid);
    $db = mysql_connect($dbHost,$dbUser,$dbPass);
    $link = mysql_select_db($dbName, $db);
    if ($link) {
        $user = cleanUp($username);
        $query = "SELECT * FROM user_info WHERE username = '$user'";
        $result = mysql_query($query);
        $numRows = mysql_num_rows($result);

        if ($numRows > 0) {
            while ($row = mysql_fetch_row($result)) {
                $userName	= $row[1];
                $lastLogin	= $row[2];
                $userHash	= $row[3];
                $userEmail      = $row[4];
                $userType       = $row[5];
                $userTime       = $row[6];
                $tzoffset	= $row[7];
            }
            // The first 2 chars are the salt     
            $theSalt = substr($userHash, 0,2);

            // The remainder is the hash
            $theHash = substr($userHash, 2);

            // Now we hash the users input                 
            $testHash = sha1($password . $theSalt);

            // Does it match? If yes, start the session.
            if ($testHash === $theHash) {
                session_start();

                // Protect against session fixation attack
                if (!isset($_SESSION['initiated'])) {
                    session_regenerate_id();
                    $_SESSION['initiated'] = true;
                }

                $_SESSION['sLogin']	= 1;
                $_SESSION['sUser']	= $userName;
                $_SESSION['sPass']	= $password;        
                $_SESSION['sEmail']	= $userEmail;
                $_SESSION['sType']      = $userType;
                $_SESSION['sTime']	= $userTime;
                $_SESSION['tzoffset']   = $tzoffset;
                $_SESSION['sTab']       = 't_sum';
                $_SESSION['id']         = $id;
                
	        header ("Location: $styleSelect?id=$id");
            } else {
                $err = '<br>Wrong - Try again<br><br>';
                $focus = 'username';
            }
        } else {   
            $err = '<br>Wrong - Try again<br><br>';
            $focus = 'username';     
        }
    } else {
        $err = 'Connection Failed';
    }
}
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN"
   "http://www.w3.org/TR/html4/strict.dtd">
<html>
<head>
<title>Squert - Login</title>
<style type="text/css" media="screen">@import ".css/login-blue.css";</style>
<script type="text/javascript" src=".js/jq.js"></script>
</head>
<body>
<form name=credcheck method=post action=login.php>
<br><br><br><br>

<table class=boxes width=250 align=center cellpadding=1 cellspacing=0>
	<tr>
		<td colspan=2 class=header>
		Squert Network Security
		</td>
	</tr>
	<tr>
		<td colspan=2 class=header2>
		Note: Chrome or Firefox only
		</td>
	</tr>
	<tr>
		<td colspan=2 class=boxes>
		Style Selection
		</td>
	</tr>
	<tr>
		<td class=boxes>
		&nbsp;&nbsp;&nbsp;<input type=radio name="styleSelect" value="index-blue.php" checked> Blue
		</td>
		<td class=boxes>
		<input type=radio name="styleSelect" value="index.php"> Red
		</td>
	</tr>
	<tr>
		<td colspan=2 class=boxes>
		<hr size=1 width=206 align=left>
		Username<br>
		<input class=in type=text name=username value="<?php echo htmlentities($username);?>" maxlength="30">
		</td>
	</tr>
	<tr>
		<td colspan=2 class=boxes>
		Password<br>
		<input class=in type=password name=password value="" maxlength="30">
		</td>
	</tr>
	<tr>
		<td colspan=2 class=boxes align=right>
		<input id=logmein name=logmein class=rb type=submit name=login value=submit>
		&nbsp;&nbsp;&nbsp;
		</td>
	</tr>
	<tr>
		<td colspan=2 class=err align=center><?php echo $err;?></td>
	</tr>
</table>
<div class=cp><!-- Version 1.5.0 --><span></span></div>
</form>
<script type="text/javascript">document.credcheck.<?php echo $focus;?>.focus();</script>
</body>
</html>
