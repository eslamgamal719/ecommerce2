@extends('dashboard.index')

@section('content')

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['route' => ['users.update', $user->id], 'method' => 'put']) !!}

                {!! Form::hidden('id', $user->id) !!}

                <div class="form-group">
                    {!! Form::label('name', __('admin.name')) !!}
                    {!! Form::text('name', $user->name, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('email', __('admin.email')) !!}
                    {!! Form::email('email', $user->email, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('password', __('admin.password')) !!}
                    {!! Form::password('password', ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('level', __('admin.level')) !!}
                    {!! Form::select('level', ['user'=>__('admin.user'), 'vendor'=>__('admin.vendor'), 'company'=>__('admin.company')],
                     $user->level, ['class' => 'form-control', 'placeholder' => '.............']) !!}
                </div>

            {!! Form::submit(__('admin.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
