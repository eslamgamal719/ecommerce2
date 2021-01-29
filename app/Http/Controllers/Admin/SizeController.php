<?php

namespace App\Http\Controllers\Admin;

use App\Models\Size;
use App\DataTables\SizeDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\Dashboard\SizeRequest;


class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(SizeDatatable $size)
    {
        return $size->render('dashboard.sizes.index', ['title' => __('admin.sizes')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.sizes.create', ['title' => __('admin.add')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(SizeRequest $request)
    {
        $data = $request->all();

        Size::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('sizes'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $size = Size::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.sizes.edit', compact('size', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(SizeRequest $request, $id)
    {
        $size = Size::findOrFail($id);
        $data = $request->all();

        $size->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('sizes'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $size = Size::findOrFail($id);
        $size->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('sizes'));
    }


    public function multi_delete()
    {
        if(is_array(request('item'))) {
            Size::destroy(request('item'));
        }else {
            Size::find(request('item'))->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('sizes'));
    }
}
