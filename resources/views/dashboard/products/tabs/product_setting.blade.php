@push('js')

    <script>
        $('.datepicker').datepicker({
            rtl: '{{ lang() == 'ar' ? true : false }}',
            language: '{{ lang() }}',
            format: 'yyyy-mm-dd',
            autoclose: false,
            todayHighlight: true,
            todayBtn: "linked",
            clearBtn: true
        });
    </script>

    <script>
        $(document).on('change', '.status', function () {
           var status = $('.status').val();
           if(status == 'refused') {
               $('.reason').removeClass('hidden');
           }else {
               $('.reason').addClass('hidden');
           }
        });
    </script>
@endpush


<div id="product_setting" class="tab-pane fade">
    <h3>{{ trans('admin.product_setting') }}</h3>

    <div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
        {!! Form::label('price', __('admin.price')) !!}
        {!! Form::text('price', $product->price, ['class' => 'form-control', 'placeholder' => __('admin.price')]) !!}
    </div>

    <div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
        {!! Form::label('stock', __('admin.stock')) !!}
        {!! Form::text('stock', $product->stock, ['class' => 'form-control', 'placeholder' => __('admin.stock')]) !!}
    </div>

    <div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
        {!! Form::label('start_at', __('admin.start_at')) !!}
        {!! Form::text('start_at', $product->start_at, ['class' => 'form-control datepicker', 'placeholder' => __('admin.start_at')]) !!}
    </div>

    <div class="form-group col-md-3 col-lg-3 col-sm-3 col-xs-12">
        {!! Form::label('end_at', __('admin.end_at')) !!}
        {!! Form::text('end_at', $product->end_at, ['class' => 'form-control datepicker', 'placeholder' => __('admin.end_at')]) !!}
    </div>

    <div class="clearfix"></div>
    <hr />

    <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
        {!! Form::label('price_offer', __('admin.price_offer')) !!}
        {!! Form::text('price_offer', $product->price_offer, ['class' => 'form-control', 'placeholder' => __('admin.price_offer')]) !!}
    </div>

    <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
        {!! Form::label('start_offer_at', __('admin.start_offer_at')) !!}
        {!! Form::text('start_offer_at', $product->start_offer_at, ['class' => 'form-control datepicker', 'placeholder' => __('admin.start_offer_at')]) !!}
    </div>

    <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
        {!! Form::label('end_offer_at', __('admin.end_offer_at')) !!}
        {!! Form::text('end_offer_at', $product->end_offer_at, ['class' => 'form-control datepicker', 'placeholder' => __('admin.end_offer_at')]) !!}
    </div>

    <div class="clearfix"></div>
    <hr />

    <div class="form-group">
        {!! Form::label('status', __('admin.status')) !!}
        {!! Form::select('status',['pending'=>__('admin.pending'), 'refused'=>__('admin.refused'), 'active'=>__('admin.active')], $product->status, ['class' => 'form-control status', 'placeholder' => __('admin.status')]) !!}
    </div>

    <div class="form-group reason {{ $product->status != 'refused' ? 'hidden' : '' }}">
        {!! Form::label('reason', __('admin.refused_reason')) !!}
        {!! Form::textarea('reason', $product->reason, ['class' => 'form-control', 'placeholder' => __('admin.refused_reason')]) !!}
    </div>
</div>
