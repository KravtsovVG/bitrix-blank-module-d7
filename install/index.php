<?

use Bitrix\Main\Localization\Loc;
use Bitrix\Main\Application;
use Bitrix\Main\ModuleManager;

Loc::loadMessages(__FILE__);

Class blank_module extends CModule
{
	var $MODULE_ID = "soobwa.commentspro";
	var $MODULE_VERSION;
	var $MODULE_VERSION_DATE;
	var $MODULE_NAME;
	var $MODULE_DESCRIPTION;
	var $MODULE_CSS;
	var $MODULE_GROUP_RIGHTS = "Y";

	function __construct()
	{
		//	Получаем версию и дату из файла version.php
		$arModuleVersion = array();
		$path = str_replace("\\", "/", __FILE__);
		$path = substr($path, 0, strlen($path) - strlen("/index.php"));

		include($path."/version.php");

		if (is_array($arModuleVersion) && array_key_exists("VERSION", $arModuleVersion))
		{
			$this->MODULE_VERSION = $arModuleVersion["VERSION"];
			$this->MODULE_VERSION_DATE = $arModuleVersion["VERSION_DATE"];
		}

		$this->MODULE_NAME = Loc::getMessage('BLANK_MODULE_MODULE_NAME');
		$this->MODULE_DESCRIPTION = Loc::getMessage('BLANK_MODULE_MODULE_DESCRIPTION');
		$this->PARTNER_NAME = Loc::getMessage('BLANK_MODULE_PARTNER_NAME');
		$this->PARTNER_URI = "";
	}

	/*
	 * 	Устанавливаем все, что связано с БД
	 * */
	function InstallDB()
	{
		// Сохранил путь к модулю
		Option::set("soobwa_commentspro", "path", $this->GetPath(true));

		return true;
	}

	/*
	 * 	Удаляем все, что связано с БД
	 * */
	function UnInstallDB()
	{
		// Удаляем путь к модулю
		Option::delete("soobwa_commentspro", "path");

		return true;
	}

	/*
	 * 	Устанавливаем события
	 * */
	function InstallEvents()
	{
		return true;
	}

	/*
	 * 	Удаляем события
	 * */
	function UnInstallEvents()
	{
		return true;
	}

	/*
	 * 	Устанавливаем файлы
	 * */
	function InstallFiles()
	{
		// Копируем компоненты
		//CopyDirFiles($this->GetPath()."/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components", true, true);

		// Копируем гаджет
		//CopyDirFiles($this->GetPath()."/install/gadgets", $_SERVER["DOCUMENT_ROOT"]."/bitrix/gadgets", true, true);

		// Копируем админские файлы
		//CopyDirFiles($this->GetPath()."/install/admin/", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin", true, true);

		return true;
	}

	/*
	 * 	Удалаяем файлы
	 * */
	function UnInstallFiles()
	{
		// Удоляем компоненты
		//DeleteDirFiles($this->GetPath()."/install/components", $_SERVER["DOCUMENT_ROOT"]."/bitrix/components");

		// Удаляет гаджет
		//DeleteDirFiles($this->GetPath()."/install/gadgets", $_SERVER["DOCUMENT_ROOT"]."/bitrix/gadgets");

		// Удоляем админские файлы
		//DeleteDirFiles($this->GetPath()."/install/admin", $_SERVER["DOCUMENT_ROOT"]."/bitrix/admin");

		return true;
	}

	function DoInstall()
	{
		// Регистрируем модуль
		ModuleManager::registerModule($this->MODULE_ID);

		$this->InstallDB();
		$this->InstallEvents();
		$this->InstallFiles();
	}

	function DoUninstall()
	{
		$this->UnInstallFiles();
		$this->UnInstallEvents();
		$this->UnInstallDB();

		// Удаляем регистрацию модуля
		ModuleManager::unRegisterModule($this->MODULE_ID);
	}

	/**
	 * Определяем место размещения модуля
	 *
	 * @return string - путь к модулю
	 */
	public function GetPath($notDocRoot = false)
	{
		if($notDocRoot){
			return str_ireplace(Application::getDocumentRoot(),'',dirname(__DIR__));
		}else{
			return dirname(__DIR__);
		}
	}
}
?>