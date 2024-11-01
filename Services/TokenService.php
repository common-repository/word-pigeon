<?php
namespace WordPigeon\Services;

use Lcobucci\JWT\Signer\Key;
use Lcobucci\JWT\Signer\Rsa\Sha256;
use Lcobucci\JWT\Parser;
use Lcobucci\JWT\ValidationData;
use WordPigeon\Utils;

class TokenService
{
    public static function checkToken(string $tokenString) : bool
    {   
        $validAndVerified = false;
        $result = TokenService::getValidAndVerifiedStatus($tokenString);

        if ($result["signatureVerified"] && $result["claimsValid"]) {
            $validAndVerified = true;
        } else {
            $validAndVerified = false;
        }        

        return $validAndVerified;
    }

    public static function getValidAndVerifiedStatus(string $tokenString, string $publicKeyOverride = null) : array 
    {        
        try 
        {
            if (isset($publicKeyOverride)) {
                $publicKeyString = $publicKeyOverride; // FOR DEBUGGING
            } else {
                $publicKeyString = get_option("word_pigeon_public_key");
            }

            $signer = new Sha256();  
    
            $validationData = new ValidationData(null, 600);             
            $validationData->setIssuer("WordPigeon"); 
            $publicKey = new Key($publicKeyString); 
            $token = (new Parser())->parse((string) $tokenString); // Parses from a string

            $jti = $token->getClaim('jti');

            $jtiValid = TokenService::validateJti($jti);

            $tokenSpent = TokenService::spendToken($jti);
                
            // verify the token hasnt been tampered with by checking the signature against the payload and header
            $isVerified = $token->verify($signer, $publicKey);
    
            // validate token by checking its not too old
            $isValid = $token->validate($validationData) && $jtiValid && $tokenSpent;            
        }
        catch(Exception $e)
        {
            // TODO if debug 
        }

        $returnData = array(
            "signatureVerified" => $isVerified,
            "claimsValid" => $isValid ,
            "token"  => $token
        );

        return $returnData;
    }

    public static function validateJti(string $jti) : bool
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'word_pigeon_token_log';
    
        $entires = $wpdb->get_var(
            $wpdb->prepare(
                " SELECT count(*) FROM $table_name WHERE Id = %s ",
                $jti
            )
        );

        Utils::checkForErrorsAndRethrow();

        $result = $entires === "0";
        return $result;    
    }

    public static function spendToken(string $jti) : bool
    {
        $result = false;
        try 
        {
            global $wpdb;
            $table_name = $wpdb->prefix . 'word_pigeon_token_log';
        
            $result = $wpdb->insert(
                $table_name,
                array(
                    'Id' => $jti
                )			
            ) === 1;
        } 
        catch (\Exception $ex) {
            $result = false;
        }
        return $result;    
    }


}