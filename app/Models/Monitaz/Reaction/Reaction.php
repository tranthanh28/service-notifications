<?php

namespace App\Models\Monitaz\Reaction;

use App\Models\Core\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Reaction extends Model
{
    protected $fillable = ['name', 'created_at', 'status', 'post_ids', 'file_name'];

    protected $table = "reactions";
}
