<?php

namespace App\Models\Monitaz\NotifyDataProcessCompetitor;

use App\Models\App\AppModel;
use App\Models\Core\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class NotifyDataProcessCompetitor extends AppModel
{
    protected $connection = 'mysql4';

    protected $fillable = [
        'uid',
        'list_objects',
        'role',
        'status',
        'status_confirm',
        'notice_by',
        'confirm_at',
        'created_at',
    ];

    protected $table = "notify_data_process_competitor";

}
