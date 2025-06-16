<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Models\Board;
use App\Models\Column;
use App\Models\Card;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Http\Requests\Board\StoreBoardRequest;



/**
 * @OA\Tag(
 *     name="Boards",
 *     description="Gerenciamento de boards"
 * )
 */
class BoardApiController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/boards",
     *     summary="Lista todos os boards com colunas e cards",
     *     tags={"Boards"},
     *     @OA\Response(
     *         response=200,
     *         description="Lista de boards",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Board"))
     *     )
     * )
    */
    public function index()
    {
        $userId = auth()->id();
        $boards = Board::with([
                    'cards.category'
                ])
                ->where('user_id', $userId)
                ->orderByDesc('id')
                ->get();

        Log::info('Boards do usuário autenticado encontrados.', [
            'user_id' => $userId,
            'boards' => $boards,
        ]);

        return response()->json(
            $boards,
            Response::HTTP_OK
        );

    }


    /**
     * @OA\Post(
     *     path="/api/boards",
     *     summary="Cria um novo board",
     *     tags={"Boards"},
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BoardInput")
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Board criado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Board")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Dados inválidos"
     *     )
     * )
     */
    public function store(StoreBoardRequest $req)
    {
        // Debug
        Log::debug('Auth check:', [
            'user_id' => auth()->id(),
            'user' => auth()->user(),
            'guards' => config('auth.guards')
        ]);

        $this->authorize('create', Board::class);

        $board = Board::create([
            'user_id' => auth()->id(),
            'nome' => $req->input('nome')

        ]);

        return response()->json(
            $board,
            201
        );
    }

    /**
     * @OA\Get(
     *     path="/api/boards/{id}",
     *     summary="Exibe um board específico pelo ID",
     *     tags={"Boards"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do board",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Board encontrado",
     *         @OA\JsonContent(ref="#/components/schemas/Board")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Board não encontrado"
     *     )
     * )
     */
    public function show(string $id):JsonResponse
    {

        $board = Board::with('cards')->find($id);

        if (!$board) {
            Log::warning('Board não encontrado.', [
                'id' => $id
            ]);

            return response()->json(
                ['message' => 'Board não encontrado.'],
                Response::HTTP_NOT_FOUND
            );

        } else {
            Log::info('Board encontrado.', [
                'id' => $board->id,
                'nome' => $board->nome
            ]);

            return response()->json(
                $board,
                Response::HTTP_OK
            );
        }

    }

    /**
     * @OA\Put(
     *     path="/api/boards/{id}",
     *     summary="Atualiza um board existente",
     *     tags={"Boards"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do board a ser atualizado",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(ref="#/components/schemas/BoardInput")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Board atualizado com sucesso",
     *         @OA\JsonContent(ref="#/components/schemas/Board")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Board não encontrado"
     *     )
     * )
    */
    public function update(Request $request, string $id)
    {
       $board = Board::find($id);

        if (!$board) {
            return response()->json(
                ['message' => 'Board não encontrado.'],
                Response::HTTP_NOT_FOUND
            );
        }

        $board->update($request->validate(['nome' => 'required']));

        return response()->json($board, Response::HTTP_OK);
    }

   /**
     * @OA\Delete(
     *     path="/api/boards/{id}",
     *     summary="Remove um board pelo ID",
     *     tags={"Boards"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID do board a ser removido",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Board removido com sucesso"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Board não encontrado"
     *     )
     * )
     */
    public function destroy(string $id)
    {
       $board = Board::find($id);

        if (!$board) {
            return response()->json([
                'message' => 'Board não encontrado.'],
                Response::HTTP_NOT_FOUND
            );
        }

        $board->delete();

        return response()->json(
            null,
            Response::HTTP_NO_CONTENT
        );
    }
}
