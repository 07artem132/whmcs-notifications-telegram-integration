<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.11.2017
 * Time: 20:55
 */

namespace Lib;

use Virgil\Sdk\Api\VirgilApi;

class licensing {
	private $Token = 'AT.9ae743273ca3b63d1980e0a91137d53d83cec71d1f77e063a9324fa47655000a';

	public function __construct() {
		$virgilApi  = VirgilApi::create( $this->Token );
		$aliceCards = $virgilApi->Cards->find( [ 'alice' ] );

		$message          = 'Hello Alice!';
		$encryptedMessage = $aliceCards->encrypt( $message );
		$encryptedMessage->toBase64();

	}

	function GetServerIP() {
		return $_SERVER['SERVER_ADDR'];
	}

	function GetPath() {
		return __DIR__;
	}

	function GetServerName() {
		return $_SERVER['SERVER_NAME'];
	}

	function GetServerSignature() {
		return $_SERVER['SERVER_SIGNATURE'];
	}
}