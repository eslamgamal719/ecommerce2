<?php

namespace App\Http\Controllers\Admin;

use App\Models\City;
use App\DataTables\CityDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\CityRequest;


class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CityDatatable $city)
    {
        return $city->render('dashboard.cities.index', ['title' => __('admin.cities')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.cities.create', ['title' => __('admin.create')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CityRequest $request)
    {
        $data = $request->all();

        City::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('cities'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $city = City::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.cities.edit', compact('city', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CityRequest $request, $id)
    {
        $city = City::findOrFail($id);
        $data = $request->all();

        $city->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('cities'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);
        $city->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('cities'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {
             City::destroy(request('item'));
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('cities'));
    }
}
