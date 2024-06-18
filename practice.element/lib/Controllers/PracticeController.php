<?php

namespace Practice\Element\Controllers;

use Bitrix\Main\Engine\Response\Json;
use Bitrix\Main\SystemException;
use Practice\Element\DTO\PracticeData;
use Practice\Element\Services\PracticeHandler;

class PracticeController extends BaseController
{
    protected function getDefaultPreFilters()
    {
        return [];
    }
    /**
     * @OA\Get(
     *     tags={"Смена паспортных данных"},
     *     path="/practice/get",
     *     summary="Get Practice Record",
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function getPracticeAction()
    {
        $practices = new PracticeHandler();
        $result = $practices->getPractices();
        return $this->sendResponse(200, ['data' => $result]);
    }

    /**
     * @OA\Post(
     *     path="/practice/create",
     *     summary="Create Practice Record",
     *     title="Practice",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string")
     *         )
     *     ),
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function createPracticeAction()
    {
        $values = $this->getRequestValues();

        $data = new PracticeData();
        $data->setName($values['NAME']);
        $data->setCode($values['CODE']);
        $data->setIblockSectionId($values['IBLOCK_SECTION_ID']);
        $data->setPreviewText($values['PREVIEW_TEXT']);
        $data->setIblockId($values['IBLOCK_ID']);


        try {
            $practices = new PracticeHandler();
            $practices->create($data);
        } catch (SystemException $e) {
            $result = [
                'success' => false,
                'error'   => $e->getMessage(),
            ];
        }

        return $this->sendResponse(200, $result ?? ['success' => true]);
    }

    public function updatePractice()
    {
    }

    /**
     * @OA\Delete(
     *     path="/api/practice/delete/{id}",
     *     summary="Delete Practice Record",
     *     title="Practice",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(response="200", description="Success")
     * )
     */
    public function deletePractice()
    {
        $values = $this->getRequestValues();

        if (!isset($values['id'])) {
            return $this->sendResponse(400);
        }

        $practices = new PracticeHandler();
        $result = $practices->delete($values['id']);
        if (!$result) {
            return $this->sendResponse(404);
        }

        return $this->sendResponse(200, ['success' => true]);
    }
}
