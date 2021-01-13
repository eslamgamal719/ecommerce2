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
                    locationNameInput: $('#address')
                },
                enableAutocomplete: true
            });
        </script>
    @endpush



    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('malls/' . $mall->id), 'method' => 'put', 'files' => true]) !!}

            <input type="hidden" value="{{ $lat }}" id="lat" name="lat">
            <input type="hidden" value="{{ $lng }}" id="lng" name="lng">

            <div class="form-group">
                {!! Form::label('name_ar', __('admin.name_ar')) !!}
                {!! Form::text('name_ar', $mall->name_ar, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('name_en', __('admin.name_en')) !!}
                {!! Form::text('name_en', $mall->name_en, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('contact_name', __('admin.contact_name')) !!}
                {!! Form::text('contact_name', $mall->contact_name, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('mobile', __('admin.mobile')) !!}
                {!! Form::text('mobile', $mall->mobile, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">  <!-- getting it automatically like lat and lng if key is activated -->
                {!! Form::label('address', __('admin.address')) !!}
                {!! Form::text('address', $mall->address, ['class' => 'form-control address', 'id'=>"address"]) !!}
            </div>

            <div class="form-group">
                {!! Form::label('country_id', __('admin.country_id')) !!}
                {!! Form::select('country_id', App\Models\Country::pluck('country_name_'. lang(), 'id'), $mall->country_id, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                <div id="us1" style="width: 100%; height: 400px;"></div>
            </div>

            <div class="form-group">
                {!! Form::label('email', __('admin.email')) !!}
                {!! Form::email('email', $mall->email, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('facebook', __('admin.facebook')) !!}
                {!! Form::text('facebook', $mall->facebook, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('twitter', __('admin.twitter')) !!}
                {!! Form::text('twitter', $mall->twitter, ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('website', __('admin.website')) !!}
                {!! Form::text('website', $mall->website, ['class' => 'form-control']) !!}
            </div>


            <div class="form-group">
                {!! Form::label('icon', __('admin.mall_icon')) !!}
                {!! Form::file('icon', ['class' => 'form-control']) !!}

                @if(!empty($mall->icon))
                    <img src="{{ Storage::url($mall->icon) }}" class="img-thumbnail" style="width: 100px; height: 100px;">
                @endif
            </div>


            {!! Form::submit(__('admin.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}


        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
