<?php

namespace App\Http\Controllers\Admin;

use App\Models\Color;
use App\DataTables\ColorDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\ColorRequest;


class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ColorDatatable $color)
    {

        return $color->render('dashboard.colors.index', ['title' => __('admin.colors')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.colors.create', ['title' => __('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColorRequest $request)
    {
        $data = $request->all();

        Color::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('colors'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $color = Color::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.colors.edit', compact('color', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColorRequest $request, $id)
    {
        $color = Color::findOrFail($id);
        $data = $request->all();

        $color->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('colors'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $color = Color::findOrFail($id);
        $color->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('colors'));
    }


    public function multi_delete()
    {
        if(is_array(request('item'))) {
            Color::destroy(request('item'));
        }else {
            Color::find(request('item'))->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('colors'));
    }
}
