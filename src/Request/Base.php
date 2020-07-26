<?php

namespace PierreBelin\Universign\Request;

use UnexpectedValueException;

require_once dirname(__DIR__) . '/../lib/xmlrpc/xmlrpc.inc';
require_once dirname(__DIR__) . '/../lib/xmlrpc/xmlrpcs.inc';
require_once dirname(__DIR__) . '/../lib/xmlrpc/xmlrpc_wrappers.inc';


abstract class Base 
{
    protected $attributes = [];
    protected $attributesTypes = [];

    public function getAttributes()
    {
        return array_filter($this->attributes);
    }

    public function buildRpcValues()
    {
        $build = [];
        foreach ($this->attributes as $key => $value) {
            $build[$key] = $this->buildRpcValue($value, $this->attributesTypes[$key]);
        }
        return new \xmlrpcval($build, 'struct');
    }

    protected function buildRpcValue($value, $type = null)
    {
        if (!$type) {
            $type = gettype($value);
        }
        switch ($type) {
            case 'string':
                return new \xmlrpcval($value, 'string');
            case 'base64':
                return new \xmlrpcval($value, 'base64');
            case 'array':
                $data = [];
                foreach ($value as $v) {
                    $data[] = $this->buildRpcValue($v);
                }
                return new \xmlrpcval($data, 'array');
            case 'double':
            case 'float':
                return new \xmlrpcval($value, 'double');
            case 'boolean':
            case 'bool':
                return new \xmlrpcval($value, 'boolean');
            case 'integer':
            case 'int':
                return new \xmlrpcval($value, 'int');
            default:
                if ($value instanceof self) {
                    return $value->buildRpcValues();
                }
                if ($value instanceof \Datetime) {
                    return new \xmlrpcval($value, 'dateTime');
                }
                return new \xmlrpcval($value);
        }
    }

    public function __call($method, $parameters)
    {
        if (preg_match('/^set(.+)$/', $method)) {
            $name = lcfirst(substr($method, 3));
            $this->{$name} = $parameters[0];
            return $this;
        }
    }

    public function __set($name, $value)
    {
        if (!isset($this->attributesTypes[$name])) {
            throw new UnexpectedValueException("Undefined property: $name");
        }

        switch ($this->attributesTypes[$name]) {
            case 'base64':
            case 'string':
                if (!is_string($value)) {
                    throw new UnexpectedValueException("$name must be of the type string, " . gettype($value) . " given");
                }
                break;
            case 'array':
                // @TODO array[type] ??? or closure ?
                if (!is_array($value)) {
                    throw new UnexpectedValueException("$name must be of the type array, " . gettype($value) . " given");
                }
                break;
            case 'float':
                if (!is_float($value)) {
                    throw new UnexpectedValueException("$name must be of the type float, " . gettype($value) . " given");
                }
                break;
            case 'bool':
                if (!is_bool($value)) {
                    throw new UnexpectedValueException("$name must be of the type boolean, " . gettype($value) . " given");
                }
                break;
            case 'int':
                if (!is_integer($value)) {
                    throw new UnexpectedValueException("$name must be of the type integer, " . gettype($value) . " given");
                }
                break;
            default:
                if (!($value instanceof $this->attributesTypes[$name])) {
                    throw new UnexpectedValueException("$name must be of the type " . $this->attributesTypes[$name] . ", " . get_class($value) . " given");
                }
                break;
        }
        $this->attributes[$name] = $value;
    }
}