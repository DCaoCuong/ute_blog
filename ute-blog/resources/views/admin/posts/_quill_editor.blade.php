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

                // Upload
                const formData = new FormData();
                formData.append('image', file);

                try {
                    const response = await fetch('{{ route("admin.images.upload") }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    // Remove loading text
                    quill.deleteText(range.index, '⏳ Đang upload ảnh...'.length);

                    if (data.success) {
                        const imageUrl = window.location.origin + data.url;
                        quill.insertEmbed(range.index, 'image', imageUrl);
                        quill.setSelection(range.index + 1);
                    } else {
                        alert('❌ Upload thất bại\n\n' + (data.message || 'Lỗi không xác định'));
                    }
                } catch (error) {
                    // Remove loading text
                    quill.deleteText(range.index, '⏳ Đang upload ảnh...'.length);
                    console.error('Upload error:', error);
                    alert('❌ Lỗi kết nối\n\nVui lòng kiểm tra kết nối mạng và thử lại.');
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