@extends('dashboard.index')

@section('content')

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('cities/' . $city->id), 'method' => 'put']) !!}

            <div class="form-group">
                {!! Form::label('city_name_ar', __('admin.city_name_ar')) !!}
                {!! Form::text('city_name_ar', $city->city_name_ar, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('city_name_en', __('admin.city_name_en')) !!}
                {!! Form::text('city_name_en', $city->city_name_en, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('country_id', __('admin.country_id')) !!}
                {!! Form::select('country_id', App\Models\Country::pluck('country_name_' . session('lang'), 'id'), $city->country_id, ['class' => 'form-control']) !!}
            </div>

            {!! Form::submit(__('admin.add'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
