<?php

namespace Practice\Element\Agents;

use Bitrix\Iblock\Elements\ElementPracticeTable;

class DeactivateDuplicateTitlesAgent
{
    public static function execute()
    {
        $uniqueTitles = [];

        $data = ElementPracticeTable::query()
            ->addSelect('ID')
            ->addSelect('NAME')
            ->addOrder('DATE_CREATE', 'desc')
            ->where('ACTIVE', 'Y')
            ->fetchAll();

        foreach ($data as $item) {
            if (!array_key_exists($item['NAME'], $uniqueTitles)) {
                $uniqueTitles[$item['NAME']] = $item['ID'];
            } else {
                ElementPracticeTable::update($item['ID'], ['ACTIVE' => 'N']);
            }
        }

        return "execute();";
    }
}
