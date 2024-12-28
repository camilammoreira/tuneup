<?php
session_start();
if (!isset($_SESSION['usuId']))
	header('Location: ../login.php');
?>