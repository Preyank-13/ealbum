<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

function testHelper(): string{
    return 'testing 000';
}

function deleteImages($image){
    if(isset($image)){
        // Sabhi folders se image delete karne ka logic
        $folders = ['lg', 'md', 'sm', 'xs', 'icon'];
        foreach($folders as $folder) {
            $path = public_path('web/media/' . $folder . '/' . $image);
            if(File::exists($path)){
                unlink($path);
            }
        }
    }
}

function uploadImageTemp($request, $fileName = 'image', $prefix = null){
    // Badi images (10MB+) ke liye memory limit badhana zaroori hai
    ini_set('memory_limit', '512M'); 
    
    $manager = new ImageManager(new Driver());
    
    if (request()->hasFile($fileName)) {
        $file = $request->file($fileName);
        $image_name = $prefix.time().'_'.rand(111,999).'.webp';
        
        // Sizes aur unki widths define karein
        $sizes = [
            'icon' => 200,
            'xs'   => 500,
            'sm'   => 1000,
            'md'   => 1500,
            'lg'   => 3000
        ];

        foreach ($sizes as $folder => $width) {
            $path = public_path('web/media/' . $folder);
            
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            // Image ko read karke process karein
            $img = $manager->read($file);
            $img->scaleDown(width: $width);
            
            // 🟢 10MB optimization logic: webp conversion with 75% quality
            // Isse 10MB ki file 1MB se bhi kam ho jayegi par quality professional rahegi
            $img->toWebp(75)->save($path.'/'.$image_name);
        }
        
        return $image_name;
    }
    return null;
}

function uploadImagesThumb($request, $fileName = null, $prefix = null) {
    // Memory limit for heavy processing
    ini_set('memory_limit', '512M');
    
    $manager = new ImageManager(new Driver());
    
    if ($request !== null) {
        $image_name = $prefix . time() . '_' . rand(111, 999) . '.webp';
        
        $sizes = [
            'icon' => 200,
            'xs'   => 500,
            'sm'   => 1000,
            'md'   => 1800,
            'lg'   => 3000
        ];

        foreach ($sizes as $folder => $width) {
            $path = public_path('web/media/' . $folder);

            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            $img = $manager->read($request);
            $img->scaleDown(width: $width);
            
            // 🟢 Optimized for 10MB inputs
            $img->toWebp(80)->save($path . '/' . $image_name); 
        }
        
        return $image_name;
    }

    return null;
}