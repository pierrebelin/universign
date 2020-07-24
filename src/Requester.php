<?php

namespace PierreBelin\Universign;

use PierreBelin\Universign\Request\TransactionRequest;

require_once dirname(__DIR__) . '../../lib/xmlrpc/xmlrpc.inc';
require_once dirname(__DIR__) . '../../lib/xmlrpc/xmlrpcs.inc';
require_once dirname(__DIR__) . '../../lib/xmlrpc/xmlrpc_wrappers.inc';

class Requester
{
    private $userMail;
    private $userPassword;
    private $isTest;

    function __construct($userMail, $userPassword,$isTest)
    {
        $this->userMail = $userMail;
        $this->userPassword = $userPassword;
        $this->isTest = $isTest;
    }

    /**
     * Requests a new transaction for the client signature service.
     *
     * Sends the document to be signed and other parameters and returns an URL where the end
     * user should be redirected to. A transaction must be completed whithin 14
     * days after its request.
     *
     * @param   \Globalis\Universign\Request\TransactionRequest  $request
     * @return  \Globalis\Universign\Response\TransactionResponse
     */
    public function requestTransaction(TransactionRequest $transactionRequest)
    {
        $client = $this->getClient();
        $request = new xmlrpcmsg('requester.requestTransaction', [$transactionRequest->buildRpcValues()]);
        $response = &$client->send($request);

        // var_dump($transactionRequest->buildRpcValues()); die;

        if (!$response->faultCode()) {
            //request successul: store the ID in the session and redirects to the URL
            $urlResponse = $response->value()->structMem('url')->scalarVal();
            $idResponse = $response->value()->structMem('id')->scalarVal();
            var_dump($urlResponse, $idResponse);
            die;
        } 
        //error
        print 'An error occurred: ';
        print 'Code: ' . $response->faultCode(). " Reason: '" . $response->faultString();
    }

    private function getURLRequest() 
    {
        if($this->isTest) {
            return 'https://' . $this->userMail . ':'. $this->userPassword  . '@ws.test.universign.eu/sign/rpc/';
        }
        return 'https://' . $this->userMail . ':'. $this->userPassword  . '@ws.universign.eu/sign/rpc/';
    }
    
    private function getClient() {
        $client = new xmlrpc_client($this->getURLRequest());
        $client->setSSLVerifyHost(1);
        $client->setSSLVerifyPeer(1);
        $client->setDebug(0);
        return $client;
    }
}
