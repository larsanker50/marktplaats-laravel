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
        // CR :: het is niet nodig om zo specifiek alles op te halen wat je wel nodig hebt, ik denk dat er niet veel meer kollomen zijn dan deze
        $advertisements = Advertisement::where('premium', '=', false)->select('user_id', 'title', 'body', 'status', 'premium', 'created_at')->get();
        // CR :: nu doe je 2 requests naar het DB met maar een klein verschil, kun je dit niet beter oplossen op een andere plek?
        $premium_advertisements = Advertisement::where('premium', '=', true)->select('user_id', 'title', 'body', 'status', 'premium', 'created_at')->get();

        return view('advertisement/overview', [
            'advertisements' => $advertisements,
            'premium_advertisements' => $premium_advertisements
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
