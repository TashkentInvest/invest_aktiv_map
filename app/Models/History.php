<?php

// app/Models/History.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'field',
        'old_value',
        'new_value',
        'user_id',
    ];

    /**
     * Get the user that owns the history.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
