@push('js')
    <script type="text/javascript">
        $(document).ready(function() {
            $(document).on('click', '.do-search', function() {
                var search = $('.search').val();
                $.ajax({
                    url: '{{ aurl('products/search') }}',
                    dataType: 'json',
                    type: 'post',
                    data: {
                        _token: '{{ csrf_token() }}',
                        search: search,
                        id: '{{ $product->id }}'
                    },
                    beforeSend: function () {
                        $('.loading').removeClass('hidden');
                        $('.do-search').addClass('hidden');
                    },
                    success: function (data) {
                        if(data.status === true) {
                            $('.loading').addClass('hidden');
                            $('.do-search').removeClass('hidden');
                            if(data.count > 0) {
                                var items = '';
                                $.each(data.result, function(index, value) {
                                    items += '<li><label><input type="checkbox" name="related[]" value="'+ value.id +'"> ' + value.title + '</label></li>';
                                });
                                $('.items').html(items);
                            }
                        }
                    },
                    error: function (data) {
                    }
                });
            });
        });
    </script>
@endpush
<div id="related_product" class="tab-pane fade">
    <h3>{{ trans('admin.related_product') }}</h3>
    <div class="col-md-12 col-sm-12 col-lg-12">

        <form class="form-inline">
            <i class="fa fa-search fa-2x do-search" aria-hidden="true"></i><i class="fa fa-spin fa-spinner fa-2x loading hidden"></i>
            <input class="form-control form-control-sm search col-md-6" type="text" placeholder="search" aria-label="Search">
        </form>

        <hr/>

        <div class="col-md-12 col-lg-12">
            <ul class="items">

            </ul>

            <ul>
                @foreach($product->related()->get() as $related)
                    <li><label><input type="checkbox" checked name="related[]" value="{{ $related->related_product }}">{{ App\Models\Product::find($related->related_product)->title }}</label></li>
                @endforeach
            </ul>
        </div>

        <div class="clearfix"></div>
        <br>
    </div>
</div>
