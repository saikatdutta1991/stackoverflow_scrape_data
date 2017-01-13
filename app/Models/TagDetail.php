<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TagDetail extends Model
{
    
    protected $table = 'tag_details';

    public function questionDetails()
    {
        return $this->hasMany('App\Models\QuestionDetail', 'tag_details_id');
    }
}
