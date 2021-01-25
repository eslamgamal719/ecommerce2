@extends('dashboard.index')
@section('content')
    @push('js')
        <script type="text/javascript">
            $(document).ready(function () {
                $(document).on('click', '.copy_product', function(e) {
                    e.preventDefault();
                    $.ajax({
                        url: '{{ aurl('products/copy/' . $product->id) }}',
                        dataType: 'json',
                        type: 'post',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        beforeSend: function () {
                            $('.loading_copy').removeClass('hidden');
                            $('.validation_errors').html('');
                            $('.error_message').addClass('hidden');
                            $('.success_message').html('').addClass('hidden');
                        }, success: function (data) {
                            if (data.status === true) {
                                $('.loading_copy').addClass('hidden');
                                $('.success_message').html('<h4>' + data.message + '</h4>').removeClass('hidden');
                                setTimeout(function() {
                                   window.location.href = '{{ aurl('products') }}/' + data.id + '/edit';
                                }, 5000)
                            }
                        }, error() {
                        }
                    });
                });


                $(document).on('click', '.save_and_continue', function (e) {
                    e.preventDefault();
                    var form_data = $('#product_form').serialize();
                    $.ajax({
                        url: '{{ aurl('products/' . $product->id) }}',
                        dataType: 'json',
                        type: 'post',
                        data: form_data,
                        beforeSend: function () {
                            $('.loading_save').removeClass('hidden');
                            $('.validation_errors').html('');
                            $('.error_message').addClass('hidden');
                            $('.success_message').html('').addClass('hidden');
                        }, success: function (data) {
                            if (data.status === true) {
                                $('.loading_save').addClass('hidden');
                                $('.success_message').html('<h4>' + data.message + '</h4>').removeClass('hidden');
                            }
                        }, error(response) {
                            $('.loading_save').addClass('hidden');
                            var li_errors = '';
                            $.each(response.responseJSON.errors, function (index, value) {
                                li_errors += '<li>' + value + '</li>';
                            });
                            $('.validation_errors').html(li_errors);
                            $('.error_message').removeClass('hidden');
                        }
                    });
                });
            });

        </script>
        <script>
            delete_admin();
            close_window();
        </script>
    @endpush




    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => '#', 'method' => 'put', 'files' => true, 'id' => 'product_form']) !!}

            <a href="#" class="btn btn-primary save">{{ trans('admin.save') }} <i class="fa fa-floppy-o"></i> </a>
            <a href="#" class="btn btn-success save_and_continue">{{ trans('admin.save_and_continue') }}
                <i class="fa fa-floppy-o"></i> <i class="fa fa-spin fa-spinner loading_save hidden"></i></a>
            <a href="#" class="btn btn-info copy_product">{{ trans('admin.copy_product') }} <i
                    class="fa fa-copy"></i> <i class="fa fa-spin fa-spinner loading_copy hidden"></i></a>
            <button type="button" class="btn btn-danger custom_delete" data-toggle="modal"
                    data-item-id="{{$product->id}}">{{ trans('admin.delete') }} <i class="fa fa-trash"></i></button>
            <hr/>
            <div class="alert alert-danger error_message hidden">
                <ul class="validation_errors">
                </ul>
            </div>
            <div class="alert alert-success success_message hidden"></div>
            <hr/>

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#product_info">{{ trans('admin.product_info') }}
                        <i class="fa fa-info"></i> </a></li>
                <li><a data-toggle="tab" href="#department">{{ trans('admin.department') }}
                        <i class="fa fa-list"></i></a></li>
                <li><a data-toggle="tab" href="#product_setting">{{ trans('admin.product_setting') }}
                        <i class="fa fa-cog"></i></a></li>
                <li><a data-toggle="tab" href="#product_media">{{ trans('admin.product_media') }}
                        <i class="fa fa-photo"></i></a></li>
                <li><a data-toggle="tab" href="#product_size_weight">{{ trans('admin.shipping_info') }}
                        <i class="fa fa-info-circle"></i></a></li>
                <li><a data-toggle="tab" href="#other_data">{{ trans('admin.other_data') }}
                        <i class="fa fa-database"></i></a></li>
                <li><a data-toggle="tab" href="#related_product">{{ trans('admin.related_product') }}
                        <i class="fa fa-list"></i></a></li>
            </ul>

            <div class="tab-content">
                @include('dashboard.products.tabs.product_info')
                @include('dashboard.products.tabs.department')
                @include('dashboard.products.tabs.product_setting')
                @include('dashboard.products.tabs.product_media')
                @include('dashboard.products.tabs.shipping_info')
                @include('dashboard.products.tabs.other_data')
                @include('dashboard.products.tabs.related_product')
            </div>
            <hr/>

            <a href="#" class="btn btn-primary save">{{ trans('admin.save') }} <i class="fa fa-floppy-o"></i> </a>
            <a href="#" class="btn btn-success save_and_continue">{{ trans('admin.save_and_continue') }} <i
                    class="fa fa-floppy-o"></i> <i class="fa fa-spin fa-spinner loading_save hidden"></i></a>
            <a href="#" class="btn btn-info copy_product">{{ trans('admin.copy_product') }} <i
                    class="fa fa-copy"></i> <i class="fa fa-spin fa-spinner loading_copy hidden"></i></a>
            <button type="button" class="btn btn-danger custom_delete" data-toggle="modal"
                    data-item-id="{{$product->id}}">{{ trans('admin.delete') }} <i class="fa fa-trash"></i></button>


            {!! Form::close() !!}
        </div><!-- end of body -->
    </div><!-- end of box -->


    <!-- Modal -->
    <div class="modal fade in close-window" id="del_admin{{$product->id}}" style="display: none; padding-right: 17px;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ __('admin.delete') }}</h4>
                </div>

                {!! Form::open(['route' => ['products.destroy', $product->id], 'method' => 'delete']) !!}

                <div class="modal-body">
                    <h4>{{ __('admin.delete_this', ['name' => $product->title ]) }}</h4>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="close"
                            data-dismiss="modal">{{ __('admin.close') }}</button>
                    {!! Form::submit(__('admin.yes'), ['class' => 'btn btn-danger']) !!}
                </div>
                {!! Form::close() !!}
            </div>
        </div>
    </div>

@endsection
@push('js')

    <script>

    </script>
@endpush
