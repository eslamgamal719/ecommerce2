@extends('dashboard.index')

@section('content')

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['route' => ['admin.update', $admin->id], 'method' => 'put']) !!}

                {!! Form::hidden('id', $admin->id) !!}

                <div class="form-group">
                    {!! Form::label('name', __('admin.name')) !!}
                    {!! Form::text('name', $admin->name, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', __('admin.email')) !!}
                    {!! Form::email('email', $admin->email, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', __('admin.password')) !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

            {!! Form::submit(__('admin.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
