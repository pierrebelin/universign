<?php

namespace PierreBelin\Universign\Request;

class SEPAData extends Base
{
    protected $attributesTypes = [
        'rum' => 'string',
        'ics' => 'string',
        'iban' => 'string',
        'bic' => 'string',
        'recurring' => 'bool',
        'debtor' => 'PierreBelin\Universign\Request\SEPAThirdParty',
        'creditor' => 'PierreBelin\Universign\Request\SEPAThirdParty',
    ];
}