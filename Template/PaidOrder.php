<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:21
 */

namespace Template;

class PaidOrder {
	function GetName() {
		return 'Заказ оплачен';
	}

	function GetDescription() {
		return 'Шаблон для события заказ оплачен, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}