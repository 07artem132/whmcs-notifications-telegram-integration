<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.11.2017
 * Time: 15:52
 */

namespace Template;

class NewTicket {
	function GetName() {
		return 'Создание тикета';
	}

	function GetDescription() {
		return 'Шаблон для события создание тикета, ID шаблона: ';
	}

	function FormatedNotifi( $notification ) {
		$Title     = explode( '-', $notification->getTitle() )[1];
		$TicketNum = trim( mb_substr( explode( '-', $notification->getTitle() )[0], 1 ) );

		foreach ( $notification->getAttributes() as $attribute ) {
			if ( $attribute->getLabel() === 'Отдел' ) {
				$Department = $attribute->getValue();
			}
			if ( $attribute->getLabel() === 'Клиент' ) {
				$Client = $attribute->getValue();
			}
			if ( $attribute->getLabel() === 'Срочность' ) {
				$Urgency = $attribute->getValue();
			}
			if ( $attribute->getLabel() === 'Статус' ) {
				$Status = $attribute->getValue();
			}
		}

		$message = sprintf( $this->GetMessage(), $Title, $Department, $notification->getUrl(), $this->GetTicketMessage( $TicketNum ) );

		return $message;
	}

	function GetTicketMessage( $TicketNum ) {
		$command = 'GetTicket';

		$postData['ticketnum'] = $TicketNum;

		$results = localAPI( $command, $postData );

		return trim( explode( '-', $results['replies']['reply'][0]['message'] )[0] );
	}

	function GetMessage() {
		return 'Был создан новый тикет ' .PHP_EOL
		       . 'Тема: %s'.PHP_EOL
		       . 'В отделе: %s'.PHP_EOL
		       . 'Ссылка: %s'.PHP_EOL
		       . 'Сообщение: %s'.PHP_EOL;
	}
}