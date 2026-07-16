<?php

require __DIR__.'/../vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

$kernel = $app->make(Kernel::class);
$kernel->bootstrap();

use Illuminate\Contracts\Console\Kernel;
use Illuminate\Support\Facades\Mail;

try {
    Mail::raw('Test SMTP from Quickcredit backend', function ($message) {
        $message->to('chrisvianneymaoule@gmail.com')
            ->subject('Test de mail Quickcredit');
    });
    echo "Mail send command executed successfully.\n";
} catch (Throwable $e) {
    echo 'Mail send failed: '.$e->getMessage()."\n";
    exit(1);
}
