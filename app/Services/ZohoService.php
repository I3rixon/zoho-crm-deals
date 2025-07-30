<?php

namespace App\Services;

use com\zoho\api\authenticator\OAuthBuilder;
use com\zoho\api\authenticator\store\FileStore;
use com\zoho\crm\api\dc\EUDataCenter;
use com\zoho\crm\api\InitializeBuilder;


class ZohoService
{
    public static function initialize(): void
    {
        
        // Create the FileStore to save token details
        $tokenStore = new FileStore(storage_path('app\zoho_tokens\zoho_token.txt'));

        // Define Zoho CRM environment (use EUDataCenter or others if needed)
        $environment = EUDataCenter::PRODUCTION();

        // Create OAuth token builder
        $token = (new OAuthBuilder())
            ->clientId(env('ZOHO_CLIENT_ID'))
            ->clientSecret(env('ZOHO_CLIENT_SECRET'))
            ->refreshToken(env('ZOHO_REFRESH_TOKEN'))
            ->redirectURL(env('ZOHO_REDIRECT_URI'))
            ->build();

      
        //dd($token);

        // Initialize SDK
        (new InitializeBuilder())
            ->environment($environment)
            ->token($token)
            ->store($tokenStore)
           
            ->initialize();
    }
}

