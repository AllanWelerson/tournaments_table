<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Match extends Model
{
    use HasFactory;

    protected $fillable = ['date','goals_team_1','goals_team_2','team_1_id','team_2_id','round_id'];

    public function round()
    {
        return $this->belongsTo('App\Models\Round');
    }

    public function team1()
    {
        return $this->belongsTo('App\Models\Team','team_1_id');
    }

    public function team2()
    {
        return $this->belongsTo('App\Models\Team','team_2_id');
    }
}
