<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CKEditorController extends Controller
{
    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            try {
                $file = $request->file('upload');

                // Use a temporary directory for initial uploads
                $tempDirectory = 'temp_images';
                Storage::disk('public')->makeDirectory($tempDirectory);

                $filename = time() . '.' . $file->getClientOriginalExtension();
                $filePath = "{$tempDirectory}/{$filename}";

                // Store the image temporarily in the public disk
                Storage::disk('public')->put($filePath, file_get_contents($file));

                // Generate the correct URL for accessing the image
                $url = Storage::url($filePath);

                // Return JSON response to CKEditor
                return response()->json([
                    'uploaded' => 1,
                    'fileName' => $filename,
                    'url' => $url,
                ]);
            } catch (\Exception $e) {
                // Log error
                \Log::error('CKEditor file upload error: ' . $e->getMessage());

                return response()->json([
                    'uploaded' => 0,
                    'error' => [
                        'message' => 'Failed to upload file.'
                    ],
                ]);
            }
        }

        return response()->json([
            'uploaded' => 0,
            'error' => [
                'message' => 'No file was uploaded.'
            ],
        ]);
    }
}
