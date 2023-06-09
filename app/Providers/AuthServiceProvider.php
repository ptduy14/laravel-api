<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // token expire
        Passport::tokensExpireIn(now()->addDays(3)); // token sẽ hết hạn trong 3 ngày
        Passport::refreshTokensExpireIn(now()->addDays(10)); // refresh Token sẽ hết hạn trong 5 ngày
        Passport::personalAccessTokensExpireIn(now()->addDays(6)); // PAT sẽ hết hạn trong 6 ngày
    }
}
