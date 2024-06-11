<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDocumentUpload extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'description',
        'image_path',
        'reminder_email_date',
        'actual_date',
    ];
}
