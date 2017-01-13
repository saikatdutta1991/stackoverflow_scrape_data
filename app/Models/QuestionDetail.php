<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuestionDetail extends Model
{
    
    protected $table = 'question_details';

    public function tagDetail()
    {
    	return $this->belongsTo('App\Models\TagDetail', 'tag_details_id');
    }
}
