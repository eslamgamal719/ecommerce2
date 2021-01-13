@extends('dashboard.index')

@section('content')

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('trademarks/' . $trademark->id), 'method' => 'put', 'files' => true]) !!}

            <div class="form-group">
                {!! Form::label('name_ar', __('admin.name_ar')) !!}
                {!! Form::text('name_ar', $trademark->name_ar, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('name_en', __('admin.name_en')) !!}
                {!! Form::text('name_en', $trademark->name_en, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::label('logo', __('admin.country_logo')) !!}
                {!! Form::file('logo', ['class' => 'form-control']) !!}

                @if(!empty($trademark->logo))
                    <img src="{{ Storage::url($trademark->logo) }}" class="img-thumbnail" style="width: 100px; height: 100px;">
                @endif
            </div>


            {!! Form::submit(__('admin.add'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
