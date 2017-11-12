<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.11.2017
 * Time: 17:40
 */

namespace Lib;

use \Longman\TelegramBot\Telegram as TelegramAPI;
use \Longman\TelegramBot\Request as RequestTelegramAPI;

class Telegram {
	private $API;

	function __construct( $ApiKey, $Username ) {
		$this->API = new TelegramAPI( $ApiKey, $Username );
	}

	function GetGroupOrChatMembers() {
		$response = RequestTelegramAPI::getUpdates(
			[
				'offset'  => 0,
				'limit'   => 1000,
				'timeout' => 5,
			]
		);

		foreach ( $response->result as $item ) {
			$result[ $item->message['chat']['id'] ]['id']   = $item->message['chat']['id'];
			$result[ $item->message['chat']['id'] ]['type'] = $item->message['chat']['type'];

			if ( $item->message['chat']['type'] === 'private' ) {
				$result[ $item->message['chat']['id'] ]['title'] = $item->message['chat']['username'];
			}

			if ( $item->message['chat']['type'] === 'supergroup' ) {
				$result[ $item->message['chat']['id'] ]['title'] = $item->message['chat']['title'];
			}

			if ( $item->message['chat']['type'] === 'group' ) {
				$result[ $item->message['chat']['id'] ]['title'] = $item->message['chat']['title'];
			}
		}

		return $result;
	}

	function TestConnection() {
		try {
			RequestTelegramAPI::getUpdates( [
					'offset'  => 0,
					'limit'   => 1,
					'timeout' => 5,
				]
			);
		} catch ( \Exception $e ) {
			return false;
		}

		return true;
	}

	function SendMessage( $SendTo, $Message ) {
		$data = [
			'chat_id' => $SendTo,
			'text'    => $Message,
		];

		RequestTelegramAPI::sendMessage( $data );
	}
}