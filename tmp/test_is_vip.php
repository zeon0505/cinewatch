<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

$u = App\Models\User::first();
echo "is_vip raw: " . $u->getAttributes()['is_vip'] . "\n";
echo "is_vip cast: " . ($u->is_vip ? 'Yes' : 'No') . "\n";
echo "now(): " . now() . "\n";
echo "vip_until: " . $u->vip_until . "\n";
echo "lt: " . (now()->lt($u->vip_until) ? 'True' : 'False') . "\n";
