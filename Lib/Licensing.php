<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.11.2017
 * Time: 20:55
 */

namespace Lib;

use LicensingAPIServiceVoice\Lib\LicensingController as LicensingAPI;

class Licensing  extends LicensingAPI{
	private $moduleName = 'whmcsNotificationsTelegramIntegration';

	public function __construct() {

	}

	public function WSACheck($AllowModule) {
		$result = CheckIsValid("sosatIsAlexandra", $AllowModule, WSAXORdec("true", WSAXORdec($AllowModule, "sosatIsAlexandra")));

	}

	public function WSAXORenc($string, $key)
	{
		return base64_encode($string.$key);
	}

	public function WSAXORdec($string, $key)
	{
		$res = base64_decode($string);
		return substr($res, 0,strlen( $string ) - strlen($key) * 2);
	}

	public function CheckIsValid($AllowModule, $keyName, $returnValue ) {
		if ( array_key_exists( $keyName, $AllowModule ) ) {
			if ( $AllowModule[ $keyName ] === true ) {
				return WSAXORenc($returnValue, WSAXORenc($keyName, $AllowModule));
			}
		}
		return "0";
	}
}