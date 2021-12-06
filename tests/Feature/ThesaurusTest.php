<?php

namespace Tests\Feature;

use App\Models\Group;
use App\Models\Word;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThesaurusTest extends TestCase
{
    use RefreshDatabase;

    public function test_get_all_words_with_empty_DB()
    {
        $response = $this->get('/api/words');

        $response->assertOk();
        $response->assertJson([]);
    }

    public function test_get_all_words_with_not_empty_DB()
    {
        $words = Word::factory()->count(10)->create();
        $response = $this->get('/api/words');

        $response->assertOk();
        $response->assertSimilarJson($words->pluck('name')->toArray());
    }

    public function test_add_synonyms_validation_structure()
    {
        $response = $this->post('/api/word/synonyms', []);

        $response->assertStatus(422);
        $response->assertJsonStructure([
            'message',
            'errors' => [
                'words'
            ]
        ]);
    }

    public function test_add_synonyms_with_no_body()
    {
        $response = $this->post('/api/word/synonyms', ['words' => []]);

        $response->assertStatus(422);
    }

    public function test_add_synonyms_with_single_word()
    {
        $response = $this->post('/api/word/synonyms', ['words' => ['single_word']]);

        $response->assertStatus(422);
    }

    public function test_add_synonyms_with_exact_values()
    {
        $response = $this->post('/api/word/synonyms', ['words' => ['repeated_word', 'repeated_word']]);

        $response->assertStatus(422);
    }

    public function test_add_synonyms_with_words_length_less_than_two()
    {
        $response = $this->post('/api/word/synonyms', ['words' => ['o', 't']]);

        $response->assertStatus(422);
    }

    public function test_add_synonyms_with_different_words()
    {
        $response = $this->post('/api/word/synonyms', ['words' => ['first_word', 'second_word']]);

        $response->assertNoContent();
    }

    public function test_get_synonyms_without_word()
    {
        $response = $this->get('/api/word/synonyms');

        $response->assertStatus(422);
    }

    public function test_get_synonyms_with_non_existing_word()
    {
        $response = $this->get('/api/word/synonyms?word=non_existing_word');

        $response->assertStatus(422);
    }

    public function test_get_synonyms_of_existing_word()
    {
        $group = Group::factory()->create();
        $wordToCheck = Word::factory()->hasAttached($group)->create();
        $synonyms = Word::factory()->count(5)->hasAttached($group)->create();

        $response = $this->get('/api/word/synonyms?word=' . urlencode($wordToCheck->name));

        $response->assertOk();
        $response->assertSimilarJson($synonyms->pluck('name')->toArray());
    }

    public function test_get_synonyms_of_word_with_non_url_friendly_characters()
    {
        $group = Group::factory()->create();
        $wordToCheck = Word::factory()->hasAttached($group)->create(['name' => 'asd&two=123']);
        $synonyms = Word::factory()->count(5)->hasAttached($group)->create();

        $response = $this->get('/api/word/synonyms?word=' . urlencode($wordToCheck->name));

        $response->assertOk();
        $response->assertSimilarJson($synonyms->pluck('name')->toArray());
    }
}
