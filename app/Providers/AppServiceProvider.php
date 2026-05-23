<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
    }

    public function boot(): void
    {
        Paginator::defaultView('vendor.pagination.default');

        $siteLogoPath = null;
        $siteFaviconPath = null;

        if (Schema::hasTable('site_settings')) {
            $siteLogoPath = SiteSetting::getValue('site_logo');
            $siteFaviconPath = SiteSetting::getValue('site_favicon');
        }

        View::share([
            'siteName' => 'QR E-Ticket',
            'siteLogoPath' => $siteLogoPath,
            'siteLogoUrl' => $siteLogoPath ? Storage::url($siteLogoPath) : null,
            'siteFaviconPath' => $siteFaviconPath,
            'siteFaviconUrl' => $siteFaviconPath ? Storage::url($siteFaviconPath) : asset('favicon.ico'),
        ]);
    }
}
