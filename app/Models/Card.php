<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Card extends Model
{
    use HasFactory;
    protected $table = 'cards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'titulo',
        'descricao',
        'order',
        'board_id',
        'category_id'
    ];
    public function board(): BelongsTo
    {
        return $this->belongsTo(Board::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
