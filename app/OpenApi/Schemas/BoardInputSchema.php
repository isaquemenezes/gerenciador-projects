<?php

namespace App\OpenApi\Schemas;

/**
 * @OA\Schema(
 *     schema="BoardInput",
 *     type="object",
 *     required={"nome"},
 *     @OA\Property(property="nome", type="string", example="Meu novo board")
 * )
 */
class BoardInputSchema {}
