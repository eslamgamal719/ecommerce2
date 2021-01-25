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
                        $('.dz-progress').remove();
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



            $('#mainphoto').dropzone({
                url: '{{ aurl('update/image/' . $product->id) }}',
                paramName:'file',  //or files[]
                uploadMultiple: false,
                maxFiles:1,
                maxfilessize:3, //MB
                acceptedFiles: 'image/*',
                addRemoveLinks: true,
                dictDefaultMessage: '{{__('admin.default_message')}}',
                dictRemoveFile: '{{__('admin.delete')}}',
                params: {
                    _token: '{{ csrf_token() }}'
                },
                removedfile:function(file) {
                    $.ajax({      //to remove from storage and table files
                        url: '{{ aurl('delete/product/image/' . $product->id) }}',
                        dataType: 'json',
                        type: 'post',
                        data: {
                            _token: '{{ csrf_token() }}',
                        }
                    });
                    var fmock;  // to remove from preview when click remove
                    return (fmock = file.previewElement) != null ? fmock.parentNode.removeChild(file.previewElement) : void 0;
                },
                init:function() {  //when return to product preview its main image

                    @if(!empty($product->photo))
                    var mock = {name:'{{ $product->title }}', size:'', type:''};
                    this.emit('addedfile', mock);
                    this.options.thumbnail.call(this, mock, '{{ url('storage/' . $product->photo) }}');
                    $('.dz-progress').remove();
                    @endif

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

    <style>
        .dz-image img {
            width: 100px;
            height: 100px;
        }
    </style>
@endpush

<div id="product_media" class="tab-pane fade">
    <h3>{{ trans('admin.product_media') }}</h3>

    <hr />
    <div style="text-align: center;"><h3>{{ __('admin.main_photo') }}</h3></div>
    <div class="dropzone" id="mainphoto"></div>

    <hr/>
    <div style="text-align: center;"><h3>{{ __('admin.other_photos') }}</h3></div>
    <div class="dropzone" id="dropzonefileupload"></div>
</div>
