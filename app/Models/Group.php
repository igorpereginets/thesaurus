<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 *     @OA\Xml(name="Group"),
 *     @OA\Property(property="id", type="integer", readOnly=true, example=1),
 *     @OA\Property(property="words", type="array", readOnly=true, @OA\Items(ref="#/components/schemas/Word")),
 *     @OA\Property(property="updated_at", type="date-time", readOnly=true, example="2021-12-10 00:00:00"),
 *     @OA\Property(property="created_at", type="date-time", readOnly=true, example="2021-12-10 00:00:00"),
 * )
 */
class Group extends Model
{
    use HasFactory;

    public function words(): BelongsToMany
    {
        return $this->belongsToMany(Word::class, 'word_groups');
    }
}
