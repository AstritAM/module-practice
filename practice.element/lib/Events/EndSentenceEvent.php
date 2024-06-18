<?php

namespace Practice\Element\Events;

use Bitrix\Iblock\Elements\ElementPracticeTable;
use Bitrix\Iblock\ElementTable;
use Bitrix\Main\UserTable;
use CIBlock;

class EndSentenceEvent
{
    public static function handleOnBeforeElementUpdate(&$item): void
    {
        $user = UserTable::query()
            ->setSelect(['ID', 'NAME', 'EMAIL'])
            ->where('WORK_PROFILE', 'Контент-менеджер')
            ->fetch();

        if (CIBlock::GetPermission($item['IBLOCK_ID'], $user['ID']) >= 'W') {
            $to = $user['EMAIL'];
            $subject = 'the subject';
            $message = 'Изменение элемента: ' . $item['NAME'];

            mail($to, $subject, $message);
        }
    }
}
