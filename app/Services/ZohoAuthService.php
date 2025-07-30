<?php

namespace App\Services;

use com\zoho\api\authenticator\OAuthBuilder;
use com\zoho\crm\api\dc\USDataCenter;
use com\zoho\crm\api\InitializeBuilder;
use com\zoho\api\authenticator\store\FileStore;

class ZohoAuthService
{
    public static function exchangeCodeForToken(string $code)
    {
        $environment = USDataCenter::PRODUCTION();
        $tokenStore = new FileStore(storage_path('app/zoho-token.txt'));

        $token = (new OAuthBuilder())
            ->clientId(env('ZOHO_CLIENT_ID'))
            ->clientSecret(env('ZOHO_CLIENT_SECRET'))
            ->redirectURL(env('ZOHO_REDIRECT_URI'))
            ->grantToken($code) // <-- main part
            ->build();

        (new InitializeBuilder())
            ->environment($environment)
            ->token($token)
            ->store($tokenStore)
            ->initialize();

        return $token;
    }
}
