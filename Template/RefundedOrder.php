<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:21
 */

namespace Template;

class RefundedOrder {
	function GetName() {
		return 'Отмена заказа с возвратом средств';
	}

	function GetDescription() {
		return 'Шаблон для события отмена заказа с возвратом средств, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}