<?php

namespace App\Http\Controllers;

use App\Models\Bidding;
use App\Models\Advertisement;
use App\Http\Requests\StoreBiddingRequest;
use Illuminate\Http\Request;

class BiddingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // CR :: opruimen aub 
        dd(Bidding::all());
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
    public function store(StoreBiddingRequest $request, advertisement $advertisement)
    {
        $validated = $request->validated();

        // CR :: NICE!
        Bidding::create([
            'user_id' => $request->session()->get('current_user_id'),
            'advertisement_id' => $advertisement->id,
            'bidding' => $validated['bidding'],
        ]);

        return redirect()->route('advertisement.show', ['advertisement' => $advertisement->id]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function show(Bidding $bidding)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function edit(Bidding $bidding)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Bidding $bidding)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Bidding  $bidding
     * @return \Illuminate\Http\Response
     */
    public function destroy(advertisement $advertisement, Bidding $bidding)
    {
        Bidding::destroy($bidding->id);

        return redirect()->route('advertisement.show', ['advertisement' => $advertisement->id]);
    }
}
