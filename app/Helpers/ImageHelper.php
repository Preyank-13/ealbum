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

            foreach ($sizes as $folder => $width) {
                $path = public_path('web/media/' . $folder);
                
                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                // Optimization: Read image once outside if possible, but for v3 this is safe
                $img = $manager->read($file);
                $img->scaleDown(width: $width);
                
                // Encode and Save
                $encoded = $img->toWebp(65);
                $encoded->save($path.'/'.$image_name);
            }
            
            return $image_name;
        }
        return null;
    }
}

/**
 * 🟢 Function for Multiple Images (Gallery)
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
                'lg'   => 1800 
            ];

            foreach ($sizes as $folder => $width) {
                $path = public_path('web/media/' . $folder);

                if (!File::isDirectory($path)) {
                    File::makeDirectory($path, 0755, true, true);
                }

                $img = $manager->read($fileInstance);
                $img->scaleDown(width: $width);
                
                $encoded = $img->toWebp(60);
                $encoded->save($path . '/' . $image_name); 
            }
            
            return $image_name;
        }
        return null;
    }
}