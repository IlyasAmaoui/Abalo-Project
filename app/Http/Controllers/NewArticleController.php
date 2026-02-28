<?php

namespace App\Http\Controllers;

use App\Models\Ab_Article;
use App\Models\AbUser;
use Illuminate\Http\Request;

class NewArticleController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0.01',
            'description' => 'nullable|string',
        ]);

        try {
            $article = new Ab_Article();
            $article->ab_name = $validated['name'];
            $article->ab_price = $validated['price'];
            $article->ab_description = $validated['description'];
            $article->ab_creator_id =AbUser::query()->where('ab_mail',session()->get('abalo_mail'))->value('id');
            $article->ab_createdate= now();
            $article->save();


            return redirect('/articles');
        } catch (\Exception $e) {
            return back()->withErrors(['server' => 'Speichern fehlgeschlagen: ' . $e->getMessage()]);
            }
        }

}
