<?php

namespace PierreBelin\Universign\Response;

use Datetime;
use DateTimeZone;
use stdClass;
use UnexpectedValueException;

require_once dirname(__DIR__) . '/../lib/xmlrpc/xmlrpc.inc';
require_once dirname(__DIR__) . '/../lib/xmlrpc/xmlrpcs.inc';
require_once dirname(__DIR__) . '/../lib/xmlrpc/xmlrpc_wrappers.inc';

abstract class Base
{
    protected $attributesTypes = [];

    protected $attributes = [];

    public function __construct(\xmlrpcval $values)
    {
        foreach ($this->attributesTypes as $key => $value) {
            $this->attributes = $this->parseValue($values, null);
        }
    }

    protected function parseValue(\xmlrpcval $values, $key = null)
    {
        if (isset($key)) {
            if (!$values[$key]) {
                return null;
            }
            $values = $values[$key];

            if (is_callable([$this, $this->attributesTypes[$key]])) {
                return $this->{$this->attributesTypes[$key]}($values);
            }
        }
        switch ($values->scalartyp()) {
            case 'dateTime.iso8601':
                return Datetime::createFromFormat('Ymd\TH:i:s', $values->scalarval(), new DateTimeZone('UTC'));
            case 'array':
                $data = [];
                foreach ($values->scalarval() as $val) {
                    $data = $this->parseValue($val);
                }
                return $data;
            case 'struct':
                $data = new stdClass();
                foreach ($values->scalarval() as $key => $val) {
                    $data->$key = $this->parseValue($val);
                }
                return $data;
            default:
                return $values->scalarval();
                break;
        }
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function __call($method, $parameters)
    {

        if (preg_match('/^get(.+)$/', $method)) {
            $name = lcfirst(substr($method, 3));
            return $this->attributes->{$name}; 
        }
    }

    public function __get($key)
    {
        if (!isset($this->attributesTypes[$key])) {
            throw new UnexpectedValueException("Undefined property: $key");
        }

        return $this->attributes[$key];
    }
}
