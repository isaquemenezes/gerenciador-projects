<?php

namespace App\Http\Controllers\Api;

use App\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Card\StoreCardRequest;
use App\Http\Requests\Card\UpdateCardRequest;




/**
 * @OA\Tag(
 *     name="Cards",
 *     description="Gerenciamento de Cards"
 * )
 */
class CardApiController extends Controller
{

    public function index(): JsonResponse
    {

        // $cards = Card::with('category')->get();


        $cards = Card::with('category')
            ->whereHas('board', fn($query) =>
                $query->where('user_id', auth()->id())
            )
            ->orderByDesc('id')
            ->get();

        Log::info('Cards do usuário autenticado carregados.', [
            'user_id' => auth()->id(),
            'cards' => $cards
        ]);

        return response()->json($cards);
    }

    public function store(StoreCardRequest $req): JsonResponse
    {
        $data = $req->validated();

        $card = Card::create($data);

        return response()->json($card, 201);
    }

    public function show(string $id): JsonResponse
    {
        $card = Card::with('board')
            ->find($id);

        if (!$card) {
            return response()->json([
                'message' => 'Card não encontrado.'
            ], 404);
        }

        return response()->json($card);
    }

    public function update(UpdateCardRequest $request, string $id): JsonResponse
    {
       $card = Card::findOrFail($id);

        $data = array_filter($request->only([
            'titulo',
            'descricao',
            'board_id',
            'category_id'
        ]), fn ($value) => !is_null($value));

        $card->update($data);

        return response()->json($card);
    }

    public function destroy(string $id): JsonResponse
    {
        $card = Card::findOrFail($id);
        $card->delete();

        return response()->json(
        null,
        Response::HTTP_NO_CONTENT
        );
    }
}
