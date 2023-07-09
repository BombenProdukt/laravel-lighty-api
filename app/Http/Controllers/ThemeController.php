<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreThemeRequest;
use App\Http\Resources\ThemeResource;
use App\Models\Team;
use App\Models\Theme;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class ThemeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Theme::class);
    }

    public function index(Request $request, Team $team): AnonymousResourceCollection
    {
        return ThemeResource::collection($team->themes()->jsonPaginate());
    }

    public function store(StoreThemeRequest $request, Team $team): ThemeResource
    {
        return ThemeResource::make(
            $team->themes()->firstOrCreate($request->validated()),
        );
    }

    public function show(Team $team, Theme $theme): ThemeResource
    {
        return ThemeResource::make($theme);
    }

    public function destroy(Team $team, Theme $theme): Response
    {
        $theme->delete();

        return response()->noContent(204);
    }
}
