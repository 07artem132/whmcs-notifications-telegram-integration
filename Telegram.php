<?php

namespace WHMCS\Module\Notification\Telegram;

use WHMCS\Config\Setting;
use WHMCS\Exception;
use WHMCS\Module\Notification\DescriptionTrait;
use WHMCS\Module\Contracts\NotificationModuleInterface;
use WHMCS\Notification\Contracts\NotificationInterface;

require __DIR__ . '/vendor/autoload.php';

use \Lib\Template;
use \Lib\Telegram as TelegramAPI;
use \Lib\Licensing;

/**
 * Notification module for delivering notifications via email
 *
 * All notification modules must implement NotificationModuleInterface
 *
 * @copyright Copyright (c) WHMCS Limited 2005-2017
 * @license http://www.whmcs.com/license/ WHMCS Eula
 */
class Telegram implements NotificationModuleInterface {
	use DescriptionTrait;

	/**
	 * Constructor
	 *
	 * Any instance of a notification module should have the display name and
	 * logo filename at the ready.  Therefore it is recommend to ensure these
	 * values are set during object instantiation.
	 *
	 * The Email notification module utilizes the DescriptionTrait which
	 * provides methods to fulfill this requirement.
	 *
	 * @see \WHMCS\Module\Notification\DescriptionTrait::setDisplayName()
	 * @see \WHMCS\Module\Notification\DescriptionTrait::setLogoFileName()
	 */
	public function __construct() {
		$Licensing = new Licensing();

		$this->setDisplayName( 'Telegram' )
		     ->setLogoFileName( 'logo.png' );
	}

	/**
	 * Settings required for module configuration
	 *
	 * The method should provide a description of common settings required
	 * for the notification module to function.
	 *
	 * For example, if the module connects to a remote messaging service this
	 * might be username and password or OAuth token fields required to
	 * authenticate to that service.
	 *
	 * This is used to build a form in the UI.  The values submitted by the
	 * admin based on the form will be validated prior to save.
	 * @see testConnection()
	 *
	 * The return value should be an array structured like other WHMCS modules.
	 * @link https://developers.whmcs.com/payment-gateways/configuration/
	 *
	 * For the Email notification module, the module settings are the sender
	 * name and email.  Every email notification will use these values.
	 * Other email values, like recipients are defined on a per notification
	 * basis.
	 * @see notifictionSettings()
	 *
	 * EX.
	 * return [
	 *     'api_username' => [
	 *         'FriendlyName' => 'API Username',
	 *         'Type' => 'text',
	 *         'Description' => 'Required username to authenticate with message service',
	 *     ],
	 *     'api_password' => [
	 *         'FriendlyName' => 'API Password',
	 *         'Type' => 'password',
	 *         'Description' => 'Required password to authenticate with message service',
	 *     ],
	 * ];
	 *
	 * @return array
	 */
	public function settings() {
		return [
			'ApiKey'   => [
				'FriendlyName' => 'API key',
				'Type'         => 'text',
				'Description'  => 'Введите api ключ полученный от BotFather',
				'Placeholder'  => '125479523:asdfqwrtgsfgwsfgwertsfdgsdfgsdfgwer',
			],
			'Username' => [
				'FriendlyName' => 'Username бота',
				'Type'         => 'text',
				'Description'  => 'Введите username зарегистрированного вами бота.',
				'Placeholder'  => '@telegram_bot',
			]
		];
	}

	/**
	 * Validate settings for notification module
	 *
	 * This method will be invoked prior to saving any settings via the UI.
	 *
	 * Leverage this method to verify authentication and/or authorization when
	 * the notification service requires a remote connection.
	 *
	 * For the Email notification module, connectivity details are already
	 * defined by the WHMCS core system, and there are no settings which
	 * require further validation, so this method will always return TRUE.
	 *
	 * @param array $settings
	 *
	 * @return boolean
	 */
	public function testConnection( $settings ) {
		$Telegram = new TelegramAPI( $settings['ApiKey'], $settings['Username'] );

		return $Telegram->TestConnection();
	}

