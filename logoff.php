<?php
	session_start();
	$_SESSION = array();
	if (isset( $_COOKIE[session_name()]))
		setcookie(session_name(),'',time()-7*24*60*60);
	session_destroy();
	header('Location: ../');
?>