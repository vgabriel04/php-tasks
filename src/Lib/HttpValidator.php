<?php

namespace PhpTask\Lib;

use PhpTask\Lib\JsonResponse;
use PhpTask\Lib\DbConnection;
use PDO;

class HttpValidator
{

    private $data;
    private $isObject;
    private $rule;

    protected function __construct()
    {
        $this->rule = [];
    }

    public static function create(): self
    {
        return new self();
    }

    public function forData($data, $isObject)
    {
        $this->data = $data;
        $this->isObject = $isObject;
        return $this;
    }

    public function exists($propertyName)
    {
        $this->rule['propertyName'] = $propertyName;
        $this->rule['rule'] = 'exists';
        return $this;
    }

    public function notNull($propertyName)
    {
        $this->rule['propertyName'] = $propertyName;
        $this->rule['rule'] = 'notNull';
        return $this;
    }

    public function withMessage($message)
    {
        $this->rule['message'] = $message;
        return $this;
    }

    public function validate()
    {
        $rule = $this->rule['rule'];
        $data = $this->data;
        $propertyName = $this->rule['propertyName'];
        $isObject = $this->isObject;

        switch ($rule) {
            case 'exists':
                if ($isObject !== true) {
                    if (!isset($data[$propertyName])) $this->throwError();
                } else {
                    if (property_exists($data, $propertyName) == FALSE) $this->throwError();
                }
                break;
            case 'notNull':
                if ($isObject !== true) {
                    if ($data[$propertyName] == null) $this->throwError();
                } else {
                    if ($data->$propertyName == null) $this->throwError();
                }
                break;
            default:
                $this->throwInvalidRule();
                break;
        }
        $this->emptyValidatorData();
    }

    private function throwInvalidRule()
    {
        throw new \Exception("Invalid Rule", 1);
    }

    private function throwError()
    {
        $message = $this->rule['message'];
        $this->emptyValidatorData();
        throw new \Exception($message);
    }

    private function emptyValidatorData()
    {
        $this->rule = [];
    }
}
