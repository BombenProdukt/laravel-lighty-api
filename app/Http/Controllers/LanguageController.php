<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreLanguageRequest;
use App\Http\Resources\LanguageResource;
use App\Models\Language;
use App\Models\Team;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class LanguageController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Language::class);
    }

    public function index(Request $request, Team $team): AnonymousResourceCollection
    {
        return LanguageResource::collection($team->languages()->jsonPaginate());
    }

    public function store(StoreLanguageRequest $request, Team $team): LanguageResource
    {
        return LanguageResource::make(
            $team->languages()->firstOrCreate($request->validated()),
        );
    }

    public function show(Team $team, Language $language): LanguageResource
    {
        return LanguageResource::make($language);
    }

    public function destroy(Team $team, Language $language): Response
    {
        $language->delete();

        return response()->noContent(204);
    }
}
