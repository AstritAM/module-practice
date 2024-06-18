<?php

namespace Practice\Element\Controllers;

use Bitrix\Main\Engine\Controller;
use Bitrix\Main\Engine\Response\AjaxJson;
use Bitrix\Main\Engine\Response\Json;
use Bitrix\Main\Error;
use Bitrix\Main\HttpResponse;
use Bitrix\Main\Response;
use JsonException;

class BaseController extends Controller
{
    protected array $phrases = [
    200 => 'OK',
    401 => 'Unauthorized',
    400 => 'Bad Request',
    403 => 'Forbidden',
    404 => 'Not Found',
];

    /**
     * @param Response $response
     *
     * @return void
     */
    public function finalizeResponse(Response $response): void
{
    $errorsCode = ['invalid_csrf', 'invalid_credential'];

    if ($response instanceof AjaxJson) {
        $error = $response->getErrors()[0] ?? null;
        if ($error instanceof Error && in_array($error->getCode(), $errorsCode, true)) {
            $content = ['error' => $error->getMessage()];

            if (env('APP_ENV', 'prod') !== 'prod' && $error->getCode() === 'invalid_csrf') {
                // добавить csrf токен в ошибку ответа на dev площадках
                $content['X-Bitrix-Csrf-Token'] = bitrix_sessid();
            }

            $resp = new Json($content);
            $resp->setStatus('403 Forbidden');
            $resp->writeHeaders();
            $resp->send();
        }
    }
}

    /**
     * Установка кода ответа и сообщения
     *
     * @param int         $code
     * @param array       $body
     * @param string|null $error
     *
     * @return Json
     */
    protected function sendResponse(int $code, array $body = [], string $error = null): Json
{
    $response = new HttpResponse();
    $response->setStatus("$code {$this->phrases[$code]}");
    $response->writeHeaders();

    if ($error) {
        $body['error'] = $error;
    }

    return new Json($body);
}

    /**
     * @noinspection PhpMultipleClassDeclarationsInspection
     * @return array
     */
    protected function getRequestValues(): array
{
    $values = $this->getRequest()->getValues();
    $input  = $this->getRequest()::getInput();

    if ($input) {
        try {
            $fromJsonValues = json_decode($input, true, 512, JSON_THROW_ON_ERROR);
        } catch (JsonException $e) {
           echo  "Передана не json строка: {$e->getMessage()}";
        }
    }

    return array_merge($values, $fromJsonValues ?? []);
}

}
