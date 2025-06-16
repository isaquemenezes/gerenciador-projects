<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="Board",
 *     type="object",
 *     title="Board",
 *     @OA\Property(property="id", type="integer", example=1),
 *     @OA\Property(property="nome", type="string", example="nome"),
 *     @OA\Property(
 *         property="columns",
 *         type="array",
 *         @OA\Items(ref="#/components/schemas/Column")
 *     )
 * )
 */
class BoardSchema {}
