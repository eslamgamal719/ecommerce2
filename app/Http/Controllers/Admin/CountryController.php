<?php

namespace App\Http\Controllers\Admin;

use App\Models\Country;
use App\DataTables\CountryDatatable;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\Dashboard\CountryRequest;


class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CountryDatatable $country)
    {

        return $country->render('dashboard.countries.index', ['title' => __('admin.countries')]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('dashboard.countries.create', ['title' => __('admin.create_countries')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(CountryRequest $request)
    {
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = up()->upload([
                'file' => 'logo',
                'path' => 'countries',
                'upload_type' => 'single',
                'delete_file' => ''
            ]);
        }

        Country::create($data);

        session()->flash('success', __('admin.record_added'));
        return redirect(aurl('countries'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $country = Country::findOrFail($id);
        $title = __('admin.edit');
        return view('dashboard.countries.edit', compact('country', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(CountryRequest $request, $id)
    {
        $country = Country::findOrFail($id);
        $data = $request->except('logo');

        if ($request->hasFile('logo')) {
            $data['logo'] = up()->upload([
                'file' => 'logo',
                'path' => 'countries',
                'upload_type' => 'single',
                'delete_file' => $country->logo
            ]);
        }
        $country->update($data);

        session()->flash('success', __('admin.record_updated'));
        return redirect(aurl('countries'));

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);

        Storage::delete($country->logo);
        $country->delete();

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('countries'));
    }


    public function multi_delete()
    {
        if (is_array(request('item'))) {

            foreach (request('item') as $item_id) {
                $country = Country::find($item_id);
                Storage::delete($country->logo);
                $country->delete();
            }

        } else {
            $country = Country::find(request('item'));
            Storage::delete($country->logo);
            $country->delete();
        }

        session()->flash('success', __('admin.record_deleted'));
        return redirect(aurl('countries'));
    }
}
