@extends('dashboard.index')

@section('content')

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('countries'),  'files' => true]) !!}

                <div class="form-group">
                    {!! Form::label('country_name_ar', __('admin.country_name_ar')) !!}
                    {!! Form::text('country_name_ar', old('country_name_ar'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('country_name_en', __('admin.country_name_en')) !!}
                    {!! Form::text('country_name_en', old('country_name_en'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('code', __('admin.code')) !!}
                    {!! Form::text('code', old('code'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('mob', __('admin.mob')) !!}
                    {!! Form::text('mob', old('mob'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('currency', __('admin.currency')) !!}
                    {!! Form::text('currency', old('currency'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('logo', __('admin.country_logo')) !!}
                    {!! Form::file('logo', ['class' => 'form-control']) !!}
                </div>


            {!! Form::submit(__('admin.add'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
