/**
 * Admin File Upload Handler
 * Provides drag-and-drop and click-to-upload functionality for all admin forms
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize all file upload areas
    const fileWrappers = document.querySelectorAll('.file-upload-wrapper');
    
    fileWrappers.forEach(wrapper => {
        const fileInput = wrapper.querySelector('.file-input');
        const uploadArea = wrapper.querySelector('.file-upload-area');
        const filePreview = wrapper.querySelector('.file-preview');
        
        if (!fileInput || !uploadArea) {
            return;
        }
        
        const previewImage = filePreview ? filePreview.querySelector('.preview-image') : null;
        const removeButton = filePreview ? filePreview.querySelector('.remove-file') : null;
        
        // Click to upload
        uploadArea.addEventListener('click', function(e) {
            e.preventDefault();
            fileInput.click();
        });
        
        // Handle file selection
        fileInput.addEventListener('change', function() {
            handleFileSelect(fileInput, uploadArea, filePreview, previewImage);
        });
        
        // Handle drag and drop
        uploadArea.addEventListener('dragover', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.add('dragover');
        });
        
        uploadArea.addEventListener('dragleave', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('dragover');
        });
        
        uploadArea.addEventListener('drop', function(e) {
            e.preventDefault();
            e.stopPropagation();
            uploadArea.classList.remove('dragover');
            
            const files = e.dataTransfer.files;
            if (files.length > 0) {
                // Set the file input's files property for form submission
                const dt = new DataTransfer();
                dt.items.add(files[0]);
                fileInput.files = dt.files;
                
                // Trigger the file selection handler
                handleFileSelect(fileInput, uploadArea, filePreview, previewImage);
            }
        });
        
        // Remove file
        if (removeButton) {
            removeButton.addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                fileInput.value = '';
                if (uploadArea) {
                    uploadArea.style.display = 'block';
                }
                if (filePreview) {
                    filePreview.style.display = 'none';
                    filePreview.classList.add('hidden');
                }
            });
        }
    });
});

/**
 * Handle file selection and preview
 */
function handleFileSelect(fileInput, uploadArea, filePreview, previewImage) {
    const file = fileInput.files[0];
    
    if (!file) {
        return;
    }
    
    // Show preview for images
    if (file.type.startsWith('image/') && previewImage) {
        const reader = new FileReader();
        reader.onload = function(e) {
            previewImage.src = e.target.result;
            if (uploadArea) {
                uploadArea.style.display = 'none';
            }
            if (filePreview) {
                filePreview.style.display = 'block';
                filePreview.classList.remove('hidden');
            }
        };
        reader.readAsDataURL(file);
    } else if (filePreview) {
        // For non-image files, still hide upload area and show preview area
        if (uploadArea) {
            uploadArea.style.display = 'none';
        }
        filePreview.style.display = 'block';
        filePreview.classList.remove('hidden');
    }
}
