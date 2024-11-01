<?php 
namespace WordPigeon;

use WordPigeon\Utils;

class WordPigeonOptions 
{

  function word_pigeon_register_options() 
  {
    $pageTitle = "Word Pigeon";
    $menuTitle = "Word Pigeon Options";
    $capability = "manage_options";
    $menuSlug = "word-pigeon-options.php";
    $callback = array($this, 'output_word_pigeon_options_view');

    add_options_page(   
        $pageTitle,     
        $menuTitle,
        $capability,
        $menuSlug,
        $callback
    );
  }

  function output_word_pigeon_options_view()
  {      
    $message = '';

    if (isset($_POST["deleteKey"]))
    {
      $this->updateKey("");
      $message = $this->createMessage("Public Key <strong>deleted</strong>", "updated", true);
    }
    else if (isset($_POST["publicKey"])) // Create/Update
    {    
      $publicKey = \sanitize_textarea_field($_POST["publicKey"]);
      $validationMsg = Utils::validatePem($publicKey);

      if ($validationMsg === '') 
      {
        $this->updateKey($publicKey);
        $message = $this->createMessage("Public Key <strong>updated</strong>", "updated", true);
      }
      else
      {
        $message = $this->createMessage("Public Key invalid: <strong>$validationMsg</strong>", "error", true);
      }
    }

    $publicKeyExists = \esc_html(\get_option("word_pigeon_public_key"));
    $postUrl = \get_site_url(null, "/wp-admin/options-general.php?page=word-pigeon-options.php");    
    $this->echoHtml($publicKeyExists, $message, $postUrl);
  }


  function updateKey($publicKey) {
    \add_option('word_pigeon_public_key', $publicKey);
    \update_option('word_pigeon_public_key', $publicKey);
  }

  function echoHtml($publicKeyExists, $message, $postUrl) {
    //the paramters are required by this template
    include("activation-template.php");
  }

  function createMessage(string $message, string $messageType, bool $dismissable) {
    $dismissButton =  $dismissable 
      ? "<button type='button' class='notice-dismiss'><span class='screen-reader-text'>Dismiss this notice.</span></button>" 
      : '';

    $output = "<div class='$messageType notice is-dismissible'><p>$message</p>$dismissButton</div>";
    return $output;
  }

}

// https://wisdmlabs.com/blog/create-settings-options-page-for-wordpress-plugin/
// https://codex.wordpress.org/Function_Reference/add_options_page
// https://www.sitepoint.com/wordpress-settings-api-build-custom-admin-page/