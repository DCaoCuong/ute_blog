<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
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
            // Log request info for debugging
            Log::info('Image upload request', [
                'has_file' => $request->hasFile('image'),
                'files' => array_keys($request->allFiles()),
                'content_type' => $request->header('Content-Type'),
            ]);

            // Check if file was uploaded
            if (!$request->hasFile('image')) {
                return response()->json([
                    'success' => false,
                    'message' => 'Không tìm thấy file ảnh. Vui lòng chọn file và thử lại.',
                    'debug' => [
                        'files_received' => array_keys($request->allFiles()),
                        'all_keys' => array_keys($request->all()),
                    ]
                ], 422);
            }

            // Check if file is valid
            $image = $request->file('image');
            if (!$image->isValid()) {
                return response()->json([
                    'success' => false,
                    'message' => 'File ảnh không hợp lệ. Error: ' . $image->getErrorMessage(),
                ], 422);
            }

            // Validate file
            $request->validate([
                'image' => 'required|image|mimes:jpeg,jpg,png,gif,webp,bmp,svg,tiff|max:10240', // 10MB max
            ], [
                'image.required' => 'Vui lòng chọn file ảnh',
                'image.image' => 'File phải là hình ảnh',
                'image.mimes' => 'Định dạng ảnh không được hỗ trợ. Vui lòng chọn: JPEG, PNG, GIF, WebP, BMP, SVG, TIFF',
                'image.max' => 'Kích thước ảnh không được vượt quá 10MB',
            ]);

            // Generate unique filename
            $extension = $image->getClientOriginalExtension() ?: 'jpg';
            $filename = time() . '_' . Str::random(10) . '.' . $extension;

            // Ensure uploads directory exists
            if (!Storage::disk('public')->exists('uploads/posts')) {
                Storage::disk('public')->makeDirectory('uploads/posts');
            }

            // Store in public/uploads/posts directory
            $path = $image->storeAs('uploads/posts', $filename, 'public');

            if (!$path) {
                Log::error('Failed to store image', ['filename' => $filename]);
                return response()->json([
                    'success' => false,
                    'message' => 'Không thể lưu file. Vui lòng kiểm tra quyền ghi thư mục storage.',
                ], 500);
            }

            // Get full URL
            $url = Storage::url($path);

            Log::info('Image uploaded successfully', [
                'filename' => $filename,
                'path' => $path,
                'url' => $url,
                'size' => $image->getSize(),
            ]);

            return response()->json([
                'success' => true,
                'url' => $url,
                'filename' => $filename,
                'path' => $path,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::warning('Image validation failed', [
                'errors' => $e->validator->errors()->toArray(),
            ]);
            return response()->json([
                'success' => false,
                'message' => $e->validator->errors()->first('image'),
                'errors' => $e->validator->errors()->toArray(),
            ], 422);
        } catch (\Exception $e) {
            Log::error('Image upload error', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
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
