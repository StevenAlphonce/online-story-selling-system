<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Category;
use App\Models\ChapterVisit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrowseStoriesController extends Controller
{

    public function index()
    {

        $stories = Story::all();

        return view('browse.index', compact('stories'));
    }

    //Function to filter stories by their categories
    public function showStoriesByCategory(Category $category)
    {

        $stories = $category->stories()->get();

        return view('browse.stories-by-categories', compact('stories'));
    }

    //Function that fetch all chapters that relate to a particular story
    public function storyChapters(Story $story)
    {
        // Retrieve chapters where is_draft is false
        $chapters = $story->chapters()->where('is_draft', false)->get();
        // $chapters = $story->chapters; // Pointing relationship in the Story model
        $visitors = ChapterVisit::whereIn('chapter_id', $chapters->pluck('id'))->distinct('user_id')->count('user_id');


        if (Auth::check()) {

            $user = Auth::user();

            foreach ($chapters as $chapter) {
                ChapterVisit::firstOrCreate(
                    ['chapter_id' => $chapter->id, 'user_id' => $user->id]
                );
            }
        }


        return view('browse.story-preview', compact('story', 'chapters', 'visitors'));
    }
}
