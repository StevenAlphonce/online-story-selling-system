<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Story;
use App\Models\Chapter;
use Illuminate\Http\Request;

class ChapterController extends Controller
{
    /**
     * Display a listing of the Chapters.
     */
    public function index($id)
    {

        $story = Story::find($id);


        return view('story.create-edit-chapter', compact('story'));
    }


    /**
     * Show the form for creating a new chapter.
     */
    public function create(Story $story)
    {

        $isEdit = false;
        return view('story.create-edit-chapter', compact('story', 'isEdit'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Story $story)
    {

        $isEdit = false;
        // dd($request);
        $categories = Category::all();

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'min:50',
            'is_draft' => 'boolean',
        ]);

        $chapterNumber = $story->chapters()->count() + 1;

        $chapter = new Chapter();
        $chapter->story_id = $story->id;
        $chapter->chapter_number = $chapterNumber;
        $chapter->title = $request->title;
        $chapter->content = trim($request->content);
        $chapter->is_draft = $request->is_draft;
        $chapter->save();

        return view('story.edit-story', compact('story', 'isEdit', 'categories'));
    }

    /**
     * Method to show a specific chapter of a story
     */
    public function showChapter(Story $story, Chapter $chapter)
    {
        $chapters = $story->chapters;

        return view('stories.chapter', compact('story', 'chapter', 'chapters'));
    }


    /**
     * Show the view for writting the Chapter.
     */
    public function write(string $storyId, string $chapterId)
    {
        $isEdit = true;
        // Retrieve the story
        $story = Story::findOrFail($storyId);

        // Retrieve the chapter
        $chapter = Chapter::where('story_id', $storyId)
            ->findOrFail($chapterId);

        // Pass the story and chapter data to the view
        return view('story.create-edit-chapter', compact('story', 'chapter', 'isEdit'));
    }

    /**
     * Update the specified Chapter in storage.
     */
    public function update(Request $request, Story $story, Chapter $chapter)
    {
        // dd($request);
        $isEdit = true;
        $categories = Category::all();

        $request->validate([
            'title' => 'required|max:255',
            'content' => 'min:50',
            'is_draft' => 'boolean',
        ]);

        // Update the existing chapter's attributes
        $chapter->title = $request->title;
        $chapter->content = trim($request->content);
        $chapter->is_draft = $request->is_draft;

        // Save the updated chapter
        if (!$chapter->save()) {

            return redirect()->back();
        }

        return view('story.edit-story', compact('story', 'isEdit', 'categories'));
    }

    /**
     * Remove the specified Chapter from storage.
     */
    public function destroy(string $storyId, string $chapterId)
    {
        $story = Story::findOrFail($storyId);

        // Retrieve the chapter
        $chapter = Chapter::where('story_id', $storyId)
            ->findOrFail($chapterId);


        $chapter->delete();

        return redirect()->back();
    }

    //Retriving Chapter and convert it to Json
    public function content($storyId, $chapterId)
    {
        $chapter = Chapter::where('story_id', $storyId)->where('id', $chapterId)->firstOrFail();
        return response()->json(['title' => $chapter->title, 'content' => $chapter->content]);
    }
}
