<?php

namespace App\Http\Controllers;

use App\Sign;
use Illuminate\Http\Request;
use Spatie\Tags\Tag;

class SignController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $meanings = Tag::withType('meaning')->orderBy('name')->where('name', 'LIKE', '%' . $request->q . '%')->get()->sortBy('name', SORT_NATURAL | SORT_FLAG_CASE);
        $query = Sign::withAnyTags($meanings, 'meaning');

        if ($request->q) {
            $title = "Search results for: '" . $request->q . "'";
        } else if ($request->cat) {
            $title = "Category: " . $request->cat;
            $query->withAllTags([$request->cat], 'category');
        } else {
            $title = "Browse Signs";
        }
        $signs = $query->get();

        return view('signs.index', compact('signs', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('signs.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        // Validate Request Data

        // Store Videos to Storage
        $video = '';
        $explanation_video = '';
        if ($request->has('video')) {
            $video = $request->video->store('public/signs');
        }
        if ($request->has('explanation_video')) {
            $explanation_video = $request->explanation_video->store('public/signs');
        }

        // Save Sign
        $sign = new Sign();
        $sign->video = $video;
        $sign->explanation = $request->explanation;
        $sign->explanation_video = $explanation_video;
        $sign->save();

        // Attach Meaning Tags to Sign
        $sign->syncTagsWithType($request->meaning, 'meaning');

        // Attach Category Tags to Sign
        $sign->syncTagsWithType($request->category, 'category');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function show(Sign $sign) {
        $related = Sign::withAnyTags($sign->tags)->where('id', '!=', $sign->id)->get();
        return view('signs.show', compact('sign', 'related'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function edit(Sign $sign) {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sign $sign) {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sign $sign) {
        //
    }
}
