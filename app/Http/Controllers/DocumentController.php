<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\StoreDocumentRequest;
use App\Http\Resources\DocumentResource;
use App\Models\Document;
use App\Models\Team;
use BombenProdukt\Lighty\Lighty;
use BombenProdukt\Lighty\Parser\DocumentParser;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

final class DocumentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Document::class, 'document');
    }

    public function index(Request $request, Team $team): AnonymousResourceCollection
    {
        return DocumentResource::collection($team->documents()->jsonPaginate());
    }

    public function store(StoreDocumentRequest $request, Team $team): DocumentResource
    {
        $document = (new DocumentParser())->parse(\base64_decode($request->get('body'), true));

        if ($request->has('language')) {
            $language = $team->findLanguage($request->get('language'));

            $document->setLanguage(empty($language->data) ? $language->name : $language->data);
        }

        if ($request->has('theme')) {
            $theme = $team->findTheme($request->get('theme'));

            $document->setTheme(empty($theme->data) ? $theme->name : $theme->data);
        }

        return DocumentResource::make(
            $team->documents()->firstOrCreate(
                [
                    'hash' => $document->hash(),
                ],
                [
                    'language_id' => $language->id,
                    'theme_id' => $theme->id,
                    'body' => $request->get('body'),
                    'html' => Lighty::highlight($document),
                ],
            ),
        );
    }

    public function show(Team $team, Document $document): DocumentResource
    {
        return DocumentResource::make($document);
    }

    public function destroy(Team $team, Document $document): Response
    {
        $document->delete();

        return response()->noContent(204);
    }
}
