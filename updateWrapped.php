<?php
	// Release a year of Wrapped to every member, send it to one member, or take either
	// back. Admins only.
	require "logged_in_check.php";
	require "set_session_vars_short.php";
	require "database_connect.php";
	require_once "lib/wrapped.php";

	if ($isAdmin != 1) {
		header('Location: points.php');
		exit;
	}

	$year   = isset($_POST['year']) ? (int)$_POST['year'] : 0;
	$action = isset($_POST['action']) ? $_POST['action'] : '';
	$token  = isset($_POST['token']) ? (string)$_POST['token'] : '';
	$to     = isset($_POST['id']) ? (int)$_POST['id'] : 0;
	$back   = 'wrapped.php?year='.$year.(($to > 0) ? '&id='.$to : '');

	// The token is set when an admin loads wrapped.php, so only that form can do this.
	if (!isset($_SESSION['wrappedToken']) || !hash_equals($_SESSION['wrappedToken'], $token)
	    || !in_array($year, wrapped_years($db), true)) {
		header('Location: '.$back.'&err=1');
		exit;
	}

	try {
		if ($action === 'release')   { wrapped_release($db, $year, $memberID); }
		if ($action === 'unrelease') { wrapped_unrelease($db, $year); }
		if ($action === 'send' && $to > 0)   { wrapped_send($db, $to, $year, $memberID); }
		if ($action === 'unsend' && $to > 0) { wrapped_unsend($db, $to, $year); }
	} catch (PDOException $e) {
		header('Location: '.$back.'&err=table');
		exit;
	}

	header('Location: '.$back);
	exit;
