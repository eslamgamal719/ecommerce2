<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Country;
use App\File as FileTbl;  //to avoid conflict with File Facades
use App\DataTables\ProductDatatable;
use App\Http\Controllers\Controller;
use App\Models\MallProduct;
use App\Models\OtherData;
use App\Models\Product;
use App\Models\RelatedProduct;
use App\Models\Size;
use App\Models\Weight;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductDatatable $product)
    {
        return $product->render('dashboard.products.index', ['title' => __('admin.products')]);
    }


    public function product_search()
    {
        if (request()->ajax()) {
            $related_products = RelatedProduct::where('product_id', request('id'))->get('related_product');
            if (!empty(request('search')) && request('search') !== null) {
                $products = Product::where('title', 'LIKE', '%' . request('search') . '%')
                    ->where('id', '!=', request('id'))
                    ->whereNotIn('id', $related_products)
                    ->limit(10)
                    ->orderBy('id', 'desc')
                    ->get();
                if (!empty($products)) {
                    return response()->json([
                        'status' => true,
                        'result' => count($products) > 0 ? $products : '',
                        'count' => count($products)
                    ], 200);
                }
            }
        }
    }


    public function prepare_weight_size()
    {
        if (request()->ajax() && request()->has('dep_id')) {
            $dep_ids = explode(',', get_parent(request('dep_id')));
            $dep_list = array_diff($dep_ids, [request('dep_id')]);

            $sizes = Size::where('is_public', 'yes')->whereIn('department_id', $dep_list)
                ->orWhere('department_id', request('dep_id'))
                ->pluck('name_' . lang(), 'id');

            $weights = Weight::pluck('name_' . lang(), 'id');

            $product = Product::select('weight', 'weight_id', 'size', 'size_id')->find(request('product_id'));

            return view('dashboard.products.ajax.size_weight', ['sizes' => $sizes, 'weights' => $weights, 'product' => $product])->render();
        } else {
            return __('admin.choose_department');
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = Product::create(['title' => '']);
        if (!empty($product)) {
            return redirect(aurl('products/' . $product->id . '/edit'));
        }
    }


    public function update_product_image($id)
    {
        $product = Product::find($id);
        $product->update([
            'photo' => up()->upload([
                'file' => 'file',
                'path' => 'products/' . $id,
                'upload_type' => 'single',
                'delete_file' => $product->photo
            ])
        ]);
        return response(['status' => true], 200);
    }


    public function delete_main_image($id)
    {
        $product = Product::find($id);
        Storage::delete($product->photo);
        $product->photo = null;
        $product->save();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = up()->upload([
                'file' => 'logo',
                'path' => 'products',
                'upload_type' => 'single',
                'delete_file' => ''
            ]);
        }

        Product::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('products'));
    }


    public function copy_product($product_id)
    {
        if (request()->ajax()) {
            $copy = Product::find($product_id);
            $copy_array = $copy->toArray();
            unset($copy_array['id']);
            $new_product = Product::create($copy_array);
            if (!empty($copy_array['photo'])) {
                $ext = File::extension($copy['photo']);
                $new_path = 'products/' . $new_product->id . '/' . Str::random(30) . '.' . $ext;
                Storage::copy($copy_array['photo'], $new_path);
                $new_product->photo = $new_path;
                $new_product->save();
            }
            //copy files
            //FileTbl alias to File model to avoid confict with File Facades
            $files = FileTbl::where('file_type', 'product')->where('relation_id', $product_id)->get();
            if (!empty($files)) {
                foreach ($files as $file) {
                    $ext = File::extension($file->full_file);
                    $hashName = Str::random(30) . '.' . $ext;
                    $new_path = 'products/' . $new_product->id . '/' . $hashName;
                    Storage::copy($file->full_file, $new_path);
                    $add = FileTbl::create([
                        'name' => $file->name,
                        'size' => $file->size,
                        'file' => $hashName,
                        'path' => 'products/' . $new_product->id,
                        'full_file' => $new_path,
                        'mime_type' => $file->mime_type,
                        'file_type' => 'product',
                        'relation_id' => $new_product->id,
                    ]);
                }
            }
            //copy malls
            foreach ($copy->malls as $mall) {
                MallProduct::create([
                    'product_id' => $new_product->id,
                    'mall_id' => $mall->id
                ]);
            }
            //copy otherData
            foreach ($copy->otherData as $otherData) {
                OtherData::create([
                    'product_id' => $new_product->id,
                    'data_key' => $otherData->data_key,
                    'data_value' => $otherData->data_value,
                ]);
            }

            return response()->json([
                'status' => true,
                'id' => $new_product->id,
                'message' => trans('admin.product_copied')
            ]);
        } else {
            return redirect(aurl('/'));
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.products.product', ['title' => trans('admin.create_or_edit_product', ['title' => $product->title]),
            'product' => $product]);
    }


    public function upload_file($id)
    {
        if (request()->hasFile('file')) {
            $fid = up()->upload([
                'file' => 'file',
                'path' => 'products/' . $id,
                'upload_type' => 'files',
                'file_type' => 'product',
                'relation_id' => $id
            ]);
            return response(['status' => true, 'id' => $fid], 200);
        }
    }


    public function delete_file()
    {
        if (request()->has('id')) {
            up()->delete(request('id'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, $id)
    {

        if ($request->has('mall')) {
            MallProduct::where('product_id', $id)->delete();
            foreach ($request->mall as $mall) {
                MallProduct::create([
                    'product_id' => $id,
                    'mall_id' => $mall
                ]);
            }
        }
        if($request->has('related')) {
            RelatedProduct::where('product_id', $id)->delete();
            foreach($request->related as $related) {
                RelatedProduct::create([
                    'product_id' => $id,
                    'related_product' => $related
                ]);
            }
        }
        $i = 0;
        if ($request->has('input_key') && $request->has('input_value')) {
            OtherData::where('product_id', $id)->delete();
            foreach (request()->input_key as $key) {
                $data_value = !empty($request->input_value[$i]) ? $request->input_value[$i] : '';
                OtherData::create([
                    'product_id' => $id,
                    'data_key' => $key,
                    'data_value' => $data_value
                ]);
                $i++;
            }
        }
        $data = $request->except(['photo', 'input_key', 'input_value', '_method', '_token', 'mall', 'related']);
        Product::whereId($id)->update($data);
        return response()->json(['status' => true, 'message' => __('admin.record_updated')], 200);
    }

    public function deleteProduct($id)
    {
        $product = Product::find($id);
        Storage::delete($product->photo);
        up()->delete_files($product->id);
        $product->delete();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->deleteProduct($id);
        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('products'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {
            foreach (request('item') as $item_id) {
                $this->deleteProduct($item_id);
            }
        } else {
            $this->deleteProduct(request('item'));
        }
        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('products'));
    }
}
