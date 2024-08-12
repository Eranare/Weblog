import './bootstrap';
import ClassicEditor from '@ckeditor/ckeditor5-build-classic';

ClassicEditor
    .create(document.querySelector('#content'), {
        toolbar: [
            'heading', '|',
            'bold', 'italic', 'link', 'bulletedList', 'numberedList', 'blockQuote', '|',
            'insertTable', 'tableColumn', 'tableRow', 'mergeTableCells', '|',
            'undo', 'redo'
        ],
        ckfinder: {
            uploadUrl: uploadUrl  // Use the variable defined in the Blade template
        }
    })
    .catch(error => {
        console.error(error);
    });
