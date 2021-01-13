 @extends('dashboard.index')
@section('content')
    @push('js')




        <!-- Modal -->
        <div class="modal fade in close-window" id="delete_bootstrap_Modal" style="display: none; padding-right: 17px;">
            <div class="modal-dialog">

                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">{{ __('admin.delete') }}</h4>
                    </div>

                    {!! Form::open(['url' => '', 'method' => 'delete', 'id' => 'form_delete_department']) !!}

                    <div class="modal-body">
                        <h4>
                            {{ __('admin.ask_delete_dep') . " " }}<span id="dep_name"></span>
                        </h4>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-info" id="close" data-dismiss="modal">{{ __('admin.close') }}</button>
                        {!! Form::submit(__('admin.yes'), ['class' => 'btn btn-danger']) !!}
                    </div>

                    {!! Form::close() !!}

                </div>

            </div>
        </div>




        <script>
            $(document).ready(function() {
                $('#jstree').jstree({
                    "core" : {
                        'data' : {!! load_dep() !!},

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
                    var name = [];
                    for(i=0, j= data.selected.length; i < j; i++) {
                        r.push(data.instance.get_node(data.selected[i]).id);
                        name.push(data.instance.get_node(data.selected[i]).text);
                    }

                    $('#form_delete_department').attr('action', '{{ aurl('departments') }}/' + r.join(', '));

                    if(r.join(', ') != '') {   //beginning of making edit for departments

                        $('.show-btn-control').removeClass('hidden');
                        $('.edit-dep').attr('href', '{{ aurl('departments') }}/' + r.join(', ') + '/edit');
                        $('#dep_name').text(name.join(', '));

                    }else {

                        $('.show-btn-control').addClass('hidden');
                    }
            });
        </script>


        <script>
            delete_admin();
            close_window();
            delete_department();
        </script>
     @endpush

    <div class="box">
        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">
            <a href="" class="btn btn-info edit-dep show-btn-control hidden" ><i class="fa fa-edit"></i>{{ __('admin.edit') }}</a>
            <a href="" class="btn btn-danger delete-dep show-btn-control hidden" data-toggle="modal" data-target="delete_bootstrap_Modal"><i class="fa fa-trash"></i>{{ __('admin.delete') }}</a>
            <div id="jstree"></div>

        </div>
    </div>





@endsection
