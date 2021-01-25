
@push('js')
    <script>
        $(document).ready(function() {
            $('#jstree').jstree({
                "core" : {
                    'data' : {!! load_dep($product->department_id) !!},

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

            var depart_id = r.join(', ');
            $('.department_id').val(depart_id);

            $.ajax({
                url: "{{ aurl('load/weight/size') }}",
                dataType: 'html',
                type: 'post',
                data: {
                    _token: '{{csrf_token()}}',
                    dep_id: depart_id,
                    product_id: '{{$product->id}}'
                },
                success: function(data) {
                    $('.size_weight').html(data);
                    $('.info-data').removeClass('hidden');
                }
            });
        });
    </script>
@endpush

<div id="department" class="tab-pane fade">
    <h3>{{ trans('admin.department') }}</h3>

    <div id="jstree"></div>
    <input type="hidden" name="department_id" class="department_id" value="">

</div>
