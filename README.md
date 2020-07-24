# Universign Service

## How to use

### Create signers

```php
<?php
$signer = new TransactionSigner();
$signer
    ->setFirstname('Pierre')
    ->setLastname('Belin')
    ->setEmailAddress('contact@pierrebelin.fr')
    ->setPhoneNum('0606060606')
    ->setSuccessURL('https://www.universign.eu/fr/sign/success/')
    ->setCancelURL('https://www.universign.eu/fr/sign/cancel/')
    ->setFailURL('https://www.universign.eu/fr/sign/failed/')
    ->addSignatureField($signatureField1)
    ->addSignatureField($signatureField2);
```
