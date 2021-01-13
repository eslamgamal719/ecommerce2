@extends('dashboard.index')

@section('content')

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('users')]) !!}

                <div class="form-group">
                    {!! Form::label('name', __('admin.name')) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', __('admin.email')) !!}
                    {!! Form::email('email', old('email'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', __('admin.password')) !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('level', __('admin.level')) !!}
                    {!! Form::select('level', ['user'=>__('admin.user'), 'vendor'=>__('admin.vendor'), 'company'=>__('admin.company')],
                     old('level'), ['class' => 'form-control', 'placeholder' => '.............']) !!}
                </div>

            {!! Form::submit(__('admin.add'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
