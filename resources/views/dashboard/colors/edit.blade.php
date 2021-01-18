@extends('dashboard.index')
@section('content')


    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('colors/' . $color->id), 'method' => 'put']) !!}

            <div class="form-group">
                {!! Form::label('name_ar', __('admin.name_ar')) !!}
                {!! Form::text('name_ar', $color->name_ar, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('name_en', __('admin.name_en')) !!}
                {!! Form::text('name_en', $color->name_en, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('color', __('admin.color')) !!}
                {!! Form::color('color', $color->color, ['class' => 'form-control']) !!}
            </div>


            {!! Form::submit(__('admin.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
