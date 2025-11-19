<?php

namespace App\Http\Controllers;

use App\Http\Requests\TranslationRequest;
use App\Services\TranslationService;
use Illuminate\Http\Request;

class TranslatorController extends Controller
{
    public function __construct(protected TranslationService $translationService) {}

    public function index()
    {
        return view('open-translator');
    }

    public function translate(TranslationRequest $request)
    {
        $validated = $request->validatedData();
        $translatedText = $this->translationService->translateText($validated);

        return response()->json(['translatedText' => $translatedText]);
    }
}
