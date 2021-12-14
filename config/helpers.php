<?php
	// CONNECTION
	require_once('connection.php');

   // SET DEFAULT TIME
    date_default_timezone_set("Asia/Jakarta");

    // NAME APPS AND NOTICE FROM CONFIG TABLE
    $runSql = mysqli_query($link, "SELECT * FROM config");
    $config = mysqli_fetch_assoc($runSql);
    define("NAME_APPS", $config['name_apps']);
    define("admin", $config['author']);

    // BASE URL (safetygoldenbell adalah nama folder di htdocs)
    define("BASE_URL", (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]"."/safetygoldenbell/");

    // ACCOUNT : AUTHENTICATION USER
    function authentication(){
    	if (isset($_SESSION['user'])){
    		return true;
    	} else {
    		return false;
    	}
    }

    // ACCOUNT : GET MY NAME
    function getMyName(){
    	if (isset($_SESSION['user'])){
	        global $link;

	        $runQuery = mysqli_query($link, "SELECT fullname FROM users WHERE username = '".$_SESSION['user']."'");
	        $fullName = mysqli_fetch_assoc($runQuery);
	        $fullName = $fullName['fullname'];

	        return $fullName;
    	} else {
    		return null;
    	}
    }

    // ACCOUNT : GET MY ID
    function getMyId(){
    	if (isset($_SESSION['user'])){
	        global $link;

	        $runQuery = mysqli_query($link, "SELECT id FROM users WHERE username = '".$_SESSION['user']."'");
	        $id = mysqli_fetch_assoc($runQuery);
	        $id = $id['id'];

	        return $id;
    	} else {
    		return null;
    	}
    }

    // ACCOUNT : GET MY USERNAME BY ID
    function getMyUsernameById($id){
    	if (isset($_SESSION['user'])){
	        global $link;

	        $runQuery = mysqli_query($link, "SELECT username FROM users WHERE id = $id");
	        $username = mysqli_fetch_assoc($runQuery);
	        $username = $username['username'];

	        return $username;
    	} else {
    		return null;
    	}
    }

    // ACCOUNT : GET MY FULLNAME BY ID
    function getMyFullnameById($id){
    	if (isset($_SESSION['user'])){
	        global $link;

	        $runQuery = mysqli_query($link, "SELECT fullname FROM users WHERE id = $id");
	        $fullname = mysqli_fetch_assoc($runQuery);
	        $fullname = $fullname['fullname'];

	        return $fullname;
    	} else {
    		return null;
    	}
    }

    // ACCOUNT : GET MY LEVEL NAME
    function getMyLevelName(){
    	if (isset($_SESSION['user']) === true && isset($_SESSION['level']) === true){
	      	if ($_SESSION['level'] == 1){
	      		return 'Administrator';
	      	} elseif ($_SESSION['level'] == 2) {
                return 'Anggota';
            } elseif ($_SESSION['level'] == 3) {
	      		return 'Narasumber';
	      	}
    	} else {
    		return null;
    	}
    }

    // ACCOUNT : GET MY LEVEL NAME BY USERNAME
    function getMyLevelNameById($id){
    	if (isset($_SESSION['user'])){
	        global $link;

	        $runQuery = mysqli_query($link, "SELECT level FROM users WHERE id = $id");
	        $level = mysqli_fetch_assoc($runQuery);
	        $level = $level['level'];

           	if ($level == 1){
	      		return 'Administrator';
	      	} elseif ($level == 2) {
                return 'Anggota';
            } elseif ($level == 3) {
	      		return 'Narasumber';
	      	}
    	} else {
    		return null;
    	}
    }
