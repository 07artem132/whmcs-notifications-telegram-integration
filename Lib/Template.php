<?php
/**
 * Created by PhpStorm.
 * User: Artem
 * Date: 12.11.2017
 * Time: 16:37
 */

namespace Lib;

use WHMCS\Exception;


class Template {
	private $TemplateObject = [];

	function __construct() {
		$TemplateName = array_diff( scandir( __DIR__ . '/../Template' ), array( '..', '.' ) );
		$TemplateName = $this->FormattedTemplateName( $TemplateName );
		$this->CreateTemplateObject( $TemplateName );
	}

	function GetAll() {
		return $this->TemplateObject;
	}

	function findOrFail( $notificationSettings ) {
		$TemplateID   = explode( '|', $notificationSettings )[0];
		$TemplateName = explode( '|', $notificationSettings )[1];

		if ( $this->GetAll()[ $TemplateID ]->GetName() === $TemplateName ) {
			return $this->GetAll()[ $TemplateID ];
		} else {
			foreach ( $this->GetAll() as $Template ) {
				if ( $Template->GetName() === $TemplateName ) {
					return $Template;
				}
			}
		}

		throw new Exception( 'Указанный в настройках шаблон не найден' );
	}

	function CreateTemplateObject( $TemplateName ) {
		foreach ( $TemplateName as $item ) {
			$className              = "Template\\" . $item;
			$this->TemplateObject[] = new $className();
		}
	}

	function FormattedTemplateName( $TemplateName ) {
		foreach ( $TemplateName as $item ) {
			$result[] = substr( $item, 0, - 4 );
		}

		return $result;
	}
}