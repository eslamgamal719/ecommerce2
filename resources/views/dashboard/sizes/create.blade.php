@extends('dashboard.index')
@section('content')
    @push('js')

        <script>
            $(document).ready(function() {
                $('#jstree').jstree({
                    "core" : {
                        'data' : {!! load_dep(old('department_id')) !!},

                        "themes" : {
                            "variant" : "large"
                        }
                    },
                    "checkbox" : {
                        "keep_selected_style" : true
                    },
                    "plugins" : [ "wholerow" ]
                });
            });

            $('#jstree').on('changed.jstree', function(e, data){
                var i, j, r = [];
                for(i=0, j= data.selected.length; i < j; i++) {
                    r.push(data.instance.get_node(data.selected[i]).id);
                }

                if(r.join(', ') !== '') {
                    $('.department_id').val(r.join(', '));
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
            {!! Form::open(['url' => aurl('sizes')]) !!}


            <div class="form-group">
                {!! Form::label('name_ar', __('admin.name_ar')) !!}
                {!! Form::text('name_ar', old('country_name_ar'), ['class' => 'form-control']) !!}
            </div>

            <div class="form-group">
                {!! Form::label('name_en', __('admin.name_en')) !!}
                {!! Form::text('name_en', old('name_en'), ['class' => 'form-control']) !!}
            </div>

            <div id="jstree"></div>
            <input type="hidden" class="department_id" name="department_id" value="{{ old('department_id') }}">

            <div class="form-group">
                    {!! Form::label('is_public', __('admin.is_public')) !!}
                    {!! Form::select('is_public', ['yes'=>__('admin.yes'), 'no'=>__('admin.no')], old('is_public'), ['class' => 'form-control']) !!}
            </div>


            {!! Form::submit(__('admin.add'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}

        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
