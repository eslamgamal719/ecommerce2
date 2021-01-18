<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Dashboard\ProductRequest;
use App\Models\Country;
use App\DataTables\ProductDatatable;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\CountryRequest;


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


    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        return view('dashboard.products.edit', ['title' => trans('admin.create_or_edit_product', ['title' => $product->title]),
            'product' => $product]);
    }


    public function upload_file($id)
    {
        if (request()->hasFile('file')) {
            $fid = up()->upload([
                'file'        => 'file',
                'path'        => 'products/' . $id,
                'upload_type' => 'files',
                'file_type'   => 'product',
                'relation_id' => $id
            ]);
            return response([
                'status' => true,
                'id' => $fid
            ], 200);
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
        $product = Product::findOrFail($id);
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = up()->upload([
                'file' => 'logo',
                'path' => 'products',
                'upload_type' => 'single',
                'delete_file' => $product->logo
            ]);
        }
        $product->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('products'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        Storage::delete($product->logo);
        $product->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('products'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {

            foreach (request('item') as $item_id) {
                $product = Country::find($item_id);
                Storage::delete($product->logo);
                $product->delete();
            }

        } else {
            $product = Country::find(request('item'));
            Storage::delete($product->logo);
            $product->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('products'));
    }
}
