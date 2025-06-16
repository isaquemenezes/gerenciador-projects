<?php
namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Card",
 *     type="object",
 *     title="Card",
 *     description="Representa um cartão em uma coluna do quadro",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="titulo", type="string", example="Título de exemplo"),
 *     @OA\Property(property="descricao", type="string", example="Descrição de exemplo"),
 *     @OA\Property(property="order", type="integer", example=2),
 * )
 */
class CardSchema {}
