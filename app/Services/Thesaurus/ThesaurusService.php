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
                if (is_string($synonym) && $synonym !== '') {
                    $word = Word::firstOrCreate(['name' => strtolower($synonym)]);

                    $wordsResponse->put($word->id, $word);
                }
            }

            // If all words in one group - do nothing
            if ($wordsResponse->count() <= 1 || $this->haveCommonGroup($wordsResponse)) {
                \DB::rollBack();
                return;
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

    /**
     * Check if words have at least one common group
     *
     * @param Collection $words
     *
     * @return bool
     */
    private function haveCommonGroup(Collection $words): bool
    {
        $wordGroups = $words->map(fn($e) => $e->groups()->allRelatedIds());

        return $wordGroups->pop()->intersect(...$wordGroups)->isNotEmpty();
    }
}
