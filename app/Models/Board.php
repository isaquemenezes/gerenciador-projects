<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;



class Board extends Model
{
    use HasFactory;

    protected $table = 'boards';
    protected $primaryKey = 'id';
    protected $fillable = [
        'nome',
        'user_id'
    ];


    public function cards(): HasMany
    {
        return $this->hasMany(Card::class);
    }

   public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
