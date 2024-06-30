<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

/** Class Pet
 * @author mSzekely
 * @package App\Models\
 *
 * @property integer $id
 * @property string  $name
 * @property integer $age
 * @property string  $species
 * @property string  $breed
 * @property string  $description
 * @property string $status
 * @property Carbon|string|null $created_at
 * @property Carbon|string|null $updated_at
 *
 */
class Pet extends Model
{
   /**
    * @var bool
    */
    public $timestamps = true;
    /**
     * @var array
     */
    public $fillable = [
        'name',
        'age',
        'species',
        'breed',
        'description',
        'status',
        'updated_at'
    ];
}
