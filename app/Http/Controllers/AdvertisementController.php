<?php

namespace App\Http\Controllers;

use App\Models\advertisement;
use Illuminate\Http\Request;

class AdvertisementController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // CR :: dit zou ik anders doen, nu doe je 3 requests naar advertisemens, misschien op een andere plek uitsplitsen?
        $advertisements = Advertisement::where('premium', '=', false)->where('status', '=', 'available')->select('user_id', 'title', 'body', 'status', 'premium', 'created_at')->get();

        $premium_advertisements = Advertisement::where('premium', '=', true)->where('status', '=', 'available')->select('user_id', 'title', 'body', 'status', 'premium', 'created_at')->get();

        $sold_advertisements = Advertisement::where('status', '=', 'sold')->select('user_id', 'title', 'body', 'status', 'premium', 'created_at', 'updated_at')->get();

        return view('advertisement/overview', [
            'advertisements' => $advertisements,
            'premium_advertisements' => $premium_advertisements,
            'sold_advertisements' => $sold_advertisements
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\advertisement  $advertisement
     * @return \Illuminate\Http\Response
     */
    public function show(advertisement $advertisement)
    {
        //
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
