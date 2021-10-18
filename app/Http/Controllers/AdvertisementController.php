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
    public function index()
    {
        return view('advertisement/overview', [
            'advertisements' => Advertisement::orderBy('status', 'asc')->orderBy('premium', 'desc')->get(),
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


        if ($validated['premium'] === "true") {
            $premium = true;
        } else {
            $premium = false;
        }

        Advertisement::create([
            'title' => $validated['title'],
            'body' => $validated['body'],
            'status' => 'available',
            'premium' => $premium
        ]);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, advertisement $advertisement)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function destroy(advertisement $advertisement)
    {
        //
    }
}
