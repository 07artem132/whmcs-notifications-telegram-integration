<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:14
 */

namespace Template;

class NewStaffReplyTicket {
	function GetName() {
		return 'Новый ответ сотрудника в тикете';
	}

	function GetDescription() {
		return 'Шаблон для события новый ответ сотрудника в тикете, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}