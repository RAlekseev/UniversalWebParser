<?php

namespace App\Modules\ParserResults\Models;

use App\Modules\Parsers\Models\Parser;
use Illuminate\Database\Eloquent\Model;

class ParserResult extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'parser_id',
        'url',
        'targets_result',
        'images',
        'internal_links',
        'result_hash',
    ];


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'targets_result' => 'array',
        'images' => 'array',
        'internal_links' => 'array',
    ];

    public function parser()
    {
        return $this->belongsTo(Parser::class, 'parser_id');
    }
}
