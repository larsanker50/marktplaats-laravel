<?php

namespace App\Http\Controllers;

use App\Models\Advertisement;
use App\Models\Bidding;
use App\Models\Postalcode;
use App\Models\User;
use App\Models\Rubric;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAdvertisementRequest;
use Illuminate\Support\Collection;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, $page_number)
    {

        $skip = $page_number * 10 - 10;
        $advertisements = Advertisement::orderBy('status', 'asc')
                                            ->orderBy('premium', 'desc')
                                            ->orderBy('created_at', 'desc')
                                            ->skip($skip)
                                            ->take(10)
                                            ->get();
        return view('advertisement/overview', [
            'advertisements' => $advertisements,
            'all_advertisements' => $all_advertisements = Advertisement::get(),
            'rubrics' => Rubric::select(array('id', 'name'))->get(),
            'page_number' => $page_number,
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
        
        return redirect()->route('advertisement.index', ['page_number' => 1] );
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

        return redirect()->route('advertisement.index', ['page_number' => 1] );
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
            case ($request->search == null && $request->rubric == "all" && $request->distance == "all"): // everything
                $advertisements = Advertisement::orderBy('status', 'asc')->orderBy('premium', 'desc')->orderBy('created_at', 'desc')->get();
                $current_rubric_name = 'all';
                break;
            case ($request->search == null && $request->distance == "all"): // search on rubric
                $current_rubric_name = Rubric::where('id', '=', $request->rubric)->first()->name;
                $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                    return $query->where('id', '=', $request->rubric);
                                })->orderBy('status', 'asc')
                                ->orderBy('premium', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();
                break;
            case ($request->rubric == "all" && $request->distance == "all"): // search on regex search
                $current_rubric_name = 'all';

                $advertisements = Advertisement::where('title', 'regexp', $search_regex)->get();

                break;
            case ($request->search == null && $request->rubric == "all"): // search on distance
                $current_rubric_name = 'all';

                $distance = request('distance');
                $current_user = User::where('id', '=', session()->get('current_user_id'))->first();
                $enteredPostalcode = Postalcode::where('id', '=', $current_user->postalcode_id)->first();
                $postalcodesWithinRange = $enteredPostalcode->getPostalcodesByDistance($distance); //Gets all postalcodes (id) within range.
                $usersWithinRange = User::whereIn('postalcode_id', $postalcodesWithinRange)->get(); //Gets all users within this postalcode range.
                $userIDs = new Collection();
                foreach($usersWithinRange as $user){
                    $userIDs->push($user->id); //Creates new collection with only ID's of users within range for iteration.
                }
                $advertisements = new Collection();
                if($usersWithinRange->count() == 1){ //Different query needed for amount of users within range. Gets the items posted by these users.
                    $advertisements = Advertisement::where('user_id', $userIDs)
                                                ->orderBy('status', 'asc')
                                                ->orderBy('premium', 'desc')
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                } else if($usersWithinRange->count() > 1){
                    $advertisements = Advertisement::whereIn('user_id', $userIDs)
                                                ->orderBy('status', 'asc')
                                                ->orderBy('premium', 'desc')
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                }

                break;
            case ($request->search == null): // search on distance and rubric
                $current_rubric_name = Rubric::where('id', '=', $request->rubric)->first()->name;

                $distance = request('distance');
                $current_user = User::where('id', '=', session()->get('current_user_id'))->first();
                $enteredPostalcode = Postalcode::where('id', '=', $current_user->postalcode_id)->first();
                $postalcodesWithinRange = $enteredPostalcode->getPostalcodesByDistance($distance); //Gets all postalcodes (id) within range.
                $usersWithinRange = User::whereIn('postalcode_id', $postalcodesWithinRange)->get(); //Gets all users within this postalcode range.
                $userIDs = new Collection();
                foreach($usersWithinRange as $user){
                    $userIDs->push($user->id); //Creates new collection with only ID's of users within range for iteration.
                }
                $advertisements = new Collection();
                if($usersWithinRange->count() == 1){ //Different query needed for amount of users within range. Gets the items posted by these users.
                    $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                        return $query->where('id', '=', $request->rubric);
                                    })->where('user_id', $userIDs)
                                    ->orderBy('status', 'asc')
                                    ->orderBy('premium', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                } else if($usersWithinRange->count() > 1){
                    $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                        return $query->where('id', '=', $request->rubric);
                                    })->whereIn('user_id', $userIDs)
                                    ->orderBy('status', 'asc')
                                    ->orderBy('premium', 'desc')
                                    ->orderBy('created_at', 'desc')
                                    ->get();
                }

                break;
            case ($request->rubric == "all"): // search on distance and regex search
                $current_rubric_name = 'all';

                $distance = request('distance');
                $current_user = User::where('id', '=', session()->get('current_user_id'))->first();
                $enteredPostalcode = Postalcode::where('id', '=', $current_user->postalcode_id)->first();
                $postalcodesWithinRange = $enteredPostalcode->getPostalcodesByDistance($distance); //Gets all postalcodes (id) within range.
                $usersWithinRange = User::whereIn('postalcode_id', $postalcodesWithinRange)->get(); //Gets all users within this postalcode range.
                $userIDs = new Collection();
                foreach($usersWithinRange as $user){
                    $userIDs->push($user->id); //Creates new collection with only ID's of users within range for iteration.
                }
                $advertisements = new Collection();
                if($usersWithinRange->count() == 1){ //Different query needed for amount of users within range. Gets the items posted by these users.
                    $advertisements = Advertisement::where('user_id', $userIDs)
                                                ->where('title', 'regexp', $search_regex)
                                                ->orderBy('status', 'asc')
                                                ->orderBy('premium', 'desc')
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                } else if($usersWithinRange->count() > 1){
                    $advertisements = Advertisement::whereIn('user_id', $userIDs)
                                                ->where('title', 'regexp', $search_regex)
                                                ->orderBy('status', 'asc')
                                                ->orderBy('premium', 'desc')
                                                ->orderBy('created_at', 'desc')
                                                ->get();
                }
                

                break;
            case ($request->distance == "all"): //search on rubric and regex search
                $current_rubric_name = Rubric::where('id', '=', $request->rubric)->first()->name;

                $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                    return $query->where('id', '=', $request->rubric);
                                })->where('title', 'regexp', $search_regex)
                                ->orderBy('status', 'asc')
                                ->orderBy('premium', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();

                break;
            default: // search on rubric, distance and regex search
            $current_rubric_name = Rubric::where('id', '=', $request->rubric)->first()->name;

            $distance = request('distance');
            $current_user = User::where('id', '=', session()->get('current_user_id'))->first();
            $enteredPostalcode = Postalcode::where('id', '=', $current_user->postalcode_id)->first();
            $postalcodesWithinRange = $enteredPostalcode->getPostalcodesByDistance($distance); //Gets all postalcodes (id) within range.
            $usersWithinRange = User::whereIn('postalcode_id', $postalcodesWithinRange)->get(); //Gets all users within this postalcode range.
            $userIDs = new Collection();
            foreach($usersWithinRange as $user){
                $userIDs->push($user->id); //Creates new collection with only ID's of users within range for iteration.
            }
            $advertisements = new Collection();
            if($usersWithinRange->count() == 1){ //Different query needed for amount of users within range. Gets the items posted by these users.
                $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                    return $query->where('id', '=', $request->rubric);
                                })->where('user_id', $userIDs)
                                ->where('title', 'regexp', $search_regex)
                                ->orderBy('status', 'asc')
                                ->orderBy('premium', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();
            } else if($usersWithinRange->count() > 1){
                $advertisements = Advertisement::whereHas('rubric', function ($query) use($request) {
                    return $query->where('id', '=', $request->rubric);
                                })->whereIn('user_id', $userIDs)
                                ->where('title', 'regexp', $search_regex)
                                ->orderBy('status', 'asc')
                                ->orderBy('premium', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();
            }
        }

        return view('advertisement/search', [
            'advertisements' => $advertisements,
            'rubrics' => Rubric::select(array('id', 'name'))->get(),
            'current_rubric_name' => $current_rubric_name,
            'request' => $request
        ]);



        
    }
}
