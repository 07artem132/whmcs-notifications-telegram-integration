<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:15
 */

namespace Template;

class DepartmentChangeTicket {
	function GetName() {
		return 'Изменение отдела для тикета';
	}

	function GetDescription() {
		return 'Шаблон для события изменение отдела для тикета, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}