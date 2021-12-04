<?php

namespace App\Interfaces;

interface Thesaurus
{
    // Adds the given words as synonyms to each other
    public function addSynonyms(array $synonyms): void;

    // Returns an array with all the synonyms for a word
    public function getSynonyms(string $word): array;

    // Returns an array with all words that are stored in the thesaurus
    public function getWords(): array;
}
