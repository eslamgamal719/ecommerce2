@push('js')
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.7.2/min/dropzone.min.css">

    <script>
        Dropzone.autoDiscover = false;
        $(document).ready(function() {

            $('#dropzonefileupload').dropzone({
                url: '{{ aurl('upload/image/' . $product->id) }}',
                paramName:'file',  //or files[]
                uploadMultiple: false,
                maxFiles:15,
                maxfilessize:3, //MB
                acceptedFiles: 'image/*',
                dictDefaultMessage: '{{__('admin.default_message')}}',
                dictRemoveFile: '{{__('admin.delete')}}',
                params: {
                    _token: '{{ csrf_token() }}'
                },
                removedfile:function(file) {
                    $.ajax({      //to remove from storage and table files
                        url: '{{ aurl('delete/image') }}',
                        dataType: 'json',
                        type: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                            id: file.fid  //make sure fid added in mock below
                        }
                    });
                    var fmock;  // to remove from preview when click remove
                    return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement) : void 0;
                },
                addRemoveLinks: true,
                init:function() {  //when return to product preview all its images
                    @foreach($product->files()->get() as $file)
                        var mock = {name:'{{ $file->name }}', fid:'{{ $file->id }}', size:'{{ $file->size }}', type:'{{ $file->mime_type }}'};
                        this.emit('addedfile', mock);
                        this.options.thumbnail.call(this, mock, '{{ url('storage/' . $file->full_file) }}');
                    @endforeach

                    this.on('sending', function(file, xhr, formData) {
                        formData.append('fid', '');
                        file.fid = '';
                    });

                    this.on('success', function(file, response) {
                        file.fid = response.id;
                    });
                }
            });
        });
    </script>
@endpush

<div id="product_media" class="tab-pane fade">
    <h3>{{ trans('admin.product_media') }}</h3>
    <div class="dropzone" id="dropzonefileupload"></div>
</div>
