<?php

	#
	# $Id$
	#

	# This is *not* a general purpose wrapper library for talking to Solr.

	#################################################################

	function solr_select($url, $params=array(), $more=array()){

		$params['wt'] = 'json';

		$_params = array();

		foreach ($params as $k => $v){
			$_params[] = "$k=" . urlencode($v);
		}

		$str_params = implode('&', $_params);

		#

		if (function_exists('cache_get')){

			$cache_key = "solr_select_" . md5($str_params);
			$cache = cache_get($cache_key);

			if ($cache['ok']){
				return $cache['data'];
			}
		}

		#

		$http_rsp = http_post($url, $str_params);

		if (! $http_rsp['ok']){
			return $http_rsp;
		}

		$as_array = True;
		$json = json_decode($http_rsp['body'], $as_array);

		if (! $json){
			return array(
				'ok' => 0,
				'error' => 'Failed to parse response',
			);
		}

		$rsp = array(
			'ok' => 1,
			'rows' => $json,	# this probably needs to be keyed off something I've forgotten about
		);

		if (function_exists('cache_set')){
			cache_set($cache_key, $rsp);
		}

		return $rsp;
	}

	#################################################################
?>
