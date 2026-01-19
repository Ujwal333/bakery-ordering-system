import os

target_dir = r"c:\xampp\htdocs\bakery-ordering-system\Backend\resources\views\admin"

print(f"Scanning {target_dir}...")

for root, dirs, files in os.walk(target_dir):
    for file in files:
        if file.endswith(".blade.php"):
            path = os.path.join(root, file)
            try:
                with open(path, "r", encoding="utf-8") as f:
                    content = f.read()
                
                if "@extends('layouts.admin')" in content or '@extends("layouts.admin")' in content:
                    print(f"Updating {file}...")
                    new_content = content.replace("@extends('layouts.admin')", "@extends('admin.layout')")
                    new_content = new_content.replace('@extends("layouts.admin")', "@extends('admin.layout')")
                    
                    with open(path, "w", encoding="utf-8") as f:
                        f.write(new_content)
            except Exception as e:
                print(f"Error processing {path}: {e}")

print("Done.")
