<?php

	define ("SECRET_KEY", 'tGE(E&GgsVWvC2y8?wKwyZRnM@');
	define ("SECRET_IV", 'a*(3r>Q)T^ni4wyj');
	define ("ENCRYPT_METHOD", "AES-256-CBC");

	function hashId($id){
		$key = hash( 'sha256', SECRET_KEY );
		$iv = substr( hash( 'sha256', SECRET_IV ), 0, 16 );
		
		if (is_numeric($id)){
			return base64_encode( openssl_encrypt( $id, ENCRYPT_METHOD, $key, 0, $iv ) );
		}else{
			return $id;
		}
	}

	function decodeId($hash){
		
		if (strlen($hash) < 5) $hash = intval($hash);
		
		if (is_int($hash)){
			return $hash;
		}else{
			$key = hash( 'sha256', SECRET_KEY );
			$iv = substr( hash( 'sha256', SECRET_IV ), 0, 16 );
			return intval(openssl_decrypt( base64_decode( $hash ), ENCRYPT_METHOD, $key, 0, $iv ));
		}
	}

?>