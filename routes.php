<?php

use Bitrix\Main\Routing\RoutingConfigurator;
use Practice\Element\Controllers\PracticeController;

return static function (RoutingConfigurator $configurator) {
    $configurator->get('/practice/get', [PracticeController::class, 'getPracticeAction']);
    $configurator->post('/practice/create', [PracticeController::class, 'createPracticeAction']);
    $configurator->patch('/practice/update', [PracticeController::class, 'updatePractice']);
    $configurator->delete('/practice/delete/{id}', [PracticeController::class, 'deletePractice']);
    $configurator->get('/api-doc', [\BitrixOA\BitrixUiController::class, 'apidocAction']);
};
