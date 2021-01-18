<div id="product_info" class="tab-pane fade in active">
    <h3>{{ trans('admin.product_info') }}</h3>

    <div class="form-group">
        {!! Form::label('title', __('admin.product_title')) !!}
        {!! Form::text('title', $product->title, ['class' => 'form-control', 'placeholder' => __('admin.product_title')]) !!}
    </div>

    <div class="form-group">
        {!! Form::label('content', __('admin.product_content')) !!}
        {!! Form::textarea('content', $product->content, ['class' => 'form-control', 'placeholder' => __('admin.product_content')]) !!}
    </div>
</div>
