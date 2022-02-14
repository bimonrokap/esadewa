<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('monitoring:generate')->daily()->at("06:00")->name("monitoring-generate")->withoutOverlapping();

        $schedule->command('interconnection:siman MA_ASET_TETAP_LAINNYA')->hourlyAt(1)->name("interconnection-siman-lainnya")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_TANAH')->hourlyAt(3)->name("interconnection-siman-tanah")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_TAK_BERWUJUD')->hourlyAt(5)->name("interconnection-siman-takberwujud")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_RUMAH_NEGARA')->hourlyAt(7)->name("interconnection-siman-rumahnegara")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_RENOVASI')->hourlyAt(9)->name("interconnection-siman-renovasi")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_PM_NON_TIK')->hourlyAt(11)->name("interconnection-siman-pmnontik")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_PM_KHUSUS_TIK')->hourlyAt(13)->name("interconnection-siman-pmkhusustik")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_KDP')->hourlyAt(15)->name("interconnection-siman-kdp")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_JALAN_JEMBATAN')->hourlyAt(17)->name("interconnection-siman-jalanjembatan")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_INSTALASI_JARINGAN')->hourlyAt(19)->name("interconnection-siman-instalasijaringan")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_GEDUNG_BANGUNAN')->hourlyAt(21)->name("interconnection-siman-gedungbangunan")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_BANGUNAN_AIR')->hourlyAt(23)->name("interconnection-siman-bangunanair")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_ALAT_BERAT')->hourlyAt(25)->name("interconnection-siman-alatberat")->withoutOverlapping();
        $schedule->command('interconnection:siman MA_ASET_ALAT_ANGKUTAN')->hourlyAt(27)->name("interconnection-siman-alatangkutan")->withoutOverlapping();
        // $schedule->command('interconnection:siman')->hourly()->name("interconnection-siman")->withoutOverlapping();
        // $schedule->command('interconnection:siman')->weekly()->mondays()->tuesdays()->at("00:10")
        // ->name("interconnection-siman")->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}

// perubahan pada repo original
// perubahan pada kukuh