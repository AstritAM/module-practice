<?php

defined('B_PROLOG_INCLUDED') and (B_PROLOG_INCLUDED === true) or die();

use Bitrix\Main\EventManager;
use Bitrix\Main\ModuleManager;

use Practice\Element\Events\EndSentenceEvent;

class practice_element extends \CModule
{
    public const MODULE_ID = 'practice.element';

    public function __construct()
    {
        $this->MODULE_NAME         = 'Пример модуля';
        $this->MODULE_DESCRIPTION  = 'Пример модуля';
        $this->MODULE_ID           = self::MODULE_ID;
        $this->MODULE_VERSION      = '1.0.0';
        $this->MODULE_VERSION_DATE = '2024-01-18';
        $this->MODULE_GROUP_RIGHTS = 'N';
        $this->PARTNER_NAME        = 'Example';
        $this->PARTNER_URI         = 'https://webpractik.ru';
    }

    public function doInstall()
    {
        EventManager::getInstance()->registerEventHandler(
            'iblock',
            'OnBeforeIBlockElementUpdate',
            $this->MODULE_ID,
            EndSentenceEvent::class,
            'handleOnBeforeElementUpdate'
        );

        CAgent::AddAgent(
            "Practice\Element\Agents\DeactivateDuplicateTitlesAgent::execute();",
            $this->MODULE_ID,
            "Y",
            300,
            "",
            "Y",
            date("d.m.Y H:i:s"),
            30
        );

        CAgent::AddAgent(
            "EditTitleAgent::execute();",
            $this->MODULE_ID,
            "N",
            10,
            "",
            "Y",
            date('d.m.Y H:i:s'),
            10
        );

        $this->installFiles();
        ModuleManager::registerModule($this->MODULE_ID);

    }

    public function doUninstall()
    {
        ModuleManager::unRegisterModule($this->MODULE_ID);

        $this->unInstallFiles();

        EventManager::getInstance()->unRegisterEventHandler(
            'iblock',
            'OnBeforeIBlockElementUpdate',
            $this->MODULE_ID,
            EndSentenceEvent::class,
            'handleOnBeforeElementUpdate'
        );

        CAgent::RemoveAgent(
            "Practice\Element\Agents\DeactivateDuplicateTitlesAgent::execute();",
            $this->MODULE_ID
        );

        CAgent::RemoveAgent(
            "Practice\Element\Agents\EditTitleAgent::execute();",
            $this->MODULE_ID
        );
    }


    public function installFiles(): void
    {
        CopyDirFiles(
            $_SERVER['DOCUMENT_ROOT'] . '/local/modules/' . $this->MODULE_ID . '/install/admin',
            $_SERVER['DOCUMENT_ROOT'] . '/bitrix/admin',
            true,
            true
        );
    }

    public function unInstallFiles(): void
    {
        DeleteDirFilesEx('/bitrix/admin/adminpage.php');
    }
}
