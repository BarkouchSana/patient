<?php
namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\Eloquent\UserRepository;
use App\Repositories\Interfaces\PatientRepositoryInterface;
use App\Repositories\Eloquent\PatientRepository;
use App\Repositories\Interfaces\PersonalInfoRepositoryInterface;
use App\Repositories\Eloquent\PersonalInfoRepository;
use App\Repositories\Interfaces\AppointmentRepositoryInterface;
use App\Repositories\Eloquent\AppointmentRepository;
use App\Repositories\Interfaces\PrescriptionRepositoryInterface;
use App\Repositories\Interfaces\MedicalHistoryRepositoryInterface;
use App\Repositories\Eloquent\PrescriptionRepository;
use App\Repositories\Interfaces\VitalSignRepositoryInterface;
use App\Repositories\Eloquent\MedicalHistoryRepository;
use App\Repositories\Interfaces\LabResultRepositoryInterface;
use App\Repositories\Eloquent\VitalSignRepository;
use App\Repositories\Eloquent\LabResultRepository;


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
        $this->app->bind(
            VitalSignRepositoryInterface::class,
            VitalSignRepository::class
        );


        $this->app->bind(  
            LabResultRepositoryInterface::class,
            LabResultRepository::class
        );

    }

    public function boot(): void
    {
        //
    }
}
