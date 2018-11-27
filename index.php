<?php
	$memcache = new Memcache;
	$memcache->connect('127.0.0.1', 11211);
	$online = 0;
	$currentTime = time();
	//set cookie
	if(!isset($_COOKIE['bnc_online'])) setcookie('bnc_online', uniqid(), time() + (86400 * 30), "/");
	$token = $_COOKIE['bnc_online'];
	$read = $memcache->get('online');
	$object = new stdClass;
	$object = (object)$read;
	$object->$token = $currentTime;
	//delete
	foreach($object as $key=>$value)
	{
		if($currentTime-$value>10) unset($object->$key);
		else $online++;
	}
	$memcache->set('online', $object, false, 120); 
	echo $online;
	exit();
?>