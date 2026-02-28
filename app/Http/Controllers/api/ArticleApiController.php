<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Ab_Article;
use App\Models\AbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use WebSocket\Client;

class ArticleApiController extends Controller
{
    public function searchArticle_api(Request $request){

        $search = $request->input('search');
        $page = max((int) $request->input('page', 1), 1); // Seite mindestens 1
        $limit = 5;
        $offset = ($page - 1) * $limit;

        $query = DB::table('ab_article');

        if ($search) {
            $query->where('ab_name', 'ILIKE', '%' . $search . '%');
        }

        $total = $query->count();

        $articles = $query
            ->select('id', 'ab_name', 'ab_price', 'ab_description','ab_creator_id')
            ->offset($offset)
            ->limit($limit)
            ->get();

        return response()->json([
            'success' => true,
            'page' => $page,
            'total' => $total,
            'articles' => $articles
        ]);
    }


    public function store_article(Request $request)
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

            return response()->json(['id'=>$article->id],201);

        } catch (\Exception $e) {
            return response()->json(['message' => "Fehler". $e->getMessage()]);
        }
    }
    public function notifySold( $id)
    {
        $article = Ab_Article::findOrFail($id);

        $userId = $article->ab_creator_id;
        $articleName = $article->ab_name;

        $message = [
            'type' => 'sold',
            'user_id' => $userId,
            'message' => "Großartig! Ihr Artikel '{$articleName}' wurde erfolgreich verkauft!"
        ];

        try {
            $client = new Client("ws://localhost:4010/chat");
            $client->send(json_encode($message));
            $client->close();

            return response()->json(['status' => 'ok', 'sent_to' => $userId]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }


    public function markAsOffer($id)
    {
        $article = Ab_Article::findOrFail($id);


        $message = [
            'type' => 'offer',
            'article_id' => $article->id,
            'user_id' => $article->ab_creator_id,
            'message' => "Der Artikel {$article->ab_name} wird nun günstiger angeboten! Greifen Sie schnell zu."
        ];

        $client = new Client("ws://localhost:4010/chat");
        $client->send(json_encode($message));
        $client->close();

        return response()->json(['status' => 'ok']);
    }
}
