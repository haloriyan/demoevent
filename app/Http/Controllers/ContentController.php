<?php

namespace App\Http\Controllers;

use App\Models\Content;
use App\Models\ContentSlide;
use App\Models\ContentSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ContentController extends Controller
{
    public function home(Request $request) {
        $subjects = $request->subjects;
        $negative = $request->negativeContents;

        $contents = Content::whereNotIn('id', $negative)
        ->whereHas('subjects', function ($query) use ($subjects) {
            $query->whereIn('subject', $subjects);
        })
        ->orderBy('created_at', 'DESC')
        ->with(['slides'])
        ->paginate(5);

        return response()->json([
            'contents' => $contents,
        ]);
    }
    public function preparation(Request $request) {
        $subjects = $request->subjects;
        $contents = [];
        
        $contentsRaw = Content::whereHas('subjects', function ($query) use ($subjects) {
            $query->whereIn('subject', $subjects);
        })
        ->orderBy('created_at', 'DESC')
        ->take(25)
        ->get();

        foreach ($contentsRaw as $cont) {
            if (!in_array($cont->title, $contents)) {
                array_push($contents, $cont->title);
            }
        }

        return response()->json([
            'contents' => $contents,
        ]);
    }
    public function store(Request $request) {
        $data = $request->konten;
        $subjects = $request->subjects;
        $slides = $request->slides;

        $content = Content::create([
            'title' => $data['title'],
            'description' => $data['short_description'],
            'cover' => $data['cover'],
            'level' => $request->level,
            'language' => $request->language,
            'photographer' => $data['photographer'],
            'photographer_url' => $data['photographer_url'],
        ]);

        foreach ($subjects as $subj) {
            ContentSubject::create([
                'content_id' => $content->id,
                'subject' => $subj,
            ]);
        }

        foreach ($data['slides'] as $slide) {
            ContentSlide::create([
                'content_id' => $content->id,
                'title' => $slide['title'],
                'body' => $slide['body'],
            ]);
        }

        return response()->json([
            'ok'
        ]);
    }
}
