<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Domain\Interfaces\UserRepositoryInterface;
use App\Domain\Interfaces\PatientRepositoryInterface;
use App\Domain\Interfaces\PersonalInfoRepositoryInterface;
use App\Infrastructure\Repositories\UserRepository;
use App\Infrastructure\Repositories\PatientRepository;
use App\Infrastructure\Repositories\PersonalInfoRepository;
use App\Infrastructure\Repositories\AppointmentRepository;
use App\Domain\Interfaces\AppointmentRepositoryInterface;
use App\Domain\Interfaces\PrescriptionRepositoryInterface;
use App\Infrastructure\Repositories\PrescriptionRepository;
use App\Domain\Interfaces\MedicalHistoryRepositoryInterface;
use App\Infrastructure\Repositories\MedicalHistoryRepository;
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
        $this->app->bind(
            AppointmentRepositoryInterface::class,
            AppointmentRepository::class
        );
        $this->app->bind(
            PrescriptionRepositoryInterface::class,
            PrescriptionRepository::class
        );
        $this->app->bind(
            MedicalHistoryRepositoryInterface::class,
            MedicalHistoryRepository::class
        );


    }

    public function boot(): void
    {
        //
    }
}
