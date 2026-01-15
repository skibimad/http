/**
 * Modern File Uploader Component
 */
class FileUploader {
    constructor(inputId, options = {}) {
        this.input = document.getElementById(inputId);
        if (!this.input) {
            console.error(`Input element with id "${inputId}" not found`);
            return;
        }
        
        this.options = {
            category: options.category || 'general',
            accept: options.accept || 'image/*,video/*',
            maxSize: options.maxSize || 10485760, // 10MB
            uploadUrl: options.uploadUrl || '/api/upload',
            onSuccess: options.onSuccess || (() => {}),
            onError: options.onError || ((error) => console.error(error)),
            onProgress: options.onProgress || (() => {})
        };
        
        this.init();
    }
    
    init() {
        // Create file upload UI
        const container = document.createElement('div');
        container.className = 'file-uploader';
        container.innerHTML = `
            <div class="file-uploader-drop-zone" id="drop-zone-${this.input.id}">
                <div class="file-uploader-icon">📁</div>
                <div class="file-uploader-text">
                    <strong>Click to upload</strong> or drag and drop
                </div>
                <div class="file-uploader-hint">Maximum file size: 10MB</div>
            </div>
            <div class="file-uploader-preview" id="preview-${this.input.id}" style="display: none;">
                <img class="file-uploader-preview-img" alt="Preview">
                <div class="file-uploader-preview-info">
                    <div class="file-uploader-filename"></div>
                    <button type="button" class="file-uploader-remove">Remove</button>
                </div>
            </div>
            <div class="file-uploader-progress" id="progress-${this.input.id}" style="display: none;">
                <div class="file-uploader-progress-bar"></div>
                <div class="file-uploader-progress-text">0%</div>
            </div>
        `;
        
        // Insert after the input field
        this.input.style.display = 'none';
        this.input.parentNode.insertBefore(container, this.input.nextSibling);
        
        // Get elements
        this.dropZone = document.getElementById(`drop-zone-${this.input.id}`);
        this.preview = document.getElementById(`preview-${this.input.id}`);
        this.progress = document.getElementById(`progress-${this.input.id}`);
        
        // Bind events
        this.bindEvents();
    }
    
    bindEvents() {
        // Click to upload
        this.dropZone.addEventListener('click', () => {
            const fileInput = document.createElement('input');
            fileInput.type = 'file';
            fileInput.accept = this.options.accept;
            fileInput.onchange = (e) => this.handleFileSelect(e.target.files[0]);
            fileInput.click();
        });
        
        // Drag and drop
        this.dropZone.addEventListener('dragover', (e) => {
            e.preventDefault();
            this.dropZone.classList.add('drag-over');
        });
        
        this.dropZone.addEventListener('dragleave', () => {
            this.dropZone.classList.remove('drag-over');
        });
        
        this.dropZone.addEventListener('drop', (e) => {
            e.preventDefault();
            this.dropZone.classList.remove('drag-over');
            const file = e.dataTransfer.files[0];
            if (file) {
                this.handleFileSelect(file);
            }
        });
        
        // Remove button
        const removeBtn = this.preview.querySelector('.file-uploader-remove');
        removeBtn.addEventListener('click', () => this.removeFile());
    }
    
    handleFileSelect(file) {
        if (!file) return;
        
        // Validate file size
        if (file.size > this.options.maxSize) {
            this.options.onError('File size exceeds maximum allowed size (10MB)');
            return;
        }
        
        // Show preview for images
        if (file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = (e) => {
                this.showPreview(e.target.result, file.name);
            };
            reader.readAsDataURL(file);
        } else {
            this.showPreview(null, file.name);
        }
        
        // Upload file
        this.uploadFile(file);
    }
    
    showPreview(imageSrc, filename) {
        this.dropZone.style.display = 'none';
        this.preview.style.display = 'flex';
        
        const img = this.preview.querySelector('.file-uploader-preview-img');
        const filenameEl = this.preview.querySelector('.file-uploader-filename');
        
        if (imageSrc) {
            img.src = imageSrc;
            img.style.display = 'block';
        } else {
            img.style.display = 'none';
        }
        
        filenameEl.textContent = filename;
    }
    
    uploadFile(file) {
        const formData = new FormData();
        formData.append('file', file);
        formData.append('category', this.options.category);
        
        const xhr = new XMLHttpRequest();
        
        // Progress handler
        xhr.upload.addEventListener('progress', (e) => {
            if (e.lengthComputable) {
                const percentComplete = (e.loaded / e.total) * 100;
                this.updateProgress(percentComplete);
                this.options.onProgress(percentComplete);
            }
        });
        
        // Success handler
        xhr.addEventListener('load', () => {
            this.progress.style.display = 'none';
            
            if (xhr.status === 200) {
                const response = JSON.parse(xhr.responseText);
                if (response.success) {
                    this.input.value = response.path;
                    this.options.onSuccess(response);
                } else {
                    this.options.onError(response.error || 'Upload failed');
                    this.removeFile();
                }
            } else {
                this.options.onError('Upload failed with status: ' + xhr.status);
                this.removeFile();
            }
        });
        
        // Error handler
        xhr.addEventListener('error', () => {
            this.progress.style.display = 'none';
            this.options.onError('Upload failed');
            this.removeFile();
        });
        
        // Show progress
        this.progress.style.display = 'block';
        
        // Send request
        xhr.open('POST', this.options.uploadUrl);
        xhr.send(formData);
    }
    
    updateProgress(percent) {
        const progressBar = this.progress.querySelector('.file-uploader-progress-bar');
        const progressText = this.progress.querySelector('.file-uploader-progress-text');
        
        progressBar.style.width = percent + '%';
        progressText.textContent = Math.round(percent) + '%';
    }
    
    removeFile() {
        this.input.value = '';
        this.dropZone.style.display = 'flex';
        this.preview.style.display = 'none';
        this.progress.style.display = 'none';
    }
}
