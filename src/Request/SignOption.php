<?php

namespace PierreBelin\Universign\Request;

abstract class SignatureFormat {
    const SIGNATURE_FORMAT_PADES = 'PADES';
    const SIGNATURE_FORMAT_PADES_COMP = 'PADES-COMP';
    const SIGNATURE_FORMAT_ISO320001 = 'ISO-32000-1';
}

class SignOption extends Base
{
    protected $attributesTypes = [
        'profile' => 'string',
        'signatureField' => 'PierreBelin\Universign\Request\SignatureField',
        'reason' => 'string',
        'location' => 'string',
        'signatureFormat' => 'string', // Use TransactionRequestLanguage
        'language' => 'string',
        'patternName' => 'string',
    ];
}