<?php

namespace App\Http\Controllers;

use App\Sign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SignController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $signs = Sign::all();
        return view('signs.index', compact('signs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('signs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate Request Data

        // Store Videos to Storage
        $video = '';
        $explanation_video = '';
        if($request->has('video')) {
            $video = $request->video->store('public/signs');
        }
        if($request->has('explanation_video')) {
            $explanation_video = $request->explanation_video->store('public/signs');
        }

        // Save Sign
        $sign = new Sign();
        $sign->video = $video;
        $sign->explanation = $request->explanation;
        $sign->explanation_video = $explanation_video;
        $sign->save();

        // Attach Tags to Sign
        $sign->attachTags($request->meaning);

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function show(Sign $sign)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function edit(Sign $sign)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sign $sign)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sign $sign)
    {
        //
    }
}
