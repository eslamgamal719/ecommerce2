@extends('dashboard.index')
@section('content')





    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('products/' . $product->id)]) !!}

            <a href="#" class="btn btn-primary save">{{ trans('admin.save') }} <i class="fa fa-floppy-o"></i> </a>
            <a href="#" class="btn btn-success save_and_continue">{{ trans('admin.save_and_continue') }} <i class="fa fa-floppy-o"></i></a>
            <a href="#" class="btn btn-info copy_product">{{ trans('admin.copy_product') }} <i class="fa fa-copy"></i></a>
            <a href="#" class="btn btn-danger delete">{{ trans('admin.delete') }} <i class="fa fa-trash"></i></a>
            <hr/>

            <ul class="nav nav-tabs">
                <li class="active"><a data-toggle="tab" href="#product_info">{{ trans('admin.product_info') }} <i class="fa fa-info"></i> </a></li>
                <li><a data-toggle="tab" href="#department">{{ trans('admin.department') }} <i class="fa fa-list"></i></a></li>
                <li><a data-toggle="tab" href="#product_setting">{{ trans('admin.product_setting') }} <i class="fa fa-cog"></i></a></li>
                <li><a data-toggle="tab" href="#product_media">{{ trans('admin.product_media') }} <i class="fa fa-photo"></i></a></li>
                <li><a data-toggle="tab" href="#product_size_weight">{{ trans('admin.product_size_weight') }} <i class="fa fa-info-circle"></i></a></li>
                <li><a data-toggle="tab" href="#other_data">{{ trans('admin.other_data') }} <i class="fa fa-database"></i></a></li>
            </ul>

            <div class="tab-content">
                @include('dashboard.products.tabs.product_info')
                @include('dashboard.products.tabs.department')
                @include('dashboard.products.tabs.product_setting')
                @include('dashboard.products.tabs.product_media')
                @include('dashboard.products.tabs.product_size_weight')
                @include('dashboard.products.tabs.other_data')
            </div>
            <hr />

            <a href="#" class="btn btn-primary save">{{ trans('admin.save') }} <i class="fa fa-floppy-o"></i> </a>
            <a href="#" class="btn btn-success save_and_continue">{{ trans('admin.save_and_continue') }} <i class="fa fa-floppy-o"></i></a>
            <a href="#" class="btn btn-info copy_product">{{ trans('admin.copy_product') }} <i class="fa fa-copy"></i></a>
            <a href="#" class="btn btn-danger delete">{{ trans('admin.delete') }} <i class="fa fa-trash"></i></a>


            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
