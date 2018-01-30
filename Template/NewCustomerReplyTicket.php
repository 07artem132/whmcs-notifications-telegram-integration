<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:11
 */

namespace Template;

class NewCustomerReplyTicket {
	function GetName() {
		return 'Новый ответ клиента в тикете';
	}

	function GetDescription() {
		return 'Шаблон для события новый ответ клиента в тикете, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}