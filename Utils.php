<?php
namespace WordPigeon;

class Utils
{
    // https://stackoverflow.com/questions/3349753/delete-directory-with-files-in-it
    public static function deleteDir(string $dirPath) {
        if (! is_dir($dirPath)) {
            throw new InvalidArgumentException("$dirPath must be a directory");
        }
        if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
            $dirPath .= '/';
        }
        $files = glob($dirPath . '*', GLOB_MARK);
        foreach ($files as $file) {
            if (is_dir($file)) {
                self::deleteDir($file);
            } else {
                unlink($file);
            }
        }
        rmdir($dirPath);
    }

    public static function validatePem(string $pem) : string 
    {   
        if (!Utils::contains($pem, "-----BEGIN PUBLIC KEY-----")) 
        {
            return 'key should start with -----BEGIN PUBLIC KEY-----';
        }

        if (!Utils::contains($pem, "-----END PUBLIC KEY-----")) 
        {
            return 'key should end with -----END PUBLIC KEY-----';
        }

        $validPublicKey = openssl_get_publickey($pem);

        if($validPublicKey === false) 
        {
            return 'not a valid public key';
        }

        return '';
    }

    //https://www.geeksforgeeks.org/php-startswith-and-endswith-functions/
    public static function statsWith(string $string, string $startString) 
    {
        $len = strlen($startString); 
        return (substr($string, 0, $len) === $startString);
    }

    public static function contains(string $string, string $findMe) : bool
    {
        $pos = strpos($string, $findMe);

        if ($pos !== false) 
        {
            return true;
        }
        return false;
    }

    public static function checkForErrorsAndRethrow() 
    {
        $output = ob_get_contents();

        if ($output != "") 
        {
            throw new \Exception($output);
        }
    }

    public static function safelyGetIndex($array, $index)
    {
        if (isset($array[$index])) 
        {
            $result = $array[$index];
            return $result;
        }

        return null;
    }

    public static function extractZip($zipFilePath, $extractionPath)
    {
        $messages = array("exception" => null);

        try 
        {
            $zip = new \PhpZip\ZipFile();
            $zip->openFile($zipFilePath)
                ->extractTo($extractionPath);        
        }
        catch(\Exception $ex) 
        {
            $messages["exception"] = $ex->getMessage();
        }

        return $messages;
    }

    public static function getHtmlFileName($extractionPath)
    {
        $files = scandir($extractionPath);
        $filesContainingHtml = array_filter($files, function($file) { return Utils::contains($file, "html"); });
        $file = array_pop($filesContainingHtml);
        return $file;
    }

}