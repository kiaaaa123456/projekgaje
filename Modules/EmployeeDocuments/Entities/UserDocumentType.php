<?php

namespace Modules\EmployeeDocuments\Entities;

use App\Models\coreApp\Status\Status;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class UserDocumentType extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','status_id'
    ];
    protected $table = 'user_document_types';

    public function status(): BelongsTo
    {
        return $this->belongsTo(Status::class);
    }
}