	/**
	 * The individual customisable settings for a notification.
	 *
	 * EX.
	 * ['channel' => [
	 *     'FriendlyName' => 'Channel',
	 *     'Type' => 'dynamic',
	 *     'Description' => 'Select the desired channel for notification delivery.',
	 *     'Required' => true,
	 *     ],
	 * ]
	 *
	 * The "Type" of a setting can be text, textarea, yesno, system and dynamic
	 *
	 * @see getDynamicField for how to obtain dynamic values
	 *
	 * For the Email notification module, the notification should be configured
	 * to use a email template and one or more recipients.
	 *
	 * @return array
	 */
	public function notificationSettings() {
		return [
			'MessageTemplate'  => [
				'FriendlyName' => 'Шаблон уведомления',
				'Type'         => 'dynamic',
				'Description'  => 'Выберите шаблон уведомления в зависимости от типа события',
			],
			'MessageSendGroup' => [
				'FriendlyName' => 'Кому отправлять уведомления',
				'Type'         => 'dynamic',
				'Description'  => 'Выберите группу или пользователя которая(ый) будет получать уведомления о событиях,'
				                  . 'в случае если вашего варианта нет напишите боту с того аккаунта который необходимо уведомлять,'
				                  . 'если вы добавили его в группу то напишите сообщение в группе.',
			]
		];
	}

	/**
	 * The option values available for a 'dynamic' Type notification setting
	 *
	 * @see notificationSettings()
	 *
	 * EX.
	 * if ($fieldName == 'channel') {
	 *     return [ 'values' => [
	 *         ['id' => 1, 'name' => 'Tech Support', 'description' => 'Channel ID',],
	 *         ['id' => 2, 'name' => 'Customer Service', 'description' => 'Channel ID',],
	 *     ],];
	 * } elseif ($fieldName == 'botname') {
	 *     $restClient = $this->factoryHttpClient($settings);
	 *     $operators = $restClient->get('/operators');
	 *     return ['values' => $operators->toArray()];
	 * }
	 *
	 * For the Email notification module, a list of possible email templates is
	 * aggregated.
	 *
	 * @param string $fieldName Notification setting field name
	 * @param array $settings Settings for the module
	 *
	 * @return array
	 */
	public function getDynamicField( $fieldName, $settings ) {
		if ( $fieldName == 'MessageTemplate' ) {
			$Templates = new Template();

			if ( empty( $Templates = $Templates->GetAll() ) ) {
				return [];
			}

			foreach ( $Templates as $id => $template ) {
				$values[] = [
					'description' => $template->GetDescription(),
					'id'          => $id,
					'name'        => $template->GetName(),
				];
			}

			return [ 'values' => $values ];
		}

		if ( $fieldName == 'MessageSendGroup' ) {
			$TelegramAPI        = new TelegramAPI( $settings['ApiKey'], $settings['Username'] );
			$GroupOrChatMembers = $TelegramAPI->GetGroupOrChatMembers();
			foreach ( $GroupOrChatMembers as $id => $item ) {
				if ( $item['type'] === 'private' ) {
					$name        = 'Отправлять сообщение пользователю ' . $item['title'];
					$description = 'id пользователя: ';
				} else {
					$name        = 'Отправлять сообщение в группу ' . $item['title'];
					$description = 'id группы: ';
				}

				$values[] = [
					'id'          => $id,
					'name'        => $name,
					'description' => $description,
				];
			}

			return [ 'values' => $values ];
		}

		return [];
	}

	/**
	 * Deliver notification
	 *
	 * This method is invoked when rule criteria are met.
	 *
	 * In this method, you should craft an appropriately formatted message and
	 * transmit it to the messaging service.
	 *
	 * For the Email notification module, an email template instance is created
	 * along with a collection of merge field data (aggregated from all three
	 * method arguments respectively). Those items are provided to the local
	 * API 'sendmail' action, where an email message is generated and delivered.
	 *
	 * @param NotificationInterface $notification A notification to send
	 * @param array $moduleSettings Configured settings of the notification module
	 * @param array $notificationSettings Configured notification settings set by the triggered rule
	 *
	 * @throws Exception on error of sending email
	 */
	public function sendNotification( NotificationInterface $notification, $moduleSettings, $notificationSettings ) {
		$Template = new  Template();

		$Template = $Template->findOrFail( $notificationSettings['MessageTemplate'] );
		$message  = $Template->FormatedNotifi( $notification );

		$SendTo = explode( '|', $notificationSettings['MessageSendGroup'] )[0];

		$Telegram = new TelegramAPI( $moduleSettings['ApiKey'], $moduleSettings['Username'] );
		$Telegram->SendMessage( $SendTo, $message );
	}
}
