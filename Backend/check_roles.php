<?php
require __DIR__ . '/vendor/autoload.php';
$app = require_once __DIR__ . '/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Role;
use Illuminate\Support\Facades\DB;

config(['database.default' => 'sqlite']);
config(['database.connections.sqlite.database' => __DIR__ . '/bakery_ordering_system']);

echo "Checking Roles Table...\n";

try {
    if (\Illuminate\Support\Facades\Schema::hasTable('roles')) {
        $roles = DB::table('roles')->get();
        if ($roles->isEmpty()) {
            echo "Roles table is empty.\n";
        } else {
            foreach ($roles as $role) {
                echo "ID: $role->id, Name: $role->name, Slug: $role->slug\n";
            }
        }
    } else {
        echo "Roles table does not exist.\n";
    }
} catch (\Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
