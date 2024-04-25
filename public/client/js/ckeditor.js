ClassicEditor
    .create(document.querySelector('#editor'), {
        ckfinder: {
            uploadUrl: window.location.origin + '/admin/static/upload'
        },
    } )
    .catch(error => {
        console.error(error);
    });
