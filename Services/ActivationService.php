<?php
namespace WordPigeon\Services;

use WordPigeon\Utils;

class ActivationService
{
    public static function activate()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "word_pigeon_token_log"; 
      
        $charset_collate = $wpdb->get_charset_collate();
        $create_table_query = "
                CREATE TABLE IF NOT EXISTS {$table_name} (
                  Id char(36) NOT NULL,
                  DateUsed TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
                  PRIMARY KEY (Id)
                ) $charset_collate;
        ";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $create_table_query );
      
        Utils::checkForErrorsAndRethrow();
    }

    public static function deactivate()
    {
        global $wpdb;

        $table_name = $wpdb->prefix . "word_pigeon_token_log";       
        $query = "DROP TABLE $table_name;";
        require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
        dbDelta( $query );
      
        Utils::checkForErrorsAndRethrow();
    }
}