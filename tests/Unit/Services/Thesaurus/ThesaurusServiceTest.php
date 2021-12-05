<?php

namespace Tests\Unit\Services\Thesaurus;

use App\Models\Group;
use App\Models\Word;
use App\Services\Thesaurus\ThesaurusService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThesaurusServiceTest extends TestCase
{
    use RefreshDatabase;

    private ThesaurusService $thesaurus;

    protected function setUp(): void
    {
        parent::setUp();
        $this->thesaurus = new ThesaurusService();
    }

    public function test_get_words_on_empty_db()
    {
        $words = $this->thesaurus->getWords();
        $this->assertIsArray($words);
        $this->assertEmpty($words);
    }

    public function test_get_words_returns_all_words()
    {
        $words = Word::factory()->count(10)->create();
        $response = $this->thesaurus->getWords();

        $this->assertEqualsCanonicalizing($words->pluck('name')->toArray(), $response);
    }

    public function test_get_synonyms_of_non_existing_word()
    {
        $synonyms = $this->thesaurus->getSynonyms('non_existing_word');

        $this->assertEmpty($synonyms);
    }

    public function test_get_synonyms_of_word_in_one_group()
    {
        $groups = Group::factory()->count(1)->create();
        $words = Word::factory()->count(5)->hasAttached($groups)->create();
        $wordToCheck = $words->pop();
        $synonyms = $this->thesaurus->getSynonyms($wordToCheck->name);

        $this->assertNotContains($wordToCheck->name, $synonyms);
        $this->assertEqualsCanonicalizing($words->pluck('name')->toArray(), $synonyms);
    }

    public function test_get_synonyms_of_word_in_one_group_in_uppercase()
    {
        $groups = Group::factory()->count(1)->create();
        $words = Word::factory()->count(5)->hasAttached($groups)->create();
        $wordToCheck = $words->pop();
        $synonyms = $this->thesaurus->getSynonyms(strtoupper($wordToCheck->name));

        $this->assertNotContains($wordToCheck->name, $synonyms);
        $this->assertEqualsCanonicalizing($words->pluck('name')->toArray(), $synonyms);
    }

    public function test_get_synonyms_from_different_groups()
    {
        $groups = Group::factory()->count(2)->create();
        $wordsInFirstGroup = Word::factory()->count(5)->hasAttached($groups[0])->create();
        $wordsInSecondGroup = Word::factory()->count(5)->hasAttached($groups[1])->create();
        $wordToCheck = Word::factory()->hasAttached($groups)->create();

        $synonyms = $this->thesaurus->getSynonyms($wordToCheck->name);

        $this->assertEqualsCanonicalizing($wordsInFirstGroup->merge($wordsInSecondGroup)->pluck('name')->toArray(), $synonyms);
    }

    public function test_get_synonyms_without_words_from_another_groups()
    {
        $group = Group::factory()->count(1)->create();
        $words = Word::factory()->count(5)->hasAttached($group)->create();
        $notAttachedWords = Word::factory()->count(10)->hasAttached(Group::factory())->create();
        $wordToCheck = $words->pop();

        $synonyms = $this->thesaurus->getSynonyms($wordToCheck->name);

        foreach ($notAttachedWords as $notAttachedWord) {
            $this->assertNotContains($notAttachedWord->name, $synonyms);
        }
    }

    public function test_add_synonyms_with_empty_array()
    {
        $this->thesaurus->addSynonyms([]);

        $this->assertEmpty(Word::get());
        $this->assertEmpty(Group::get());
    }

    public function test_add_synonyms_with_one_word()
    {
        $this->thesaurus->addSynonyms(['test_word']);

        $this->assertEmpty(Word::get());
        $this->assertEmpty(Group::get());
    }

    public function test_add_synonyms_with_different_types()
    {
        $this->thesaurus->addSynonyms([null, false, 12.5, 123, new \stdClass()]);

        $this->assertEmpty(Word::get());
        $this->assertEmpty(Group::get());
    }

    public function test_add_synonyms_with_empty_words()
    {
        $this->thesaurus->addSynonyms(['', '']);

        $this->assertEmpty(Word::get());
        $this->assertEmpty(Group::get());
    }

    public function test_add_synonyms_with_same_words()
    {
        $this->thesaurus->addSynonyms(['test_word_1', 'test_word_1']);

        $this->assertEmpty(Word::get());
        $this->assertEmpty(Group::get());
    }

    public function test_add_synonyms_with_new_words()
    {
        $words = Word::factory()->count(10)->make();

        $this->thesaurus->addSynonyms($words->pluck('name')->toArray());

        $fromDB = Word::with('groups')->get();
        foreach ($fromDB as $word) {
            $this->assertNotNull($word->groups);
        }

        $this->assertEquals($words->count(), $fromDB->count());
        $this->assertEquals(1, Group::count());
    }

    public function test_add_synonyms_from_differenet_groups()
    {
        $groups = Group::factory()->count(2)->create();
        $wordsFromFirstGroup = Word::factory()->count(5)->hasAttached($groups[0])->create();
        $wordsFromSecondGroup = Word::factory()->count(5)->hasAttached($groups[1])->create();

        $this->thesaurus->addSynonyms([$wordsFromFirstGroup->first()->name, $wordsFromSecondGroup->first()->name]);

        $this->assertEquals($wordsFromFirstGroup->count() + $wordsFromSecondGroup->count(), Word::count());
        $this->assertEquals(3, Group::count());
    }
}
