<?php

	#################################################################

	function cache_memcache_init($host, $port){

		$memcache = new Memcache();

		if (! $memcache->connect($host, $port)){
			$memcache = null;
			log_notice("Failed to connect to memcache!");
		}

		return $memcache;
	}

	#################################################################

	function cache_memcache_get($cache_key){

		$memcache = $GLOBALS['cfg']['memcache_conn'];

		if (! $memcache){
			return array( 'ok' => 0 );
		}

		$rsp = $memcache->get($cache_key);

		if (! $rsp){
			return array( 'ok' => 0 );
		}

		return array(
			'ok' => 1,
			'data' => unserialize($rsp),
		);
	}

	#################################################################

	function cache_memcache_set($cache_key, $data){

		$memcache = $GLOBALS['cfg']['memcache_cache_conn'];

		if (! $memcache){
			return array( 'ok' => 0 );
		}

		$ok = $memcache->set($cache_key, serialize($data));
		return array( 'ok' => $ok );
	}

	#################################################################

	function cache_memcache_unset($cache_key){

		$memcache = $GLOBALS['cfg']['memcache_cache_conn'];

		if (! $memcache){
			return array( 'ok' => 0 );
		}

		$ok = $memcache->unset($cache_key);
		return array( 'ok' => $ok );
	}

	#################################################################
?>
