<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Illuminate\Support\Facades\File;

class ImageUploadController extends Controller
{
    public function showForm()
    {
        return view('images.upload', ['noindex' => true]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'images' => 'required|array|max:10',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:5120',
        ]);

        $path = public_path('images/');

        if (!is_dir($path)) {
            mkdir($path, 0755, true);
        }

        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $image) {
            try {
                $img = $manager->read($image);

                $img
                    ->resize(1200, null, function ($constraint) {
                        $constraint->aspectRatio();
                        $constraint->upsize();
                    })
                    ->toWebp(
                        75
                    )
                    ->save(
                        public_path('images/' . $image->getClientOriginalName() . '.webp'),
                    );
            } catch (\Throwable $e) {
                return $e->getMessage();
            }
        }
        return "OK";
    }
}
