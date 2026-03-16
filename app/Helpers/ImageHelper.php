<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;

/**
 * 🟢 Function to Delete Images from all folders
 */
if (!function_exists('deleteImages')) {
    function deleteImages($imageName) {
        if (!$imageName) return;

        $folders = ['icon', 'xs', 'sm', 'md', 'lg'];
        
        foreach ($folders as $folder) {
            $path = public_path('web/media/' . $folder . '/' . $imageName);
            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}

/**
 * 🟢 Function for Single Image Upload (e.g., Cover Photo)
 * Optimized to prevent memory leakage
 */
if (!function_exists('uploadImageTemp')) {
    function uploadImageTemp($request, $fileName = 'image', $prefix = null){
        ini_set('memory_limit', '512M');
        set_time_limit(300); 
        
        $manager = new ImageManager(new Driver());
        
        if ($request->hasFile($fileName)) {
            $file = $request->file($fileName);
            $image_name = $prefix.time().'_'.rand(111,999).'.webp';
            
            $sizes = [
                'icon' => 150,
                'xs'   => 400,
                'sm'   => 800,
                'md'   => 1200,
                'lg'   => 2000 
            ];

            // 🟢 READ ONCE: Memory efficiency
            $originalImage = $manager->read($file);

            foreach ($sizes as $folder => $width) {
                $path = public_path('web/media/' . $folder);
                
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                // Clone the original to perform resizing without affecting the original object
                $img = clone $originalImage;
                
                // 🟢 Resize & Optimize
                $img->scaleDown(width: $width);
                
                // Encode to WebP (Quality 75 is perfect for HD + Low Size)
                $img->toWebp(75)->save($path.'/'.$image_name);
            }
            
            return $image_name;
        }
        return null;
    }
}

/**
 * 🟢 Function for Multiple Images (Gallery)
 * Optimized for high performance gallery uploads
 */
if (!function_exists('uploadImagesThumb')) {
    function uploadImagesThumb($fileInstance, $dummy = null, $prefix = null) {
        ini_set('memory_limit', '512M');
        set_time_limit(300);
        
        $manager = new ImageManager(new Driver());
        
        if ($fileInstance !== null) {
            $image_name = $prefix . time() . '_' . rand(111, 999) . '.webp';
            
            $sizes = [
                'icon' => 150,
                'xs'   => 400,
                'sm'   => 800,
                'md'   => 1200,
                'lg'   => 1920 // Standard Full HD width
            ];

            // 🟢 READ ONCE: Isse 10MB ki file bhi server crash nahi karegi
            $originalImage = $manager->read($fileInstance);

            foreach ($sizes as $folder => $width) {
                $path = public_path('web/media/' . $folder);

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                $img = clone $originalImage;
                
                // 🟢 High Quality Scaling
                $img->scaleDown(width: $width);
                
                // Quality 70-80 is sweet spot for photography albums
                $img->toWebp(75)->save($path . '/' . $image_name); 
            }
            
            return $image_name;
        }
        return null;
    }
}