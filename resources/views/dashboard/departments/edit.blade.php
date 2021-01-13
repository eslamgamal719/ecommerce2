@extends('dashboard.index')

@section('content')
    @push('js')
        <script type="text/javascript">
            $(document).ready(function() {
                $('#jstree').jstree({
                    "core" : {
                        'data':
                           {!! load_dep($department->parent, $department->id) !!}
                        ,
                        "themes" : {
                            "variant" : "large"
                        }
                    },
                    "checkbox" : {
                        "keep_selected_style" : false
                    },
                    "plugins" : [ "wholerow" ]
                });


                $('#jstree').on('changed.jstree', function(e, data){
                     var i, j, r = [];

                     for(i=0, j= data.selected.length; i < j; i++) {
                         r.push(data.instance.get_node(data.selected[i]).id);
                     }

                     $('.parent_id').val(r.join(', '));
                });
            });
        </script>
    @endpush

    @include('dashboard.layouts.message')
    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        <div class="box-body">
            {!! Form::open(['url' => aurl('departments/' . $department->id), 'method' => 'put', 'files' => true]) !!}

                <div class="form-group">
                    {!! Form::label('dep_name_ar', __('admin.dep_name_ar')) !!}
                    {!! Form::text('dep_name_ar', $department->dep_name_ar, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('dep_name_en', __('admin.dep_name_en')) !!}
                    {!! Form::text('dep_name_en', $department->dep_name_en, ['class' => 'form-control']) !!}
                </div>

                <div class="clearfix"></div>
                <div id="jstree"></div>
                <input type="hidden" name="parent" class="parent_id" value="{{ $department->parent }}">
                <div class="clearfix"></div>

                <div class="form-group">
                    {!! Form::label('description', __('admin.description')) !!}
                    {!! Form::textarea('description',  $department->description, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('keyword', __('admin.keyword')) !!}
                    {!! Form::text('keyword',  $department->keyword, ['class' => 'form-control']) !!}
                </div>

                <div class="form-group">
                    {!! Form::label('icon', __('admin.icon')) !!}
                    {!! Form::file('icon',  ['class' => 'form-control']) !!}
                    @if(!empty($department->icon) && Storage::has($department->icon))
                        <img src="{{ Storage::url($department->icon) }}" style="width:100px; height: 100px;">
                    @endif
                </div>


            {!! Form::submit(__('admin.save'), ['class' => 'btn btn-primary']) !!}
            {!! Form::close() !!}



        </div><!-- end of body -->

    </div><!-- end of box -->


@endsection
