/**
 * Rich Editor initialization using Summernote
 */
document.addEventListener('DOMContentLoaded', function() {
    // Initialize Summernote on all textareas with the summernote-editor class
    if (typeof $ !== 'undefined' && $.fn.summernote) {
        $('.summernote-editor').each(function() {
            var $textarea = $(this);
            var placeholder = $textarea.attr('placeholder') || 'Write your content here...';
            
            $textarea.summernote({
                height: 300,
                minHeight: 200,
                maxHeight: 500,
                placeholder: placeholder,
                toolbar: [
                    ['style', ['style']],
                    ['font', ['bold', 'italic', 'underline', 'strikethrough', 'clear']],
                    ['fontsize', ['fontsize']],
                    ['color', ['color']],
                    ['para', ['ul', 'ol', 'paragraph']],
                    ['table', ['table']],
                    ['insert', ['link', 'picture', 'video']],
                    ['view', ['fullscreen', 'codeview', 'help']]
                ],
                styleTags: ['p', 'h1', 'h2', 'h3', 'h4', 'h5', 'h6'],
                fontSizes: ['8', '9', '10', '11', '12', '14', '16', '18', '24', '36'],
                callbacks: {
                    onInit: function() {
                        // Apply dark theme styling
                        var $editor = $(this).closest('.note-editor');
                        $editor.addClass('summernote-dark');
                    }
                }
            });
        });
    }
});
