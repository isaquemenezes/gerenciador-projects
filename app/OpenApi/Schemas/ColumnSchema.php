<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Column",
 *     type="object",
 *     title="Column",
 *     description="Representa uma coluna do quadro",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="nome"),
 *     @OA\Property(property="order", type="integer", example=2),
 *     @OA\Property(
 *         property="cards",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Card")
 *     )
 * )
 */
class ColumnSchema {}
