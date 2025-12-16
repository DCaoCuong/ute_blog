<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageUploadController extends Controller
{
    /**
     * Upload image for post content
     */
    public function upload(Request $request)
    {
        try {
            $request->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff|max:10240', // 10MB max
            ], [
                'image.required' => 'Vui lòng chọn file ảnh',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Định dạng ảnh không được hỗ trợ. Vui lòng chọn: JPEG, PNG, GIF, WebP, BMP, SVG, TIFF',
                'image.max' => 'Kích thước ảnh không được vượt quá 10MB',
            ]);

            $image = $request->file('image');

            // Generate unique filename
            $filename = time() . '_' . Str::random(10) . '.' . $image->getClientOriginalExtension();

            // Store in public/uploads/posts directory
            $path = $image->storeAs('uploads/posts', $filename, 'public');

            // Get full URL
            $url = Storage::url($path);

            return response()->json([
                'success' => true,
                'url' => $url,
                'filename' => $filename,
                'path' => $path,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first('image'),
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Upload thất bại: ' . $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Delete uploaded image
     */
    public function delete(Request $request)
    {
        $request->validate([
            'path' => 'required|string',
        ]);

        try {
            if (Storage::disk('public')->exists($request->path)) {
                Storage::disk('public')->delete($request->path);

                return response()->json([
                    'success' => true,
                    'message' => 'Image deleted successfully',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Image not found',
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Delete failed: ' . $e->getMessage(),
            ], 500);
        }
    }
}
