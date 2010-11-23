<?php

	#
	# $Id$
	#

	$GLOBALS['local_cache'] = array();

	#################################################################

	function cache_get($cache_key){

		$cache_key = _cache_prepare_cache_key($cache_key);
		log_notice("cache", "fetch cache key {$cache_key}");

		if (isset($GLOBALS['local_cache'][$cache_key])){

			return array(
				'ok' => 1,
				'cache' => 'local',
				'cache_key' => $cache_key,
				'data' => $GLOBALS['local_cache'][$cache_key],
			);
		}

		# fetch from memcache, etc. here

		return array( 'ok' => 0 );
	}

	#################################################################

	function cache_set($cache_key, $data, $store_locally=0){

		$cache_key = _cache_prepare_cache_key($cache_key);
		log_notice("cache", "set cache key {$cache_key}");

		if ($store_locally){
			$GLOBALS['local_cache'][$cache_key] = $data;
		}

		# store in memcache, etc. here

		return array( 'ok' => 1 );
	}

	#################################################################

	function cache_unset($cache_key){

		$cache_key = _cache_prepare_cache_key($cache_key);
		log_notice("cache", "unset cache key {$cache_key}");

		if (isset($GLOBALS['local_cache'][$cache_key])){
			unset($GLOBALS['local_cache'][$cache_key]);
		}

		# remove from memcache, etc. here

		return array( 'ok' => 1 );
	}

	#################################################################

	function _cache_prepare_cache_key($key){
		return $key;
	}

	#################################################################
?>