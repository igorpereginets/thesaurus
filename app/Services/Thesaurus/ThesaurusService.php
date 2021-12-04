<?php

namespace App\Services\Thesaurus;

use App\Interfaces\Thesaurus;
use App\Models\Group;
use App\Models\Word;
use Illuminate\Support\Collection;

class ThesaurusService implements Thesaurus
{

    public function addSynonyms(array $synonyms): void
    {
        if (count($synonyms) <= 1) {
            return;
        }

        $wordsResponse = collect();

        \DB::beginTransaction();
        try {
            foreach ($synonyms as $synonym) {
                if (is_string($synonym) && $synonym !== '') { //TODO All of them are empty?
                    $word = Word::firstOrCreate(['name' => strtolower($synonym)]);

                    $wordsResponse->add($word);
                }
            }

            Group::create()->words()->sync($wordsResponse->pluck('id'));

            \DB::commit();
        } catch(\Exception $e) {
            \DB::rollback();

            throw $e;
        }
    }

    public function getSynonyms(string $word): array
    {
        if (!$wordModel = Word::where('name', strtolower($word))->first()) {
            return [];
        }

        return Word::where('id', '!=', $wordModel->id)
            ->whereHas('groups', function($q) use ($wordModel) {
                $q->whereIn('id', $wordModel->groups()->allRelatedIds());
            })
            ->pluck('name')
            ->toArray();
    }

    public function getWords(): array
    {
        return Word::pluck('name')->toArray();
    }
}
