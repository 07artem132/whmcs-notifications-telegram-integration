<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 30.01.2018
 * Time: 18:14
 */

namespace Template;

class NewNoteTicket {
	function GetName() {
		return 'Добавлена заметка для тикета';
	}

	function GetDescription() {
		return 'Шаблон для события добавление заметки для тикета, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$message = 'Cобытие:' . $this->GetName() . PHP_EOL;

		foreach ( $notification->getAttributes() as $attribute ) {
			$message .= $attribute->getLabel() . '  ' . $attribute->getValue() . PHP_EOL;
		}

		return $message;
	}
}