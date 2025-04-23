<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class ValidateLicenseKey extends Command
{
    protected $signature = 'validate:license-key';
    protected $description = 'Validate the license key before installation or update';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $licenseKey = env('BUSINESSCART_LICENSE_KEY');

        if (empty($licenseKey)) {
            $this->error("License key is missing. Please set the BUSINESSCART_LICENSE_KEY environment variable.");
            return;
        }

        // Replace with your actual validation logic
        $validKeys = ['KEY1', 'KEY2', 'KEY3']; // Example valid keys

        if (!in_array($licenseKey, $validKeys)) {
            $this->error("Invalid license key. Please provide a valid license key.");
            return;
        }

        $this->info("License key is valid. Proceeding with installation/upgrade.");
    }
}
