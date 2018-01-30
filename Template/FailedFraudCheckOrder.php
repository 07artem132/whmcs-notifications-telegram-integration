<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:22
 */

namespace Template;

class FailedFraudCheckOrder {
	function GetName() {
		return 'Ошибка при проверке заказа на мошенничество';
	}

	function GetDescription() {
		return 'Шаблон для события ошибка при проверке заказа на мошенничество, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}