<?php
require __DIR__ . '/../vendor/autoload.php';
$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Http\Kernel::class);
$response = $kernel->handle(
    $request = Illuminate\Http\Request::capture()
);

use App\Models\User;
foreach(User::all() as $u) {
    echo "ID: {$u->id} | Name: {$u->name} | VIP: " . ($u->is_vip ? 'Yes' : 'No') . "\n";
}
