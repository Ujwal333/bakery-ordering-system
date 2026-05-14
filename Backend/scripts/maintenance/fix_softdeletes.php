<?php
// Models that SHOULD NOT have SoftDeletes based on migrations
$modelsWithoutSoftDeletes = [
    'Order',        // orders table doesn't have deleted_at
    'Cart',         // cart table doesn't have deleted_at
    'CartItem',     // cart_items table doesn't have deleted_at
    'OrderItem',    // order_items table doesn't have deleted_at
    'OrderTracking' // order_trackings table doesn't have deleted_at
];

$modelsDir = __DIR__ . '/app/Models';

foreach ($modelsWithoutSoftDeletes as $modelName) {
    $filePath = $modelsDir . '/' . $modelName . '.php';
    $content = file_get_contents($filePath);
    
    // Remove SoftDeletes from imports if present
    $content = str_replace("use Illuminate\\Database\\Eloquent\\SoftDeletes;\n", "", $content);
    $content = str_replace("use Illuminate\\Database\\Eloquent\\SoftDeletes;", "", $content);
    
    // Remove SoftDeletes from traits
    $content = str_replace(", SoftDeletes", "", $content);
    $content = str_replace("SoftDeletes, ", "", $content);
    
    file_put_contents($filePath, $content);
    echo "Fixed: $modelName - Removed SoftDeletes\n";
}

echo "\n✓ Models fixed!\n";
?>
