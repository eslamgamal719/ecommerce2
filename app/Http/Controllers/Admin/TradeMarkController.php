<?php

namespace App\Http\Controllers\Admin;

use App\Models\TradeMark;
use App\Http\Controllers\Controller;
use App\DataTables\TradeMarkDatatable;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\TradeMarkRequest;


class TradeMarkController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(TradeMarkDatatable $trademark)
    {
        return $trademark->render('dashboard.trademarks.index', ['title' => __('admin.trademarks')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.trademarks.create', ['title' => __('admin.create_trademarks')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(TradeMarkRequest $request)
    {
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = up()->upload([
                'file' => 'logo',
                'path' => 'trademarks',
                'upload_type' => 'single',
                'delete_file' => ''
            ]);
        }

        TradeMark::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('trademarks'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $trademark = TradeMark::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.trademarks.edit', compact('trademark', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(TradeMarkRequest $request, $id)
    {
        $trademark = TradeMark::findOrFail($id);
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = up()->upload([
                'file' => 'logo',
                'path' => 'trademarks',
                'upload_type' => 'single',
                'delete_file' => $trademark->logo
            ]);
        }
        $trademark->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('trademarks'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $trademark = TradeMark::findOrFail($id);

        Storage::delete($trademark->logo);
        $trademark->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('trademarks'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {

            foreach (request('item') as $item_id) {
                $trademark = TradeMark::find($item_id);
                Storage::delete($trademark->logo);
                $trademark->delete();
            }

        } else {
            $trademark = TradeMark::find(request('item'));
            Storage::delete($trademark->logo);
            $trademark->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('trademarks'));
    }
}
