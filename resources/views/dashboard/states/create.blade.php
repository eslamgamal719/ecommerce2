@extends('dashboard.index')

@section('content')
@push('js')
<script>

$(document).ready(function() {

        @if(old('country_id'))
            $.ajax({
                url: '{{ aurl('states/create') }}',
                type: 'get',
                dataType: 'html',
                data: {country_id:'{{ old('country_id') }}', select:'{{ old('city_id') }}'},
                success: function(data) {
                    $('.city').html(data);
                }
            });
        @endif

        $(document).on('change', '.country_id', function() {
            var country = $('.country_id option:selected').val();
            if(country > 0) {
                $.ajax({
                    url: '{{ aurl('states/create') }}',
                    type: 'get',
                    dataType: 'html',
                    data: {country_id:country, select:""},
                    success: function(data) {
                        $('.city').html(data);
                }
                });
            } else {
                $('.city').html('');
            }
        });

});

</script>
 @endpush

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            {!! Form::open(['url' => aurl('states')]) !!}

                <div class="form-group">
                    {!! Form::label('state_name_ar', __('admin.state_name_ar')) !!}
                    {!! Form::text('state_name_ar', old('state_name_ar'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('state_name_en', __('admin.state_name_en')) !!}
                    {!! Form::text('state_name_en', old('state_name_en'), ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('country_id', __('admin.country_id')) !!}
                    {!! Form::select('country_id', App\Models\Country::pluck('country_name_'. session('lang'), 'id'),
                     old('country_id'), ['class' => 'form-control country_id', 'placeholder' => '................']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('city_id', __('admin.city_id')) !!}
                    <span class="city"></span>
                </div>


            {!! Form::submit(__('admin.add'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
