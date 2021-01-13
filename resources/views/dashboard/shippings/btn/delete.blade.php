
<!-- Trigger the modal with a button -->
<button type="button" class="btn btn-danger custom_delete" data-toggle="modal" data-item-id="{{$id}}" ><i class="fa fa-trash"></i></button>


<!-- Modal -->
<div class="modal fade in close-window" id="del_admin{{$id}}" style="display: none; padding-right: 17px;">
    <div class="modal-dialog">

        <div class="modal-content">

            <div class="modal-header">
                <button type="button" id="close" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">{{ __('admin.delete') }}</h4>
            </div>

            {!! Form::open(['route' => ['shippings.destroy', $id], 'method' => 'delete']) !!}

            <div class="modal-body">
                <h4>{{ __('admin.delete_this', ['name' => session(lang()) == 'ar' ? $name_ar : $name_en ]) }}</h4>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-info" id="close" data-dismiss="modal">{{ __('admin.close') }}</button>
                {!! Form::submit(__('admin.yes'), ['class' => 'btn btn-danger']) !!}
            </div>

            {!! Form::close() !!}

        </div>

    </div>
</div>



