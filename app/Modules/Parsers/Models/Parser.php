<?php

namespace App\Modules\Parsers\Models;

use App\Modules\ParserResults\Models\ParserResult;
use Illuminate\Database\Eloquent\Model;

class Parser extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'url',
        'selector',
        'targets',
        'search_link_selector',
        'img_selector',
        'internal_link_selector',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'targets' => 'array',
    ];

    protected $with = [
        'results'
    ];

    public function results()
    {
        return $this->hasMany(ParserResult::class, 'parser_id');
    }

}
