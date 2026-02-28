<?php

use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;
use Illuminate\Support\Facades\File;


function testHelper(): string{
    return 'testing 000';
}





function deleteImages($image){
    if(isset($image)){
        if(File::exists(public_path('web').'/media/lg/'.$image)){
            unlink(public_path('web').'/media/lg/'.$image);
          }
          if(File::exists(public_path('web').'/media/md/'.$image)){
            unlink(public_path('web').'/media/md/'.$image);
        }
        if(File::exists(public_path('web').'/media/sm/'.$image)){
            unlink(public_path('web').'/media/sm/'.$image);
        }
        if(File::exists(public_path('web').'/media/xs/'.$image)){
            unlink(public_path('web').'/media/xs/'.$image);
        }
        if(File::exists(public_path('web').'/media/icon/'.$image)){
            unlink(public_path('web').'/media/icon/'.$image);
        }
    }
}

function uploadImageTemp($request, $fileName = 'image', $prefix = null){
    // dd($request->file('image'));
    
    $manager = new ImageManager(
        new Intervention\Image\Drivers\Gd\Driver()
    );
    
    if (request()->hasFile($fileName)) {
    // open an image file
    $image = @$manager->read($request->file($fileName));
    $image_name = $prefix.time().'_'.rand(111,999).'.webp';
    
    // Icons Convversion

    $iconPath = public_path('web/media/icon');
    $iconImage = @$manager->read($request->file($fileName));
    $iconImage->scaleDown(width: 200);
    $iconImage->save($iconPath.'/'.$image_name);

    // xs Convversion

    $xsPath = public_path('web/media/xs');
    $xsImage = @$manager->read($request->file($fileName));
    $xsImage->scaleDown(width: 500);
    $xsImage->save($xsPath.'/'.$image_name);

    // sm Convversion

    $smPath = public_path('web/media/sm');
    $smImage = @$manager->read($request->file($fileName));
    $smImage->scaleDown(width: 1000);
    $smImage->save($smPath.'/'.$image_name);

    // md Convversion

    $mdPath = public_path('web/media/md');
    $mdImage = @$manager->read($request->file($fileName));
    $mdImage->scaleDown(width: 1500);
    $mdImage->save($mdPath.'/'.$image_name);

    // lg Convversion

    $lgPath = public_path('web/media/lg');
    $lgImage = @$manager->read($request->file($fileName));
    $lgImage->scaleDown(width: 3000);
    $lgImage->save($lgPath.'/'.$image_name);
    
    // lg Convversion
    
    // $lgPath = public_path('web/media/xl');
    // $lgImage = @$manager->read($request->file($fileName));
    // $lgImage->scaleDown(width: 3000);
    // $lgImage->save($lgPath.'/'.$image_name);
    
    return $image_name;
    }
    else{
        return null;
    }
}



function uploadImagesThumb($request, $fileName = null, $prefix = null) {
    // dd($request);
    $manager = new ImageManager(new Driver());
    
    if ($request !== null) {
        $image_name = $prefix . time() . '_' . rand(111, 999) . '.webp';
        
        // Define sizes and their respective widths
        $sizes = [
            'icon' => 200,
            'xs'   => 500,
            'sm'   => 1000,
            'md'   => 1800,
            'lg'   => 3000
        ];

        foreach ($sizes as $folder => $width) {
            // Path define karein
            $path = public_path('web/media/' . $folder);

            // ✅ STEP: Agar folder nahi hai toh create karein (with 0755 permissions)
            if (!File::isDirectory($path)) {
                File::makeDirectory($path, 0755, true, true);
            }

            // Image process aur save karein
            $img = $manager->read($request);
            $img->scaleDown(width: $width);
            $img->toWebp(80)->save($path . '/' . $image_name); // Quality 80 for optimization
        }
        
        return $image_name;
    }

    return null;
}

// function uploadImagesThumb($request, $fileName = null, $prefix = null){
    
    


//     $manager = new ImageManager(
//         new Intervention\Image\Drivers\Gd\Driver()
//     );
    
    
//     if ($request !== null) {
//         // open an image file
//     $image = @$manager->read($request);
//     $image_name = $prefix.time().'_'.rand(111,999).'.webp';
    
//     // Icons Convversion

//     $iconPath = public_path('web/media/icon');
//     $iconImage = @$manager->read($request);
//     $iconImage->scaleDown(width: 200);
//     $iconImage->save($iconPath.'/'.$image_name);

    

//     // xs Convversion

//     $xsPath = public_path('web/media/xs');
//     $xsImage = @$manager->read($request);
//     $xsImage->scaleDown(width: 500);
//     $xsImage->save($xsPath.'/'.$image_name);

//     // sm Convversion

//     $smPath = public_path('web/media/sm');
//     $smImage = @$manager->read($request);
//     $smImage->scaleDown(width: 1000);
//     $smImage->save($smPath.'/'.$image_name);

//     // md Convversion

//     $mdPath = public_path('web/media/md');
//     $mdImage = @$manager->read($request);
//     $mdImage->scaleDown(width: 1500);
//     $mdImage->save($mdPath.'/'.$image_name);

//     // lg Convversion

//     $lgPath = public_path('web/media/lg');
//     $lgImage = @$manager->read($request);
//     $lgImage->scaleDown(width: 3000);
//     $lgImage->save($lgPath.'/'.$image_name);
    
//     return $image_name;
//     }
//     else{
//         return null;
//     }

// }