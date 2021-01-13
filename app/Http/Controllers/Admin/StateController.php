<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\CityDatatable;
use App\DataTables\CountryDatatable;
use App\DataTables\StateDatatable;
use App\Http\Controllers\Controller;
use App\DataTables\AdminDatatable;
use App\Http\Requests\Dashboard\AdminRequest;
use App\Admin;
use App\Http\Requests\Dashboard\CityRequest;
use App\Http\Requests\Dashboard\CountryRequest;
use App\Http\Requests\Dashboard\EditAdminRequest;
use App\Http\Requests\Dashboard\StateRequest;
use App\Models\City;
use App\Models\State;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Form;

class StateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(StateDatatable $state)
    {
        return $state->render('dashboard.states.index', ['title' => __('admin.states')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(request()->ajax()) {
            if(request()->has('country_id')) {
                $select = request('select') ? request('select') : '';
                return  Form::select('city_id', City::where('country_id', request('country_id'))->pluck('city_name_'. session('lang'), 'id'),
                   $select,  ['class' => 'form-control', 'placeholder' => '................']);
            }
        }
        return view('dashboard.states.create', ['title' => __('admin.create')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StateRequest $request)
    {
        $data = $request->all();

        State::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('states'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $state = State::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.states.edit', compact('state', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StateRequest $request, $id)
    {
        $state = State::findOrFail($id);
        $data = $request->all();

        $state->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('states'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        $state->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('states'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {
             City::destroy(request('item'));
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('states'));
    }
}
