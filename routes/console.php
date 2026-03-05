<?php
use Illuminate\Support\Facades\Schedule;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

Schedule::command('queue:work --stop-when-empty')->everyMinute()->withoutOverlapping();
Schedule::command('backup:clean')->daily()->at('01:00');
Schedule::command('backup:run --only-db --disable-notifications')->daily()->at('01:30');

// Clean up expired/revoked Passport tokens, auth codes & refresh tokens weekly
Schedule::command('passport:purge')->weekly()->at('03:00');
