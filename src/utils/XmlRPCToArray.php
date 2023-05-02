<?php 

function convert_xmlrpcval_to_array($xmlrpcval) {
    $php_val = null;

    switch ($xmlrpcval->kindOf()) {
        case 'scalar': // handle scalar values
            $php_val = $xmlrpcval->scalarval();
            break;
        case 'array': // handle arrays
            $php_val = array();
            foreach ($xmlrpcval->scalarval() as $item) {
                $php_val[] = convert_xmlrpcval_to_array($item);
            }
            break;
        case 'struct': // handle structs
            $php_val = array();
            $struct_vals = $xmlrpcval->scalarval();
            foreach ($struct_vals as $key => $item) {
                $php_val[$key] = convert_xmlrpcval_to_array($item);
            }
            break;
        default: // handle other value types (e.g. base64, datetime, etc.)
            $php_val = $xmlrpcval->serialize();
            break;
    }

    return $php_val;
}