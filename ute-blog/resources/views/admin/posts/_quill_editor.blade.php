<!-- Quill Editor Container -->
<div id="quill-editor" style="height: 400px; background: white;"></div>
<input type="hidden" name="content" id="content-input">

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Initialize Quill
        var quill = new Quill('#quill-editor', {
            theme: 'snow',
            modules: {
                toolbar: [
                    [{ 'header': [1, 2, 3, 4, 5, 6, false] }],
                    ['bold', 'italic', 'underline', 'strike'],
                    [{ 'color': [] }, { 'background': [] }],
                    [{ 'align': [] }],
                    [{ 'list': 'ordered' }, { 'list': 'bullet' }],
                    ['blockquote', 'code-block'],
                    ['link', 'image'],
                    ['clean']
                ]
            },
            placeholder: 'Nhập nội dung bài viết...'
        });

        // Load existing content if editing
        @if(isset($post) && $post->content)
            quill.root.innerHTML = {!! json_encode($post->content) !!};
        @endif

            /**
             * Resize image before upload to optimize performance
             * @param {File} file - Original file
             * @param {number} maxWidth - Maximum width
             * @param {number} quality - JPEG quality (0-1)
             * @returns {Promise<Blob>}
             */
            function resizeImage(file, maxWidth = 1920, quality = 0.85) {
                return new Promise((resolve) => {
                    // SVG files don't need resizing
                    if (file.type === 'image/svg+xml') {
                        resolve(file);
                        return;
                    }

                    const img = new Image();
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');

                    img.onload = function () {
                        let width = img.width;
                        let height = img.height;

                        // Only resize if image is larger than maxWidth
                        if (width > maxWidth) {
                            height = Math.round((height * maxWidth) / width);
                            width = maxWidth;
                        }

                        canvas.width = width;
                        canvas.height = height;
                        ctx.drawImage(img, 0, 0, width, height);

                        // Convert to blob - use original type or fallback to jpeg
                        const outputType = ['image/png', 'image/gif', 'image/webp'].includes(file.type)
                            ? file.type
                            : 'image/jpeg';

                        canvas.toBlob((blob) => {
                            resolve(blob);
                        }, outputType, quality);
                    };

                    img.onerror = function () {
                        // If resize fails, use original file
                        resolve(file);
                    };

                    img.src = URL.createObjectURL(file);
                });
            }

        /**
         * Get CSRF token from meta tag or form
         */
        function getCsrfToken() {
            // Try meta tag first
            const metaTag = document.querySelector('meta[name="csrf-token"]');
            if (metaTag) {
                return metaTag.getAttribute('content');
            }
            // Fallback to hidden input in form
            const csrfInput = document.querySelector('input[name="_token"]');
            if (csrfInput) {
                return csrfInput.value;
            }
            // Static token from blade
            return '{{ csrf_token() }}';
        }

        // Custom image upload handler
        quill.getModule('toolbar').addHandler('image', function () {
            const input = document.createElement('input');
            input.setAttribute('type', 'file');
            input.setAttribute('accept', 'image/jpeg,image/jpg,image/png,image/gif,image/webp,image/bmp,image/svg+xml,image/tiff');
            input.click();

            input.onchange = async function () {
                const file = input.files[0];
                if (!file) return;

                // Validate file type
                const validTypes = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp', 'image/bmp', 'image/svg+xml', 'image/tiff'];
                if (!validTypes.includes(file.type)) {
                    alert('Định dạng ảnh không được hỗ trợ.\nVui lòng chọn: JPEG, PNG, GIF, WebP, BMP, SVG, TIFF');
                    return;
                }

                // Validate file size (10MB)
                if (file.size > 10 * 1024 * 1024) {
                    alert('Kích thước ảnh không được vượt quá 10MB\nKích thước hiện tại: ' + (file.size / 1024 / 1024).toFixed(2) + 'MB');
                    return;
                }

                // Show loading indicator
                const range = quill.getSelection() || { index: 0 };
                quill.insertText(range.index, '⏳ Đang upload ảnh...');

                try {
                    // Resize image before upload (optimize for web)
                    const resizedBlob = await resizeImage(file, 1920, 0.85);

                    // Create FormData with resized image
                    const formData = new FormData();
                    // Preserve original filename with proper extension
                    const fileName = file.name || `image_${Date.now()}.jpg`;
                    formData.append('image', resizedBlob, fileName);

                    console.log('Uploading image:', {
                        originalSize: (file.size / 1024).toFixed(2) + 'KB',
                        resizedSize: (resizedBlob.size / 1024).toFixed(2) + 'KB',
                        fileName: fileName
                    });

                    const response = await fetch('{{ route("admin.images.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': getCsrfToken(),
                            'Accept': 'application/json',
                            'X-Requested-With': 'XMLHttpRequest'
                        },
                        body: formData,
                        credentials: 'same-origin'
                    });

                    // Log response for debugging
                    console.log('Upload response status:', response.status, response.statusText);

                    // Remove loading text
                    quill.deleteText(range.index, '⏳ Đang upload ảnh...'.length);

                    // Handle non-JSON responses
                    const contentType = response.headers.get('content-type');
                    if (!contentType || !contentType.includes('application/json')) {
                        const textResponse = await response.text();
                        console.error('Non-JSON response:', textResponse);
                        alert('❌ Lỗi server\n\nServer không trả về JSON. Vui lòng kiểm tra console để biết chi tiết.');
                        return;
                    }

                    const data = await response.json();
                    console.log('Upload response data:', data);

                    if (data.success) {
                        const imageUrl = window.location.origin + data.url;
                        quill.insertEmbed(range.index, 'image', imageUrl);
                        quill.setSelection(range.index + 1);
                        console.log('✅ Image uploaded successfully:', imageUrl);
                    } else {
                        // Show detailed error message
                        let errorMsg = data.message || 'Lỗi không xác định';
                        if (data.errors) {
                            errorMsg = Object.values(data.errors).flat().join('\n');
                        }
                        alert('❌ Upload thất bại\n\n' + errorMsg);
                    }
                } catch (error) {
                    // Remove loading text
                    quill.deleteText(range.index, '⏳ Đang upload ảnh...'.length);
                    console.error('Upload error:', error);
                    alert('❌ Lỗi kết nối\n\nChi tiết: ' + error.message + '\n\nVui lòng kiểm tra console để biết thêm.');
                }
            };
        });

        // Sync content to hidden input on form submit
        const form = document.querySelector('form');
        form.addEventListener('submit', function () {
            document.getElementById('content-input').value = quill.root.innerHTML;
        });

        // Also sync on content change (for auto-save if needed)
        quill.on('text-change', function () {
            document.getElementById('content-input').value = quill.root.innerHTML;
        });
    });
</script>

<style>
    /* Custom Quill styling */
    .ql-container {
        font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        font-size: 16px;
    }

    .ql-editor {
        min-height: 400px;
        line-height: 1.6;
    }

    .ql-editor img {
        max-width: 100%;
        height: auto;
        border-radius: 0.5rem;
        margin: 1rem auto;
        display: block;
    }

    .ql-editor p {
        margin-bottom: 1rem;
    }

    .ql-editor h1,
    .ql-editor h2,
    .ql-editor h3 {
        margin-top: 1.5rem;
        margin-bottom: 0.75rem;
        font-weight: 600;
    }

    .ql-toolbar {
        background: #f9fafb;
        border-top-left-radius: 0.5rem;
        border-top-right-radius: 0.5rem;
    }

    .ql-container {
        border-bottom-left-radius: 0.5rem;
        border-bottom-right-radius: 0.5rem;
    }
</style>