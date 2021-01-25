@push('js')
    <script>
        $(document).ready(function () {
            var dataSelect = [
                    @foreach(App\Models\Country::all() as $country)
                {
                    "text": "{{ $country->{'country_name_' . lang()} }}",
                    "children": [
                         @foreach($country->malls as $mall)
                            {
                                "id": "{{ $mall->id }}",
                                "text": "{{ $mall->{'name_' . lang()} }}",
                                @if(check_mall($mall->id, $product->id))
                                "selected": true
                                @endif
                            },
                        @endforeach
                    ]
                },
                @endforeach
            ];

            $('.mall_select2').select2({data:dataSelect});
        });
    </script>
@endpush

<div id="product_size_weight" class="tab-pane fade">
    <h3>{{ trans('admin.shipping_info') }}</h3><br>

    <div class="size_weight">
        <div style="text-align: center;"><h3>{{ __('admin.choose_department') }}</h3></div>
    </div>

    <div class="info-data hidden">
        <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
            {!! Form::label('color_id', __('admin.color_id')) !!}
            {!! Form::select('color_id', App\Models\Color::pluck('name_'. lang(), 'id'), $product->color_id,
              ['class' => 'form-control', 'placeholder' => '................']) !!}
        </div>

        <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
            {!! Form::label('trade_id', __('admin.trade_id')) !!}
            {!! Form::select('trade_id', App\Models\TradeMark::pluck('name_'. lang(), 'id'), $product->trade_id,
              ['class' => 'form-control', 'placeholder' => '................']) !!}
        </div>

        <div class="form-group col-md-4 col-lg-4 col-sm-4 col-xs-12">
            {!! Form::label('manu_id', __('admin.manu_id')) !!}
            {!! Form::select('manu_id', App\Models\Manufacturer::pluck('name_'. lang(), 'id'), $product->manu_id,
              ['class' => 'form-control', 'placeholder' => '................']) !!}
        </div>

        <div class="form-group col-md-12 col-lg-12 col-sm-12 col-xs-12">
            {!! Form::label('mall_id', trans('admin.mall_id')) !!}
            <select class="form-control mall_select2" name="mall[]" style="width: 100%;" multiple="multiple">
            </select>
        </div>
    </div>
    <div class="clearfix"></div>
</div>
