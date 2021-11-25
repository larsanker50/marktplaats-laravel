<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Bidding;
use App\Models\Rubric;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdvertisementRequest;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        return view('advertisement/overview', [
            'advertisements' => Advertisement::orderBy('status', 'asc')->orderBy('premium', 'desc')->orderBy('created_at', 'desc')->get(),
            'rubrics' => Rubric::select(array('id', 'name'))->get()
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('advertisement/create', [
            'rubrics' => Rubric::orderBy('name')->get()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdvertisementRequest $request)
    {
        $validated = $request->validated();

        if (request('premium') === "true") {
            $premium = true;
        } else {
            $premium = false;
        }

       

        Advertisement::create([
            'user_id' => $request->session()->get('current_user_id'),
            'title' => $validated['title'],
            'body' => $validated['body'],
            'status' => 'available',
            'premium' => $premium
        ]);
        $advertisement = Advertisement::latest()->first();
        
        if ($validated['new_rubric'] !== null) {
            Rubric::firstOrCreate([
                'name' => $validated['new_rubric']
            ]);

            $new_rubric = Rubric::where('name', '=', $validated['new_rubric'])->first();
            $advertisement->rubric()->attach($new_rubric->id);
        }

        if (isset($validated['rubric'])) {
            $advertisement->rubric()->attach($validated['rubric']);
        }
        
        return redirect('advertisement/index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(advertisement $advertisement)
    {
        return view('advertisement/show', [
            'advertisement' => $advertisement,
            'biddings' => Bidding::where('advertisement_id', '=', $advertisement->id)->orderby('bidding', 'desc')->get()
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function edit(advertisement $advertisement)
    {
        return view('advertisement/edit', [
            'advertisement' => $advertisement,
            'rubrics' => Rubric::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAdvertisementRequest $request, advertisement $advertisement)
    {
        $validated = $request->validated();

        if (request('premium') === "true") {
            $premium = true;
        } else {
            $premium = false;
        }

        Advertisement::where('id', '=', $advertisement->id)->update([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'status' => $validated['status'],
            'premium' => $premium
        ]);

        if (isset($validated['rubric'])) {
            $advertisement->rubric()->sync($validated['rubric']);
        }

        if ($validated['new_rubric'] !== null) {
            Rubric::firstOrCreate([
                'name' => $validated['new_rubric']
            ]);
            $new_rubric = Rubric::where('name', '=', $validated['new_rubric'])->first();
            $advertisement->rubric()->attach($new_rubric->id);
        }

        return redirect('advertisement/index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(advertisement $advertisement, Request $request)
    {

        $advertisement->delete();
        
        return view('advertisement/personal_overview', [
            'advertisements' => Advertisement::where('user_id', '=', $request->session()->get('current_user_id'))
                ->orderBy('status', 'asc')
                ->orderBy('premium', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    public function personal_index(Request $request)
    {

        return view('advertisement/personal_overview', [
            'advertisements' => Advertisement::where('user_id', '=', $request->session()->get('current_user_id'))
                ->orderBy('status', 'asc')
                ->orderBy('premium', 'desc')
                ->orderBy('created_at', 'desc')
                ->get(),
        ]);
    }

    public function search(Request $request)
    {
        $search_regex = "(?:^|\W)$request->search(?:$|\W)";

        switch (true) {
            case ($request->search == null && $request->rubric == "all" && $request->distance == "all"):
                $advertisements = Advertisement::orderBy('status', 'asc')->orderBy('premium', 'desc')->orderBy('created_at', 'desc')->get();
                $current_rubric_name = 'all';
                break;
            case ($request->search == null && $request->distance == "all"):
                $current_rubric_name = Rubric::where('id', '=', $request->rubric)->first()->name;
                $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                    return $query->where('id', '=', $request->rubric);
                                })->orderBy('status', 'asc')
                                ->orderBy('premium', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();
                break;
            case ($request->rubric == "all" && $request->distance == "all"):
                $current_rubric_name = 'all';

                $advertisements = Advertisement::where('title', 'regexp', $search_regex)->get();

                break;
            case ($request->search == null && $request->rubric == "all"):
                $current_rubric_name = 'all';

                $advertisements = Postalcode::all()->get();

                dd($advertisement);

                break;
            case ($request->search == null):
                $current_rubric_name = Rubric::where('id', '=', $request->rubric)->first()->name;

                break;
            case ($request->rubric == "all"):
                $current_rubric_name = 'all';

                break;
            case ($request->distance == "all"):
                $current_rubric_name = Rubric::where('id', '=', $request->rubric)->first()->name;

                $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                    return $query->where('id', '=', $request->rubric);
                                })->where('title', 'regexp', $search_regex)
                                ->orderBy('status', 'asc')
                                ->orderBy('premium', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();

                break;
            default:
                dd('test mislukt');
        }

        return view('advertisement/search', [
            'advertisements' => $advertisements,
            'rubrics' => Rubric::select(array('id', 'name'))->get(),
            'current_rubric_name' => $current_rubric_name,
            'request' => $request
        ]);
    }
}
