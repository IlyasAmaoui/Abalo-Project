<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\AbShoppingCart;
use App\Models\AbShoppingCartItem;
use App\Models\AbUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ShoppingCartController extends Controller
{
    public function store_api(Request $request)
    {

        $request->validate([
            'article_id' => 'required|exists:ab_article,id',
        ]);

        $shoppingCart = AbShoppingCart::firstOrCreate([
            'ab_creator_id' => AbUser::query()->where('ab_mail', session()->get('abalo_mail'))->value('id'),
        ], [
            'ab_createdate' => now()
        ]);

        $item = AbShoppingCartItem::create([
            'ab_shoppingcart_id' => $shoppingCart->id,
            'ab_article_id' => $request->article_id,
            'ab_createdate' => now()
        ]);

        return response()->json(['success' => true, 'item_id' => $item->id], 201);
    }

    public function destroy($shoppingcartid, $articleId)
    {
        try {
            AbShoppingCartItem::where('ab_shoppingcart_id', $shoppingcartid)
                ->where('ab_article_id', $articleId)
                ->delete();
            return response()->json(['message' => 'Artikel entfernt'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function getUserCart_api(Request $request)
    {

        try {
            $userId = AbUser::query()->where("ab_mail", session()->get("abalo_mail"))->value("id");

            if (!$userId) {
                return response()->json(['error' => 'Nicht eingeloggt'], 401);
            }

            // Finde den Warenkorb für den User
            $cart = AbShoppingCart::where('ab_creator_id', $userId)->first();

            if (!$cart) {
                return response()->json([]); // kein Warenkorb vorhanden
            }

            // Hole die Artikel aus dem Warenkorb
            $items = DB::table('ab_shoppingcart_item')
                ->join('ab_article', 'ab_shoppingcart_item.ab_article_id', '=', 'ab_article.id')
                ->where('ab_shoppingcart_item.ab_shoppingcart_id', $cart->id)
                ->select(
                    'ab_article.id',
                    'ab_article.ab_name',
                    'ab_article.ab_price',
                    'ab_shoppingcart_item.ab_shoppingcart_id'
                )
                ->groupBy('ab_article.id', 'ab_shoppingcart_item.ab_shoppingcart_id')
                ->get();

            return response()->json($items);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
