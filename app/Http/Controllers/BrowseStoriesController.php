<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Category;
use Illuminate\Http\Request;

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

        return view('browse.story-preview', compact('story', 'chapters'));
    }
}
