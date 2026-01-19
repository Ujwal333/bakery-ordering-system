<?php
// Fix duplicate Model imports in all model files

$modelsDir = __DIR__ . '/app/Models';
$files = glob($modelsDir . '/*.php');

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Remove duplicate "use Illuminate\Database\Eloquent\Model;" lines
    $lines = explode("\n", $content);
    $newLines = [];
    $modelImportAdded = false;
    
    foreach ($lines as $line) {
        // If this is a Model import line
        if (strpos($line, 'use Illuminate\\Database\\Eloquent\\Model;') !== false) {
            // Only add the first one
            if (!$modelImportAdded) {
                $newLines[] = $line;
                $modelImportAdded = true;
            }
            // Skip duplicates
        } else {
            $newLines[] = $line;
        }
    }
    
    $newContent = implode("\n", $newLines);
    file_put_contents($file, $newContent);
    echo "Fixed: " . basename($file) . "\n";
}

echo "\n✓ All models fixed!\n";
?>
