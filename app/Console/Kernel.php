<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use App\Console\Commands\CheckProductStockCommand; // ¡IMPORTANTE: Importa tu comando aquí!

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule): void
    {
        // Esto programará tu comando 'alerts:check-stock' para que se ejecute cada minuto.
        // Es ideal para pruebas rápidas. Una vez que funcione, considera cambiarlo a:
        // ->everyFifteenMinutes() o ->hourly() para producción.
        $schedule->command(CheckProductStockCommand::class)->everyMinute();

        // Puedes borrar la línea de ejemplo 'inspire' si está presente:
        // $schedule->command('inspire')->hourly();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands'); // Esto carga automáticamente los comandos dentro de la carpeta 'Commands'

        require base_path('routes/console.php'); // Carga los comandos definidos en routes/console.php
    }
}