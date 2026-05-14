<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Models\Periodospostu;
use Illuminate\Support\Carbon;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
                // $schedule->command('inspire')->hourly();
        //Inicio backup spatie        
        $fechaActual = Carbon::parse(now())->format('Y-m-d');
        $periodosPostu =  Periodospostu::whereRaw("DATE_FORMAT(fechaInicioPostu, '%Y-%m-%d') <= '" . $fechaActual . "' and DATE_FORMAT(fechaFinPostu, '%Y-%m-%d') >= '" . $fechaActual . "'")->first();

      //Se realiza el respaldo de la BD solo durante la postulación
        if (!empty($periodosPostu)) {
            $schedule->command('backup:clean')->daily()->at('03:00');
            $schedule->command('backup:run')->daily()->at('04:00');//->twiceDaily(9, '9:20');//
            $schedule->command('backup:run')->daily()->at('12:00');
            $schedule->command('backup:run')->daily()->at('18:00');
            $schedule->command('backup:run')->daily()->at('00:00');
        }
        //Fin backup spatie    
    }
    

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
