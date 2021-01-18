<?php

namespace App\Http\Controllers\Admin;

use App\Models\Weight;
use App\DataTables\WeightDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\WeightRequest;


class WeightController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(WeightDatatable $weight)
    {

        return $weight->render('dashboard.weights.index', ['title' => __('admin.weights')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.weights.create', ['title' => __('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(WeightRequest $request)
    {
        $data = $request->all();

        Weight::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('weights'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $weight = Weight::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.weights.edit', compact('weight', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(WeightRequest $request, $id)
    {
        $weight = Weight::findOrFail($id);
        $data = $request->all();

        $weight->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('weights'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $weight = Weight::findOrFail($id);
        $weight->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('weights'));
    }


    public function multi_delete()
    {
        if(is_array(request('item'))) {
            Weight::destroy(request('item'));
        }else {
            Weight::find(request('item'))->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('weights'));
    }
}
