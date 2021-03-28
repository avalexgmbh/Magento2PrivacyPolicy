<?php

namespace Avalex\PrivacyPolicy\Helper;

class CurlClientService extends \Magento\Framework\App\Helper\AbstractHelper
{
    protected static $caBundle = "";
    protected static $statusCode = "";
    protected static $errorCode = "";
    protected static $errorMessage = "";

    public static function execute( $url, $isJson = false ) {

        $handler = curl_init();

        $curlOptions = array(
            CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => $url,
            CURLOPT_CONNECTTIMEOUT => 5,
            CURLOPT_TIMEOUT => 10
        );

        if( !empty( self::$caBundle ) && file_exists( self::$caBundle  )  ) {

            $curlOptions[CURLOPT_CAINFO] = self::$caBundle;
            $curlOptions[CURLOPT_CAPATH] = self::$caBundle;

        } else {
            $curlOptions[CURLOPT_SSL_VERIFYPEER] = false;
        }

        curl_setopt_array($handler, $curlOptions);

        $result = curl_exec( $handler );

        if(!curl_exec( $handler )){
            die('Error: "' . curl_error( $handler ) . '" - Code: ' . curl_errno( $handler ));
        }

        $curlInfo = curl_getinfo( $handler );
        self::$statusCode = $curlInfo['http_code'];

        if( $isJson ) {

            $result = json_decode( $result, true );

        }

        curl_close( $handler  );

        return $result;

    }

    public static function getStatusCode() {
        return self::$statusCode;
    }

    public static function getErrorCode() {

    }

    public static function getErrorMessage() {

    }
}