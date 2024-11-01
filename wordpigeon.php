<?php 
/**
* Plugin Name: Word Pigeon
* Plugin URI: https://wordpigeon.com
* Description: Imports your google documents into WordPress - retaining the formatting and images
* Version: 2.22.1
* Author: WordPigeon
**/

require 'vendor/autoload.php';

use WordPigeon\Controllers\InfoController;
use WordPigeon\Controllers\PostControllerV2;
use WordPigeon\Controllers\TokenController;
use WordPigeon\Services\ActivationService;
use WordPigeon\WordPigeonOptions;

define('WORD_PIGEON_VERSION', "2.22.1");

// ROUTES
add_action( 'rest_api_init', function () {
  register_rest_route( "wordpigeon/v1", '/info', array(
    'methods' => 'GET',
    'callback' => array(new InfoController, 'get_info')
  ) );

  register_rest_route( "wordpigeon/v1", '/info/export', array(
    'methods' => 'GET',
    'callback' => array(new InfoController, 'get_export_options')
  ) );
  
  register_rest_route( "wordpigeon/v1", '/token', array(
    'methods' => 'POST',
    'callback' => array(new TokenController, 'token_test')
  ) );

  register_rest_route( "wordpigeon/v2", '/images', array(
    'methods' => 'POST',
    'callback' => array(new PostControllerV2, 'word_pigeon_insert_images')
  ) );

  register_rest_route( "wordpigeon/v2", '/images/featured', array(
    'methods' => 'POST',
    'callback' => array(new PostControllerV2, 'word_pigeon_insert_featured_image')
  ) );

  register_rest_route( "wordpigeon/v2", '/images/featured/set', array(
    'methods' => 'POST',
    'callback' => array(new PostControllerV2, 'word_pigeon_set_featured_image')
  ) );

  register_rest_route( "wordpigeon/v2", '/posts', array(
    'methods' => 'POST',
    'callback' => array(new PostControllerV2, 'word_pigeon_insert_post')
  ) );

} );

// OPTIONS
add_action( 'admin_menu', array( new WordPigeonOptions, 'word_pigeon_register_options') );

// ACTIVATION
register_activation_hook (__FILE__, function() { ActivationService::activate();} );
register_activation_hook (__FILE__, function() { ActivationService::deactivate();} );