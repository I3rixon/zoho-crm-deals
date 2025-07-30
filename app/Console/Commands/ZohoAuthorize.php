<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\ZohoAuthService;

class ZohoAuthorize extends Command
{
    protected $signature = 'zoho:authorize';
    protected $description = 'Exchange authorization code for access and refresh tokens using Zoho SDK';

    public function handle()
    {
        $this->info('Follow this URL to authorize:');
        $this->line('');
        $this->line(env('ZOHO_BASE_URL').'/oauth/v2/auth?scope=ZohoCRM.modules.ALL,ZohoCRM.settings.ALL&client_id=' . env('ZOHO_CLIENT_ID') . '&response_type=code&access_type=offline&redirect_uri=' . urlencode(env('ZOHO_REDIRECT_URI')));
        $this->line('');
        
        $code = $this->ask('Paste the authorization code (from the redirected URL)');

        try {
            $token = ZohoAuthService::exchangeCodeForToken($code);

            $this->info("Access Token: {$token->getAccessToken()}");
            $this->info("Refresh Token: {$token->getRefreshToken()}");

            // Save to .env manually (or update programmatically)
            $this->warn("Add the following line to your .env file:");
            $this->line("ZOHO_REFRESH_TOKEN={$token->getRefreshToken()}");

            return Command::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Failed to authorize: ' . $e->getMessage());
            return Command::FAILURE;
        }
    }
}