<?php
$target = realpath(__DIR__ . '/../storage/app/public');
$link   = __DIR__ . '/storage';

if (is_link($link)) {
    echo "✅ Symlink already exists: $link → " . readlink($link);
} elseif (file_exists($link)) {
    echo "⚠️ /public/storage exists but is NOT a symlink. Remove it manually and re-run.";
} else {
    if (symlink($target, $link)) {
        echo "✅ Symlink created: $link → $target";
    } else {
        echo "❌ Failed to create symlink. Try creating it manually in cPanel File Manager.";
    }
}

// Self-delete for security
unlink(__FILE__);
echo "<br>🗑️ This file has been deleted.";
