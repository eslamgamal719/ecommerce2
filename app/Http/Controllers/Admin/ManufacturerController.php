<?php

namespace App\Http\Controllers\Admin;

use App\Models\Manufacturer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\DataTables\ManufacturerDatatable;
use App\Http\Requests\Dashboard\ManufacturerRequest;


class ManufacturerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ManufacturerDatatable $manufacturer)
    {
        return $manufacturer->render('dashboard.manufacturers.index', ['title' => __('admin.manufacturers')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.manufacturers.create', ['title' => __('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ManufacturerRequest $request)
    {
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'manufacturers',
                'upload_type' => 'single',
                'delete_file' => ''
            ]);
        }

        Manufacturer::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('manufacturers'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.manufacturers.edit', compact('manufacturer', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ManufacturerRequest $request, $id)
    {
        $manufacturer = Manufacturer::findOrFail($id);
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'manufacturers',
                'upload_type' => 'single',
                'delete_file' => $manufacturer->icon
            ]);
        }
        $manufacturer->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('manufacturers'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $manufacturer = Manufacturer::findOrFail($id);

        Storage::delete($manufacturer->logo);
        $manufacturer->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('manufacturers'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {

            foreach (request('item') as $item_id) {
                $manufacturer = Manufacturer::find($item_id);
                Storage::delete($manufacturer->icon);
                $manufacturer->delete();
            }

        } else {
            $manufacturer = Manufacturer::find(request('item'));
            Storage::delete($manufacturer->icon);
            $manufacturer->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('manufacturers'));
    }
}
