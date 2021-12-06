<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Word"),
 *     @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *     @OA\Property(property="name", type="string", minLength=2, example="word_example"),
 *     @OA\Property(property="groups", type="array", readOnly=true, @OA\Items(ref="#/components/schemas/Group")),
 *     @OA\Property(property="updated_at", type="date-time", readOnly=true, example="2021-12-10 00:00:00"),
 *     @OA\Property(property="created_at", type="date-time", readOnly=true, example="2021-12-10 00:00:00"),
 * )
 */
class Word extends Model
{
    use HasFactory;

    protected $fillable = [
        'name'
    ];

    public function groups(): BelongsToMany
    {
        return $this->belongsToMany(Group::class, 'word_groups');
    }
}
