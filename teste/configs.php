<?php
	$sandbox = true;
	define("EMAIL_PAGSEGURO", "artursantosvale2@gmail.com");
	define("URL_NOTIFICATION", "https://github.com/JulimarJunior/pagseguro/blob/main/notify.php");
	
	if($sandbox){
		// SandBox Credentials
	    define("TOKEN_PAGSEGURO", "44E777010D0D5F777495EFAAFD2C37E8");
	    define("URL_PAGSEGURO", "https://ws.sandbox.pagseguro.uol.com.br/v2/");
	    define("SCRIPT_PAGSEGURO", "https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
	} else{
		// Official Credentials
	    define("TOKEN_PAGSEGURO", "123456789123456789");
	    define("URL_PAGSEGURO", "https://ws.pagseguro.uol.com.br/v2/");
	    define("SCRIPT_PAGSEGURO", "https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js");
	}
