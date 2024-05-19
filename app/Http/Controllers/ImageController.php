<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Image as ImageModel;

class ImageController extends Controller
{
    public function index()
    {
        $images = ImageModel::all();
        return view('welcome', compact('images'));
    }

    public function upload(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $image = $request->file('image');
        $originalPath = $image->store('images', 'public');

        // Process the image to sketch using GD library
        $originalImagePath = storage_path("app/public/{$originalPath}");
        $sketchPath = 'sketches/' . basename($originalPath);
        $sketchImagePath = storage_path("app/public/{$sketchPath}");

        $this->convertToSketch($originalImagePath, $sketchImagePath);

        // Save paths to database
        $imageModel = new ImageModel();
        $imageModel->original_path = $originalPath;
        $imageModel->sketch_path = $sketchPath;
        $imageModel->save();

        return response()->json(['sketch_url' => url("storage/{$sketchPath}")]);
    }

    private function convertToSketch($inputPath, $outputPath)
    {
        // Load the image
        $image = imagecreatefromstring(file_get_contents($inputPath));
        if (!$image) {
            throw new \Exception("Could not load image");
        }

        // Convert the image to grayscale
        imagefilter($image, IMG_FILTER_GRAYSCALE);

        // Apply a slight Gaussian blur
        imagefilter($image, IMG_FILTER_GAUSSIAN_BLUR);

        // Invert colors to get a negative image
        imagefilter($image, IMG_FILTER_NEGATE);

        // Apply contrast enhancement
        imagefilter($image, IMG_FILTER_CONTRAST, -20);

        // Apply edge detection
        imagefilter($image, IMG_FILTER_EDGEDETECT);

        // Enhance brightness and contrast
        imagefilter($image, IMG_FILTER_BRIGHTNESS, 30);
        imagefilter($image, IMG_FILTER_CONTRAST, 10);

        // Save the sketch image
        imagejpeg($image, $outputPath);

        // Free up memory
        imagedestroy($image);
    }

}
