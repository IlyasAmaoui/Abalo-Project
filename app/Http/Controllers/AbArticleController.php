<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAbarticleRequest;
use App\Http\Requests\UpdateAbArticleRequest;
use App\Models\AbArticle;
use App\Models\AbUser;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AbArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request):View
    {
        $search = $request->string('search')->trim()->value();
        $articles = AbArticle::with('abuser')
            ->when($search, fn ($query) => $query->whereRaw('ab_name ILIKE ?', ['%'.$search.'%']))
            ->paginate(8);

        return view('home', compact('articles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create():View
    {

        return view('articles.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAbarticleRequest $request):RedirectResponse
    {

        // 1. Create the article WITHOUT image_path
        $abarticle = auth()->user()->articles()->create([
            'ab_name' => $request->ab_name,
            'ab_price' => $request->ab_price,
            'ab_description' => $request->ab_description,
            'ab_createdate' => Carbon::now(),
            // image_path intentionally left out
        ]);

        // 2. Handle the image upload SEPARATELY
        if ($request->hasFile('image_path')) {
            // Store the file properly
            $path = $request->file('image_path')->storeAs(
                'articleImages',           // Directory
                $abarticle->id . '.jpg',     // Filename
                'public'                   // Disk
            );

            // Now save the proper path
            $abarticle->image_path = $path;
            $abarticle->save();
        }
        return redirect('/')->with('success', 'Your article has been posted!');

    }

    /**
     * Display the specified resource.
     */
    public function show(AbArticle $abarticle): View
    {
        return view('articles.show', [
            'abarticle' => $abarticle,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AbArticle $abarticle)
    {
        return view('articles.edit', ['abarticle' => $abarticle]);

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAbArticleRequest $request, AbArticle $abarticle)
    {
        $validated = $request->validated();

        $abarticle->ab_name = $validated['ab_name'];
        $abarticle->ab_price = $validated['ab_price'];
        $abarticle->ab_description = $validated['ab_description'];

        if ($request->hasFile('image')) {
            $request->file('image')->storeAs(
                'articleImages',
                $abarticle->id . '.jpg',
                'public'
            );
        }

        $abarticle->save();

        return redirect()
            ->route('abArticles.show', $abarticle)
            ->with('success', 'Article updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AbArticle $abarticle)
    {
        $abarticle->delete();
        return redirect('/')->with('success', 'Article deleted successfully!');
    }
}
