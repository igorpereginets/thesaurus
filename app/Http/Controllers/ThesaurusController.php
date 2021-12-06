<?php

namespace App\Http\Controllers;

use App\Http\Requests\ThesaurusRequest;
use App\Interfaces\Thesaurus;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class ThesaurusController extends Controller
{
    private Thesaurus $thesaurus;

    public function __construct(Thesaurus $thesaurus)
    {
        $this->thesaurus = $thesaurus;
    }

    /**
     * @OA\Get(
     *     path="/api/words",
     *     tags={"Words"},
     *     summary="Get all words from DB",
     *     @OA\Response(
     *         response="200",
     *         description="Display words from DB",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(type="string", example="word_example")
     *         )
     *     )
     * )
     */
    public function getWords(): Response
    {
        return response($this->thesaurus->getWords());
    }

    /**
     * @OA\Get(
     *     path="/api/word/synonyms",
     *     tags={"Words: Synonyms"},
     *     summary="Get all synonyms of the word",
     *     @OA\Parameter(
     *         name="word",
     *         description="Word",
     *         in="query",
     *         required=true,
     *         example="example_word",
     *         @OA\Schema(
     *             type="string"
     *         )
     *     ),
     *     @OA\Response(
     *         response="200",
     *         description="Display synonyms of the word",
     *         @OA\JsonContent(
     *              type="array",
     *              @OA\Items(type="string", example="word_synonym_example")
     *         )
     *     )
     * )
     */
    public function getSynonyms(Request $request): Response
    {
        $request->validate([
            'word' => 'required|string|exists:App\Models\Word,name'
        ]);

        return response($this->thesaurus->getSynonyms($request->query('word')));
    }

    /**
     * @OA\Post(
     *     path="/api/word/synonyms",
     *     tags={"Words: Synonyms"},
     *     summary="Add synonyms of the word",
     *     @OA\RequestBody(
     *         @OA\JsonContent(
     *             @OA\Property(property="words", type="array", @OA\Items(type="string", example="example_word"))
     *         ),
     *     ),
     *     @OA\Response(
     *         response="204",
     *         description="Add synonyms of the word",
     *     )
     * )
     */
    public function addSynonyms(ThesaurusRequest $request): Response
    {
        $this->thesaurus->addSynonyms($request->safe()['words']);

        return response()->noContent();
    }
}
