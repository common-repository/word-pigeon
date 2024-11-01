<?php
namespace WordPigeon\Services;

use WordPigeon\Utils;

class ImageService
{
    public static function insertFeaturedImage(\WP_REST_Request  $request)
    {        
        if (!function_exists('media_handle_sideload')) 
        {
            include_once ABSPATH . "wp-admin/includes/media.php";
            include_once ABSPATH . "wp-admin/includes/file.php";
            include_once ABSPATH . "wp-admin/includes/image.php";
        }

        $files = $request->get_file_params();

        $file = array_pop($files);

        $bodyParams = $request->get_body_params();
        $postId = json_decode(Utils::safelyGetIndex($bodyParams, 'PostId'));
        $imageInsert = ImageService::insertImage($file, $postId);
    
        if (isset($imageInsert['attachId'])) 
        {
            set_post_thumbnail( $postId, $imageInsert['attachId']);
        }
        
        return $imageInsert;
    }

    public static function setFeaturedImage(\WP_REST_Request  $request)
    {        
        $params = $request->get_json_params();
        set_post_thumbnail( $params["PostId"], $params["AttachId"]);

        return true;
    }

    public static function insertImages(\WP_REST_Request  $request) 
    {
        $result = array();

        if (!function_exists('media_handle_sideload')) 
        {
            include_once ABSPATH . "wp-admin/includes/media.php";
            include_once ABSPATH . "wp-admin/includes/file.php";
            include_once ABSPATH . "wp-admin/includes/image.php";
        }

        $files = $request->get_file_params();
        
        foreach($files as $fileInfo)
        {        
            $imageInsert = ImageService::insertImage($fileInfo, 0);
            array_push($result, $imageInsert);
        }

        return $result;        
    }

    public static function insertImage($fileInfo, $postId)
    {
        $imageInsert = array();

        $insertResult = media_handle_sideload($fileInfo, $postId);

        if ( is_int($insertResult) )
        {
            $attachId = $insertResult;
            $absoluteUrl = wp_get_attachment_url($attachId);
            $relativeUrl = str_replace(\get_site_url(), '', $absoluteUrl); // get relative link    
            $imageInsert['attachId'] = $attachId;
            $imageInsert['absoluteUrl'] = $absoluteUrl;
            $imageInsert['relativeUrl'] = $relativeUrl;           
        }
        else 
        {
            $imageInsert['error'] = join(", ",$insertResult->get_error_messages());
        }

        $imageInsert['intendedFileName'] = $fileInfo["name"];

        return $imageInsert;
    }
    
}