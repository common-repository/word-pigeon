<?php
namespace WordPigeon\Services;

use \WordPigeon\Utils;

class PostService
{
    public static function insertPost(\WP_REST_Request  $request) 
    {     
        $result = array(
            "postId" => 0,
            "postUrl" => "",  
        );

        $params = $request->get_json_params();
        
        $wpPost = PostService::jsonBodyToWpPost($params);

        // This updates the post if the ID is set
        $result["postId"] = wp_insert_post($wpPost, false);
        $post = get_post($result["postId"]);
        $result["excerpt"] = $post->post_excerpt;
        $result["slug"] = $post->post_name;
        $result["postUrl"] = get_permalink($result["postId"], false);

        return $result;        
    }

    public static function jsonBodyToWpPost($payload)
    {
        $categories =  Utils::safelyGetIndex($payload, 'CategoryIds');
        $author = Utils::safelyGetIndex($payload, 'AuthorId');
        $tags = Utils::safelyGetIndex($payload, 'Tags');
        $postId = Utils::safelyGetIndex($payload, 'PostId');
        $updateOriginal = Utils::safelyGetIndex($payload, 'UpdateOriginal');
        $content = Utils::safelyGetIndex($payload, 'Html');
        $postName = Utils::safelyGetIndex($payload, 'Slug');
        $excerpt = Utils::safelyGetIndex($payload, 'Excerpt');
        $publishDate = Utils::safelyGetIndex($payload, 'PublishDate');

        // https://developer.wordpress.org/reference/functions/wp_insert_post/
        $result = array(
            'post_title' => $payload['PostTitle'],
            'post_content' => $content,
            'post_status' => $payload['Status'],
            'post_author' => 1,
            'post_type' => $payload['ExportAs'],
            'guid' => wp_generate_uuid4(),
            'post_category' => $categories,
            'post_author' => $author,
            'tags_input' => $tags,
            'post_name' => $postName,
            'post_excerpt' => $excerpt,
            'post_date' => $publishDate
        );

        if ($updateOriginal === true) 
        {
            $result["ID"] = $postId;
        }

        return $result;
    }


    public static function payloadToWpPost($payload)
    {
        $categories =  json_decode(Utils::safelyGetIndex($payload, 'CategoryIds'));
        $author = json_decode(Utils::safelyGetIndex($payload, 'AuthorId'));
        $tags = json_decode(Utils::safelyGetIndex($payload, 'Tags'));
        $postId = json_decode(Utils::safelyGetIndex($payload, 'PostId'));
        $updateOriginal = Utils::safelyGetIndex($payload, 'UpdateOriginal');
        $content = Utils::safelyGetIndex($payload, 'Html');

        // https://developer.wordpress.org/reference/functions/wp_insert_post/
        $result = array(
            'post_title' => $payload['PostTitle'],
            'post_content' => $content,
            'post_status' => $payload['Status'],
            'post_author' => 1,
            'post_type' => $payload['ExportAs'],
            'guid' => wp_generate_uuid4(),
            'post_category' => $categories,
            'post_author' => $author,
            'tags_input' => $tags
        );

        if ($updateOriginal === "True") {
            $result["ID"] = $postId;
        }

        return $result;
    }
    
}