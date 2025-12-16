<!-- Image Gallery Manager Component -->
<div x-data="imageGallery()" class="bg-white rounded-xl shadow-sm border border-gray-200 p-8 mb-6">
    <div class="flex items-center justify-between mb-6 pb-4 border-b border-gray-200">
        <div class="flex items-center">
            <div class="w-10 h-10 bg-pink-50 rounded-lg flex items-center justify-center mr-3">
                <svg class="w-6 h-6 text-pink-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                    </path>
                </svg>
            </div>
            <div>
                <h3 class="text-lg font-semibold text-gray-900">Thư viện ảnh</h3>
                <p class="text-xs text-gray-500">Upload và quản lý hình ảnh cho bài viết</p>
            </div>
        </div>
        <button type="button" @click="$refs.fileInput.click()"
            class="px-4 py-2 bg-pink-600 text-white rounded-lg hover:bg-pink-700 transition text-sm flex items-center">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Upload ảnh
        </button>
        <input type="file" x-ref="fileInput" @change="uploadImage" accept="image/*" class="hidden">
    </div>

    <!-- Upload Progress -->
    <div x-show="uploading" class="mb-4">
        <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
            <div class="flex items-center">
                <svg class="animate-spin h-5 w-5 text-blue-600 mr-3" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                    </path>
                </svg>
                <span class="text-sm text-blue-700">Đang upload...</span>
            </div>
        </div>
    </div>

    <!-- Error Message -->
    <div x-show="error" x-text="error"
        class="mb-4 bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-lg text-sm"></div>

    <!-- Images Grid -->
    <div x-show="images.length > 0" class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-4">
        <template x-for="(image, index) in images" :key="index">
            <div class="relative group">
                <img :src="image.url" :alt="image.filename"
                    class="w-full h-32 object-cover rounded-lg border border-gray-200">
                <div
                    class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-50 transition rounded-lg flex items-center justify-center opacity-0 group-hover:opacity-100">
                    <button type="button" @click="copyImageUrl(image.url)"
                        class="p-2 bg-white text-gray-700 rounded-lg hover:bg-gray-100 mr-2" title="Copy URL">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </button>
                    <button type="button" @click="insertImageToContent(image.url)"
                        class="p-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 mr-2" title="Chèn vào nội dung">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                    </button>
                    <button type="button" @click="removeImage(index)"
                        class="p-2 bg-red-600 text-white rounded-lg hover:bg-red-700" title="Xóa">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                            </path>
                        </svg>
                    </button>
                </div>
            </div>
        </template>
    </div>

    <!-- Empty State -->
    <div x-show="images.length === 0" class="text-center py-12 border-2 border-dashed border-gray-300 rounded-lg">
        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
            </path>
        </svg>
        <p class="text-gray-500 mb-2">Chưa có hình ảnh nào</p>
        <p class="text-sm text-gray-400">Click "Upload ảnh" để thêm hình ảnh</p>
    </div>

    <!-- Hidden input to store images JSON -->
    <input type="hidden" name="images" :value="JSON.stringify(images)">
</div>

<script>
    function imageGallery() {
        return {
            images: @json($post->images ?? []),
            uploading: false,
            error: null,

            async uploadImage(event) {
                const file = event.target.files[0];
                if (!file) return;

                // Validate file type
                if (!file.type.startsWith('image/')) {
                    this.error = 'Vui lòng chọn file hình ảnh';
                    return;
                }

                // Validate file size (5MB)
                if (file.size > 5 * 1024 * 1024) {
                    this.error = 'Kích thước file không được vượt quá 5MB';
                    return;
                }

                this.uploading = true;
                this.error = null;

                const formData = new FormData();
                formData.append('image', file);

                try {
                    const response = await fetch('{{ route('admin.images.upload') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        this.images.push({
                            url: data.url,
                            filename: data.filename,
                            path: data.path
                        });
                        event.target.value = ''; // Reset input
                    } else {
                        this.error = data.message || 'Upload thất bại';
                    }
                } catch (err) {
                    this.error = 'Lỗi kết nối. Vui lòng thử lại.';
                    console.error(err);
                } finally {
                    this.uploading = false;
                }
            },

            removeImage(index) {
                if (confirm('Bạn có chắc muốn xóa ảnh này?')) {
                    this.images.splice(index, 1);
                }
            },

            copyImageUrl(url) {
                const fullUrl = window.location.origin + url;
                navigator.clipboard.writeText(fullUrl).then(() => {
                    alert('Đã copy URL: ' + fullUrl);
                });
            },

            insertImageToContent(url) {
                const contentTextarea = document.getElementById('content');
                const imageTag = `\n<img src="${url}" alt="Image" class="w-full rounded-lg my-4">\n`;

                const cursorPos = contentTextarea.selectionStart;
                const textBefore = contentTextarea.value.substring(0, cursorPos);
                const textAfter = contentTextarea.value.substring(cursorPos);

                contentTextarea.value = textBefore + imageTag + textAfter;
                contentTextarea.focus();
                contentTextarea.selectionStart = contentTextarea.selectionEnd = cursorPos + imageTag.length;

                alert('Đã chèn ảnh vào nội dung!');
            }
        }
    }
</script>