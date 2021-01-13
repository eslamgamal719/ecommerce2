<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CountryDatatable;
use App\DataTables\MallDatatable;
use App\DataTables\ManufacturerDatatable;
use App\DataTables\TradeMarkDatatable;
use App\Http\Controllers\Controller;
use App\DataTables\AdminDatatable;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Admin;
use App\Http\Requests\Dashboard\CountryRequest;
use App\Http\Requests\Dashboard\EditAdminRequest;
use App\Http\Requests\Dashboard\MallRequest;
use App\Http\Requests\Dashboard\ManufacturerRequest;
use App\Http\Requests\Dashboard\TradeMarkRequest;
use App\Models\Country;
use App\Models\Mall;
use App\Models\Manufacturer;
use App\Models\TradeMark;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MallController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(MallDatatable $mall)
    {

        return $mall->render('dashboard.Malls.index', ['title' => __('admin.malls')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.Malls.create', ['title' => __('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(MallRequest $request)
    {
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'Malls',
                'upload_type' => 'single',
                'delete_file' => ''
            ]);
        }

        Mall::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('malls'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $mall = Mall::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.Malls.edit', compact('mall', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(MallRequest $request, $id)
    {
        $mall = Mall::findOrFail($id);
        $data = $request->except('icon');

        if ($request->hasFile('icon')) {
            $data['icon'] = up()->upload([
                'file' => 'icon',
                'path' => 'Malls',
                'upload_type' => 'single',
                'delete_file' => $mall->icon
            ]);
        }
        $mall->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('malls'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $mall = Mall::findOrFail($id);

        Storage::delete($mall->icon);
        $mall->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('Malls'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {

            foreach (request('item') as $item_id) {
                $mall = Mall::find($item_id);
                Storage::delete($mall->icon);
                $mall->delete();
            }

        } else {
            $mall = Mall::find(request('item'));
            Storage::delete($mall->icon);
            $mall->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('malls'));
    }
}
