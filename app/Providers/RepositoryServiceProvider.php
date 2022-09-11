<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register(): void
    {

        $this->app->bind(
            \App\Libs\Repositories\Contracts\AuthRepositoryInterface::class,
            \App\Libs\Repositories\AuthRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\EmailVerificationRepositoryInterface::class,
            \App\Libs\Repositories\EmailVerificationRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\ForgotPasswordRepositoryInterface::class,
            \App\Libs\Repositories\ForgotPasswordRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\CategoryRepositoryInterface::class,
            \App\Libs\Repositories\CategoryRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\ServiceRepositoryInterface::class,
            \App\Libs\Repositories\ServiceRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\UserRepositoryInterface::class,
            \App\Libs\Repositories\UserRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\AppointmentRepositoryInterface::class,
            \App\Libs\Repositories\AppointmentRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\FeedbackRepositoryInterface::class,
            \App\Libs\Repositories\FeedbackRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\TreatmentRepositoryInterface::class,
            \App\Libs\Repositories\TreatmentRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\ReferRepositoryInterface::class,
            \App\Libs\Repositories\ReferRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\ClaimRepositoryInterface::class,
            \App\Libs\Repositories\ClaimRepository::class
        );

        $this->app->bind(
            \App\Libs\Repositories\Contracts\PaystackPaymentRepositoryInterface::class,
            \App\Libs\Repositories\PaystackPaymentRepository::class
        );
        
        $this->app->bind(
            \App\Libs\Repositories\Contracts\PlanRepositoryInterface::class,
            \App\Libs\Repositories\PlanRepository::class
        );

    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(): void
    {
        //
    }
}
