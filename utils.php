<?php
	class Utils {
    	public static function throwError($message) {
			!headers_sent() && header('Content-Type: application/json');
        	echo json_encode(["error" => $message]);
    		exit ;
    	}
	}
?>