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

    public function getWords(): Response
    {
        return response($this->thesaurus->getWords());
    }

    public function getSynonyms(Request $request): Response
    {
        $request->validate([
            'word' => 'required|string|exists:App\Models\Word,name'
        ]);

        return response($this->thesaurus->getSynonyms($request->query('word')));
    }

    public function addSynonyms(ThesaurusRequest $request): Response
    {
        $this->thesaurus->addSynonyms($request->safe()['words']);

        return response()->noContent();
    }
}
