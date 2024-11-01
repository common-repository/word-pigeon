<?php
namespace WordPigeon\Controllers;

use WordPigeon\Services\TokenService;

class TokenController
{
    public function token_test($request)
    {

      $returnData = array();
      try
      {
        $headers = $request->get_headers();
        $tokenString = $headers["word_pigeon_token"][0];

        $publicKeyString = "-----BEGIN PUBLIC KEY-----\n" .
            "MIIBIjANBgkqhkiG9w0BAQEFAAOCAQ8AMIIBCgKCAQEAkZm+b7zqUybWj2SDMzeW\n" .
            "7jqjeOJoX3PIYxBimfu5049eNgqbREqfDPTs7HZuwu2qH4DV9Ihtl8XXQq2OT6/j\n" .
            "vW5rSVQYiNYTq/u6xKdrK5e7CxLFSrG4265ochiXdMI7FBwClVBJwdrFogoWkuto\n" .
            "dlbQkJS3r6wdZRbREBj3O+qMzadXQDiWZP+I1zz6Q4eAsSuZ1fwXh40zqpXiLsOr\n" .
            "bTURtqAjuAHB7tjhzpHyCLCwxX9uP2bz31B6jjVw7XMPr28qSnlQU/HyCT8zvYUu\n" .
            "Dffj1oH/rJ8Qk1lrj4Oz4V0hmaquGWTC168aahm1O9VCP+bE46VpiQzjKbksiEhp\n" .
            "vwIDAQAB\n" .
            "-----END PUBLIC KEY-----";

        $returnData = TokenService::getValidAndVerifiedStatus($tokenString, $publicKeyString);
      
        $token = $returnData["token"];

        $exp = $token->getClaim('exp', false);

        $now = new \DateTime();

        $expiresAt = new \DateTime();
        $expiresAt->setTimestamp($exp);

        $returnData['tokenExpiresAt'] = $expiresAt;
        $returnData['serverTime'] = $now;
        $returnData['tokenString'] = $tokenString;
        $returnData['hasExpired'] = $now > $expiresAt;
        $returnData['timeUntilExpiry'] = $expiresAt - $now ;
      }
      catch(\Exception $ex)
      {
        $returnData['exception'] = $ex->getMessage();
      }

      return $returnData;
       
    }
}

// https://github.com/lcobucci/jwt/blob/3.3/README.md
// https://github.com/lcobucci/jwt/blob/3.3/src/Signer/Key.php
// https://www.php.net/manual/en/function.openssl-pkey-get-public.php
