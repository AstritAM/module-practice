<?php

namespace Practice\Element\Services;

use Bitrix\Main\Loader;
use http\Exception\RuntimeException;
use Practice\Element\DTO\PracticeData;
use Bitrix\Iblock\Elements\ElementPracticeTable;

class PracticeHandler
{
    public function __construct()
    {
        if (!Loader::includeModule('iblock')) {
            throw new RuntimeException('Ошибка подключения модуля iBlock');
        }
    }
    public function getPractices()
    {
        $data = ElementPracticeTable::query()
            ->addSelect('ID')
            ->addSelect('CODE')
            ->addSelect('IBLOCK_SECTION_ID')
            ->addSelect('NAME')
            ->addSelect('PREVIEW_TEXT')
            ->addSelect('PREVIEW_PICTURE')
            ->setFilter(['%NAME' => 'Скилл'])
            ->setOrder(['SORT' => 'ASC'])
            ->countTotal(true)
            ->fetchAll();


        if ($data) {
            return $data;
        }
    }

    public function create(PracticeData $data): void
    {
        $data = ElementPracticeTable::createObject()
            ->setName($data->getName())
            ->setCode($data->getCode())
            ->setIblockSectionId($data->getIblockSectionId())
            ->setPreviewText($data->getPreviewText())
            ->setIblockId($data->getIblockId());

        $data->save();
    }

    public function update()
    {
    }

    public function delete(int $id)
    {
        $data = ElementPracticeTable::query()
            ->addSelect('ID', $id)
            ->fetchObject();

        if ($data) {
            $result = $data->delete();
        }

        if ($result->isSuccess()) {
            return true;
        }
        return false;
    }
}
