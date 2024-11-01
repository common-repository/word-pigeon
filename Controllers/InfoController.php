<?php
namespace WordPigeon\Controllers;

use WordPigeon\Utils;
use WordPigeon\Services\TokenService;

class InfoController
{
  function get_info(\WP_REST_Request $request) 
  {
    $key = get_option("word_pigeon_public_key");  

    $validationMsg = Utils::validatePem($key);

    $keyValid = $validationMsg === '';
    
    $result = array(
      "hasPublicKey" => $keyValid,
      "wordPigeonVersion" => WORD_PIGEON_VERSION,
      "key" => $key,
      "serverTime" => new \DateTime()
    );

    return $result;
  }

  function get_export_options(\WP_REST_Request $request) 
  {
    $result =  array();    
 
    $headers = $request->get_headers();

    $tokenString = $headers["word_pigeon_token"][0];
    $tokenGood = TokenService::checkToken($tokenString);

    if (!$tokenGood) 
    {
      $result["tokenValid"] = false;
        return $result;
    }
    else
    {

      $rawAuthors = get_users();
      $rawCategories = get_categories(array('hide_empty' => false));
      $rawTags = get_tags(array('hide_empty' => false));

      $preparedAuthors = array_map(function($author) {
        $result = array();
        $result["Id"] = $author->id;
        $result["DisplayName"] = $author->display_name;
        $result["Email"] = $author->user_email;

        return $result;

      }, $rawAuthors);

      $preparedCategories = array_map(function($category) {
        $result = array();
        $result["Id"] = $category->cat_ID;
        $result["Name"] = $category->name;
        $result["Slug"] = $category->slug;

        return $result;

      }, $rawCategories);

      $preparedTags = array_map(function($term){
        return $term->name;
      }, $rawTags);

      // https://developer.wordpress.org/reference/functions/get_post_types/
      // $posts = get_post_types();

      $result["tokenValid"] = true;
      $result["authors"] = $preparedAuthors; // https://developer.wordpress.org/reference/functions/get_users/      
      $result["categories"] = $preparedCategories; // https://developer.wordpress.org/reference/functions/get_categories/
      $result["tags"] = $preparedTags;
      $result["pluginVersion"] = WORD_PIGEON_VERSION;
    }
 
    return $result;

  }
}

