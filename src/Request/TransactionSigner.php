<?php

namespace PierreBelin\Universign\Request;
// require_once dirname(__DIR__) . '/Base.php';

class TransactionSigner extends Base
{
    protected $attributesTypes = [
        'firstname' => 'string',
        'lastname' => 'string',
        'organization' => 'string',
        'emailAddress' => 'string',
        'phoneNum' => 'string',
        'birthDate' => 'DateTime',
        'successURL' => 'string',
        'cancelURL' => 'string',
        'failURL' => 'string',
        'signatureFields' => 'array',
    ];

    public function addSignatureField(SignatureField $signatureField)
    {
        $this->attributes['signatureFields'][] = $signatureField;
        return $this;
    }
}
