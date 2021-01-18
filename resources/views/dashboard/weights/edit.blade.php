@extends('dashboard.index')
@section('content')


    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('weights/' . $weight->id), 'method' => 'put']) !!}

            <div class="form-group">
                {!! Form::label('name_ar', __('admin.name_ar')) !!}
                {!! Form::text('name_ar', $weight->name_ar, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('name_en', __('admin.name_en')) !!}
                {!! Form::text('name_en', $weight->name_en, ['class' => 'form-control']) !!}
            </div>

            {!! Form::submit(__('admin.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
