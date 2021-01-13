 @extends('dashboard.index')
@section('content')

    <div class="box">

        <div class="box-header">
            <h3 class="box-title">{{ $title }}</h3>
        </div>

        @include('dashboard.layouts.message')

        <div class="box-body">

            {!! Form::open(['id' => 'form_data', 'url' => aurl('cities/destroy/all'), 'method' => 'delete']) !!}

            {!! $dataTable->table([ 'class' => 'dataTable table table-striped table-hover table-bordered'], true) !!}

            {!! Form::close() !!}

        </div>
        <!-- /.card-body -->
    </div>



    <!-- Modal -->
    <div class="modal fade in alert-modal close-window" style="display: none; padding-right: 17px;">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" id="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{{ trans('admin.delete') }}</h4>
                </div>

                <div class="modal-body">
                    <div class="alert alert-danger">

                        <div class="empty_record hidden">
                            <h4>{{ trans('admin.please_check_some_records') }}</h4>
                        </div>

                        <div class="not_empty_record hidden">
                            <h4>{{ trans('admin.ask_delete_item') }}  <span class="record_count"></span> ؟ </h4>
                        </div>

                    </div>
                </div>


                <div class="modal-footer">

                    <div class="empty_record hidden">
                        <button type="button" class="btn btn-primary" id="close" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    </div>

                    <div class="not_empty_record hidden">
                        <button type="button" class="btn btn-primary" id="close" data-dismiss="modal">{{ trans('admin.no') }}</button>
                        <input type="submit" name="del_all" value="{{ trans('admin.yes') }}" class="btn btn-danger del_all">
                    </div>

                </div>
            </div>
        </div>
    </div>



@push('js')

<script>
    delete_all();
    delete_admin();
    close_window();
</script>

{!! $dataTable->scripts() !!}
@endpush

@endsection
