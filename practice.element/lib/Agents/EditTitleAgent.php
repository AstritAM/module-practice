<?php

namespace Practice\Element\Agents;

use Bitrix\Iblock\Elements\ElementPracticeTable;

class EditTitleAgent
{
    public static function execute()
    {
        $data = ElementPracticeTable::query()
            ->addSelect('ID')
            ->addSelect('NAME')
            ->fetchAll();

        foreach ($data as $item) {
            $newTitle = $item['NAME'] . '!';

            ElementPracticeTable::update($item['ID'], ['NAME' => $newTitle]);
        }
    }
}
