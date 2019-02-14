<?php

namespace App\Models;


use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Image
 * @package App\Models
 *
 * @property int $id
 * @property string $path
 * @property string $name
 * @property string $extension
 * @property string|null $submitter
 * @property string|null $location
 * @property string|null $topic
 * @property Carbon $taken_at
 *
 * @property string $href
 */
class Image extends Model
{
    protected $dates = [
        'taken_at',
        'created_at',
        'updated_at',
    ];

    protected $appends = [
        'href'
    ];

    protected $fillable = [
        'submitter',
        'location',
        'topic',
        'taken_at',
    ];

    protected $hidden = [
        'path'
    ];

    public function getHrefAttribute() {
        return '';//url('/images/' . $this->id);
    }
}