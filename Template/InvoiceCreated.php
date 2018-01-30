<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:08
 */

namespace Template;

class InvoiceCreated {
	function GetName() {
		return 'Счет создан';
	}

	function GetDescription() {
		return 'Шаблон для события создание счета, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}