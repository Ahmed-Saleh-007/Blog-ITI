<?php

use Illuminate\Support\Facades\Storage;


if (!function_exists('savePhoto')) {

    // save image
    function savePhoto($imageName,$folderName,$request)
    {

        $image = Image::make($request->file($imageName))->encode('jpg', 80);

        $image->fit(1200, 630, function ($constraint) {
            $constraint->upsize();
        });
        // Create new filename
        $fileNameToStore = time().'-'.rand(100000,999999).'.jpg';

        $path = $folderName.'/'.date('Y').'/'.date('m').'/'.date('d').'/'.$fileNameToStore;

        Storage::disk('public')->put($path,$image->__toString());

        return $path;
    }
}
