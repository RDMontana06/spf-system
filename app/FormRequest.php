<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormRequest extends Model
{
    //
    public function project()
    {
        return $this->belongsTo(Project::class, 'project_id', 'id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'encode_by', 'id');
    }
    public function bank_info()
    {
        return $this->belongsTo(Bank::class, 'bank', 'id');
    }
    public function attachments()
    {
        return $this->hasMany(RequestAttachment::class, 'form_request_id', 'id');
    }
    public function request_history()
    {
        return $this->hasMany(FormRequestHistory::class)->orderBy('created_at', 'desc');
    }
}
