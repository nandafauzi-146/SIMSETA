<?php

namespace App\Providers;

use App\Models\Sertifikat;
use App\Models\User;
use App\Models\Desa;
use App\Models\PenggunaanTanah;
use App\Models\Setting;
use App\Policies\SertifikatPolicy;
use App\Policies\UserPolicy;
use App\Policies\DesaPolicy;
use App\Policies\PenggunaanTanahPolicy;
use App\Policies\SettingPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Sertifikat::class => SertifikatPolicy::class,
        User::class => UserPolicy::class,
        Desa::class => DesaPolicy::class,
        PenggunaanTanah::class => PenggunaanTanahPolicy::class,
        Setting::class => SettingPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
