<?php
$ds = DIRECTORY_SEPARATOR;
$base_dir = realpath(dirname(__FILE__)  . $ds . '..') . $ds;

// Website url
defined( "URL" ) ? null : define( "URL", "http://localhost:90/" );
defined( "TIMEZONE" ) ? null : define( "TIMEZONE", "Africa/Lagos" );

// Database
defined( "DB_HOST" ) ? null : define( "DB_HOST", "localhost" );
defined( "DB_USER" ) ? null : define( "DB_USER", "root" );
defined( "DB_PASSWORD" ) ? null : define( "DB_PASSWORD", "" );
defined( "DB_NAME" ) ? null : define( "DB_NAME", "auctionsystem" );
defined( "DB_PORT" ) ? null : define( "DB_PORT", 3306 );

// Email server
defined( "EMAIL_DEBUG" ) ? null : define( "EMAIL_DEBUG", "html" );
defined( "EMAIL_ENCRYPTION" ) ? null : define( "EMAIL_ENCRYPTION", "tls" );
defined( "EMAIL_HOST" ) ? null : define( "EMAIL_HOST", "" );
defined( "EMAIL_USER" ) ? null : define( "EMAIL_USER", "" );
defined( "EMAIL_PASSWORD" ) ? null : define( "EMAIL_PASSWORD", "" );
defined( "EMAIL_SMTP" ) ? null : define( "EMAIL_SMTP", 587 );

// Upload
require_once("{$base_dir}config{$ds}config.php");
#defined( "ROOT" ) ? null : define( "ROOT", $_SERVER['DOCUMENT_ROOT'] );
defined( "ROOT" ) ? null : define( "ROOT", "{$base_dir}" );
defined( "UPLOAD_PROFILE_IMAGE" ) ? null : define( "UPLOAD_PROFILE_IMAGE", "/images/profile_images/" );
defined( "UPLOAD_ITEM_IMAGE" ) ? null : define( "UPLOAD_ITEM_IMAGE", "/images/item_images/" );