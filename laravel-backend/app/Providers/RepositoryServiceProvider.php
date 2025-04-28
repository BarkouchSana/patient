<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Domain\Interfaces\PatientRepositoryInterface;
use App\Domain\Interfaces\PersonalInfoRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Repositories\PatientRepository;
use App\Infrastructure\Repositories\PersonalInfoRepository;

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(
            UserRepositoryInterface::class,
            UserRepository::class
        );
        $this->app->bind(
            PatientRepositoryInterface::class,
            PatientRepository::class
        );
        $this->app->bind(
            PersonalInfoRepositoryInterface::class,
            PersonalInfoRepository::class
        );
    }

    public function boot(): void
    {
        //
    }
}
