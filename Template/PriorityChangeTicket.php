<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:15
 */

namespace Template;

class PriorityChangeTicket {
	function GetName() {
		return 'Изменение приоритета тикета';
	}

	function GetDescription() {
		return 'Шаблон для события изменение приоритета тикета, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}