<?php

namespace App\Http\Controllers\Admin;

use App\Models\Shipping;
use App\Http\Controllers\Controller;
use App\DataTables\ShippingDatatable;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\ShippingRequest;


class ShippingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ShippingDatatable $shipping)
    {

        return $shipping->render('dashboard.shippings.index', ['title' => __('admin.shippings')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.shippings.create', ['title' => __('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ShippingRequest $request)
    {
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'shippings',
                'upload_type' => 'single',
                'delete_file' => ''
            ]);
        }

        Shipping::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('shippings'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $shipping = Shipping::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.shippings.edit', compact('shipping', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ShippingRequest $request, $id)
    {
        $shipping = Shipping::findOrFail($id);
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'shippings',
                'upload_type' => 'single',
                'delete_file' => $shipping->icon
            ]);
        }
        $shipping->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('shippings'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $shipping = Shipping::findOrFail($id);

        Storage::delete($shipping->logo);
        $shipping->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('shippings'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {

            foreach (request('item') as $item_id) {
                $shipping = Shipping::find($item_id);
                Storage::delete($shipping->icon);
                $shipping->delete();
            }

        } else {
            $shipping = Shipping::find(request('item'));
            Storage::delete($shipping->icon);
            $shipping->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('shippings'));
    }
}
