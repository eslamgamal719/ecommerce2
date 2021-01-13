@extends('dashboard.index')
@section('content')

@push('js')
    <script type="text/javascript" src='https://maps.google.com/maps/api/js?sensor=false&libraries=places&key=AIzaSyC3kvorW5g6FZPuHT1_kB--2MvcsDurVo0'></script>
    <script src="{{asset('assets/admin/dist/js/locationpicker.jquery.js')}}"></script>

    <?php
        $lat = !empty(old('lat')) ? old('lat') : '31.035907125875973';
        $lng = !empty(old('lng')) ? old('lng') : '31.378643035888665';
    ?>

        <script>
        $('#us1').locationpicker({
            location: {
                latitude:  {{$lat}} ,
                longitude:  {{$lng}}
            },
            radius: 300,
            markerIcon: '{{asset('assets/admin/img/map-marker-2-xl.png')}}',
            inputBinding: {
                latitudeInput: $('#lat'),
                longitudeInput: $('#lng'),
               // radiusInput: $('#us2-radius'),
               // locationNameInput: $('#address')
            }
        });
    </script>
@endpush




    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('shippings'), 'method' => 'POST',  'files' => true]) !!}

            <input type="hidden" value="{{ $lat }}" id="lat" name="lat">
            <input type="hidden" value="{{ $lng }}" id="lng" name="lng">

                <div class="form-group">
                    {!! Form::label('name_ar', __('admin.name_ar')) !!}
                    {!! Form::text('name_ar', old('country_name_ar'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('name_en', __('admin.name_en')) !!}
                    {!! Form::text('name_en', old('name_en'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('user_id', __('admin.owner_id')) !!}
                    {!! Form::select('user_id', App\User::where('level', 'company')->pluck('name', 'id') ,old('user_id'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    <div id="us1" style="width: 100%; height: 400px;"></div>
                </div>

                <div class="form-group">
                    {!! Form::label('icon', __('admin.shipping_icon')) !!}
                    {!! Form::file('icon', ['class' => 'form-control']) !!}
                </div>


            {!! Form::submit(__('admin.add'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
