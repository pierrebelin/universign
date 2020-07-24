<?php

namespace PierreBelin\Universign;

use PierreBelin\Universign\Request\TransactionRequest;
use PierreBelin\Universign\Response\TransactionResponse;

require_once dirname(__DIR__) . '/lib/xmlrpc/xmlrpc.inc';
require_once dirname(__DIR__) . '/lib/xmlrpc/xmlrpcs.inc';
require_once dirname(__DIR__) . '/lib/xmlrpc/xmlrpc_wrappers.inc';

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
     * Send documents + signers to Universign and return the URL + the ID of the document
     * 
     * @param   \PierreBelin\Universign\Request\TransactionRequest $transactionRequest
     * @return  \PierreBelin\Universign\Response\TransactionResponse
     */
    public function requestTransaction(TransactionRequest $transactionRequest)
    {
        $client = $this->getClient();
        $request = new \xmlrpcmsg('requester.requestTransaction', [$transactionRequest->buildRpcValues()]);
        $response = &$client->send($request);

        // var_dump($transactionRequest->buildRpcValues()); die;

        if (!$response->faultCode()) {
            return new TransactionResponse($response);
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
        $client = new \xmlrpc_client($this->getURLRequest());
        $client->setSSLVerifyHost(1);
        $client->setSSLVerifyPeer(1);
        $client->setDebug(0);
        return $client;
    }
}
