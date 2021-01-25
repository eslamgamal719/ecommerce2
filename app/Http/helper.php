<?php

//give the latest change in the settings
if (!function_exists('setting')) {
    function setting($url = null)
    {
        return App\Models\Setting::orderBy('id', 'desc')->first();
    }
}


//used to return instance of Upload controller or use alias (Up::)
if (!function_exists('up')) {
    function up()
    {
        return new App\Http\Controllers\Upload;
    }
}


//Used to make inverse loop to get ids of specific department and all parent of it
if (!function_exists('get_parent')) {
    function get_parent($dep_id) {
        $department = App\Models\Department::find($dep_id);
        if($department->parent !== null && $department->parent > 0) {
            return get_parent($department->parent) . ',' . $dep_id;
        }else {
            return $dep_id;
        }
    }
}


//Used for load departments and choose the selected one
if (!function_exists('load_dep')) {
    function load_dep($select = null, $dep_hide = null)
    {
        $departments = App\Models\Department::selectRaw('dep_name_' . lang() . ' as text')
            ->selectRaw('id as id')
            ->selectRaw('parent as parent')
            ->get(['text', 'parent', 'id']);

        $dep_arr = [];
        foreach ($departments as $department) {
            $list_arr = [];
            $list_arr['icon'] = '';
            $list_arr['li_attr'] = '';
            $list_arr['a_attr'] = '';
            $list_arr['children'] = [];
            if($select !== null && $select == $department->id) {
                $list_arr['state'] = [
                    'opened'   => true,
                    'selected' => true,
                    'disabled' => false
                ];
            }
            if($dep_hide !== null && $dep_hide == $department->id) {
                $list_arr['state'] = [
                    'opened'   => false,
                    'selected' => false,
                    'disabled' => true,
                    'hidden' => true
                ];
            }
            $list_arr['id'] = $department->id;
            $list_arr['parent'] = $department->parent !== null ? $department->parent : '#';
            $list_arr['text'] = $department->text;

            array_push($dep_arr, $list_arr);
        }
        return json_encode($dep_arr, JSON_UNESCAPED_UNICODE);
    }
}


//Return Url Started with admin ('admin/*')
if (!function_exists('aurl')) {
    function aurl($url = null)
    {
        return url('admin/' . $url);
    }
}


//Return the authenticated admin
if (!function_exists('admin')) {
    function admin()
    {
        return auth()->guard('admin');
    }
}


//Make Side Menu activated for current page['index', 'create', 'edit']
if (!function_exists('active_menu')) {

    function active_menu($link)
    {
        if (preg_match('/' . $link . '/i', \Request::segment(2))) {
            return ['menu_open', 'display:block'];
        } else {
            return ['', ''];
        }
    }
}


//Check if Mall is selected for specified product
if (!function_exists('check_mall')) {
    function check_mall($mall_id, $product_id) {
        return App\Models\MallProduct::where('mall_id', $mall_id)->where('product_id', $product_id)->count() > 0 ? true : false;
    }
}



if (!function_exists('lang')) {

    function lang()
    {
        if (session()->has('lang')) {
            return session('lang');

        } elseif(isset(setting()->main_lang)) {
            session()->put(setting()->main_lang);
            return session('lang');
        }else {
            return "ar";
        }
    }
}


if (!function_exists('direction')) {

    function direction()
    {
        if (session()->has('lang')) {
            if (session('lang') == 'ar') {
                return 'rtl';
            } else {
                return 'ltr';
            }
        } else {
            return 'rtl';
        }
    }
}

if (!function_exists('datatable_lang')) {

    function datatable_lang()
    {
        return [

            'sProcessing' => __('admin.sProcessing'),
            'sLengthMenu' => __('admin.sLengthMenu'),
            'sZeroRecords' => __('admin.sZeroRecords'),
            'sEmptyTable' => __('admin.sEmptyTable'),
            'sInfo' => __('admin.sInfo'),
            'sInfoEmpty' => __('admin.sInfoEmpty'),
            'sInfoFiltered' => __('admin.sInfoFiltered'),
            'sInfoPostFix' => __('admin.sInfoPostFix'),
            'sSearch' => __('admin.sSearch'),
            'sUrl' => __('admin.sUrl'),
            'sInfoThousands' => __('admin.sInfoThousands'),
            'sLoadingRecords' => __('admin.sLoadingRecords'),
            'oPaginate' => [
                'sFirst' => __('admin.sFirst'),
                'sLast' => __('admin.sLast'),
                'sNext' => __('admin.sNext'),
                'sPrevious' => __('admin.sPrevious'),
            ],
            'oAria' => [
                'sSortAscending' => __('admin.sSortAscending'),
                'sSortDescending' => __('admin.sSortDescending'),
            ]
        ];
    }
}


if (!function_exists('validate_image')) { //Validate helper function
    function validate_image($ext = null)
    {
        if ($ext == null) {
            return 'image|mimes:jpg,jpeg,png,gif,bmp';
        } else {
            return 'image|mimes:' . $ext;
        }
    }
}



