<?php
namespace WordPigeon\Controllers;

use WordPigeon\Services\ImageService;
use WordPigeon\Services\TokenService;
use WordPigeon\Services\PostService;



class PostControllerV2
{
    public function word_pigeon_insert_images(\WP_REST_Request $request)
    {        
        $result = $this->checkToken($request);
        if (count($result['errors']) > 0) return $result;
        
        $result['data'] = ImageService::insertImages($request);
        return $result;
    }

    public function word_pigeon_insert_post(\WP_REST_Request $request)
    {
        $result = $this->checkToken($request);
        if (count($result['errors']) > 0) return $result;

        $result['data'] = PostService::insertPost($request);
        return $result;
    }

    public function word_pigeon_insert_featured_image(\WP_REST_Request $request)
    {
        $result = $this->checkToken($request);
        if (count($result['errors']) > 0) return $result;

        $result['data'] = ImageService::insertFeaturedImage($request);
        return $result;
    }

    public function word_pigeon_set_featured_image(\WP_REST_Request $request)
    {
        $result = $this->checkToken($request);
        if (count($result['errors']) > 0) return $result;

        $result['data'] = ImageService::setFeaturedImage($request);
        return $result;
    }

    private function checkToken(\WP_REST_Request $request)
    {
        $result = array('errors' => array(), 'data' => array(), 'info' => array());

        $headers = $request->get_headers();
        $tokenString = $headers["word_pigeon_token"][0];
        $tokenGood = TokenService::checkToken($tokenString);
        
        if (!$tokenGood) 
        {
            $result['errors'][] = 'token invalid';            
        }
        else
        {
            $result['info'][] = 'token valid';
        }

        return $result;
    }
       
}
