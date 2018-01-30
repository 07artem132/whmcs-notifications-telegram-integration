<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:24
 */
namespace Template;

class ServiceCancellationRequestSubmitted {
	function GetName() {
		return 'Создана отмена услуги';
	}

	function GetDescription() {
		return 'Шаблон для события отмена услуги, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}