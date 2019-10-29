<?php

namespace iobom\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use iobom\Models\Asistencia\Asistencia;
use iobom\Models\Emergencia\Emergencia;
use iobom\Models\Estacion;
use iobom\Models\FormularioEmergencia;
use iobom\Policies\AsistenciaPolicy;
use iobom\Policies\EmergenciaPolicy;
use iobom\Policies\EstacionPolicy;
use iobom\Policies\FormularioEmercenciaPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Estacion::class => EstacionPolicy::class,
        Emergencia::class=>EmergenciaPolicy::class,
        Asistencia::class=>AsistenciaPolicy::class,
        FormularioEmergencia::class=>FormularioEmercenciaPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::before(function ($user, $ability) {
        //     return $user->hasRole(['Administrador','Jefa de sistemas']) ? true : null;
        // });
    }
}
