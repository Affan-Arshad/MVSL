<?php

namespace App\Http\Controllers\Admin;

use App\Sign;
use Spatie\Tags\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;

class SignController extends Controller {
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware(['role:Editor|Super-Admin']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $signs = Sign::get();
        return view('admin.signs.index', compact('signs'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Tag::getWithType('category')->toArray();
        $categoriesData = array_map(function ($cat) {
            return (object) array('id' => $cat['name']['en'], 'text' => $cat['name']['en']);
        }, $categories);

        $meanings = Tag::getWithType('meaning')->toArray();
        $meaningsData = array_map(function ($cat) {
            return (object) array('id' => $cat['name']['en'], 'text' => $cat['name']['en']);
        }, $meanings);
        return view('admin.signs.create', compact('categoriesData', 'meaningsData'));
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
        // $explanation_video = '';
        if ($request->has('video')) {
            $video = $request->video->store('public/signs');
        }
        // if ($request->has('explanation_video')) {
        //     $explanation_video = $request->explanation_video->store('public/signs');
        // }

        // Save Sign
        $sign = new Sign();
        $sign->video = $video;
        $sign->explanation = $request->explanation;
        // $sign->explanation_video = $explanation_video;
        $sign->save();

        // Attach Meaning Tags to Sign
        $sign->syncTagsWithType($request->meaning, 'meaning');

        // Attach Category Tags to Sign
        $sign->syncTagsWithType($request->category, 'category');


        flashMessage('Sign created', 'success');

        return redirect()->route('admin.signs.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function show(Sign $sign) {
        // $sign = $sign::with('tags')->first();
        // dd($sign->tagsWithType('meaning'));
        return view('admin.signs.show', compact('sign'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function edit(Sign $sign) {
        $categories = Tag::getWithType('category')->toArray();
        $categoriesData = array_map(function ($cat) use ($sign) {
            return (object) array(
                'id' => $cat['name']['en'],
                'text' => $cat['name']['en'],
                'selected' => Sign::withAllTags([$cat['name']['en']], 'category')->get()->contains($sign)
            );
        }, $categories);

        $meanings = Tag::getWithType('meaning')->toArray();
        $meaningsData = array_map(function ($cat) use ($sign) {
            return (object) array(
                'id' => $cat['name']['en'],
                'text' => $cat['name']['en'],
                'selected' => Sign::withAllTags([$cat['name']['en']], 'meaning')->get()->contains($sign)
            );
        }, $meanings);
        return view('admin.signs.create', compact('categoriesData', 'meaningsData', 'sign'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Sign $sign) {
        // Store Videos to Storage
        if ($request->has('video')) {

            $video = $request->video->store('public/signs');
            $oldVideo = $sign->video;
            $sign->video = $video;

            if ($oldVideo != '') {
                Storage::delete($oldVideo);
                flashMessage('Old file deleted', 'success');
            }
        }

        // Save Sign
        $sign->explanation = $request->explanation;
        $sign->save();

        // Attach Meaning Tags to Sign
        $sign->syncTagsWithType($request->meaning, 'meaning');

        // Attach Category Tags to Sign
        $sign->syncTagsWithType($request->category, 'category');

        flashMessage('Sign updated', 'success');

        return redirect()->route('admin.signs.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Sign  $sign
     * @return \Illuminate\Http\Response
     */
    public function destroy(Sign $sign) {
        $sign->delete();

        flashMessage('Sign deleted', 'success');

        return redirect()->route('admin.signs.index');
    }
}
