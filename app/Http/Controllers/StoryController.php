<?php

namespace App\Http\Controllers;

use App\Models\Story;
use App\Models\Chapter;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class StoryController extends Controller
{
    //Function to show stories only to the Author(story owner)
    public function showStories()
    {
        $user_id = Auth::id(); // Variable to get the ID of the authenticated user
        $stories = Story::where('user_id', $user_id)->get(); // Fetch stories that belong to the authenticated user

        if (!$stories) {
            abort(404);
        }
        return view('story.stories', compact('stories'));
    }

    // Function return a view for creating story and initiate the first chapter
    public function createStory()
    {
        /**
         * Variable to store category and controlling story editing
         */
        $categories = Category::all();
        $isEdit = false;

        return view('story.create-story', compact('categories', 'isEdit'));
    }

    //Function to save the story and the initial untitled chapter
    public function saveStory(Request $request)
    {

        // dd($request);
        /**
         * Variables 
         *Get the authenticated user's ID and Category id
         */
        $user_id = Auth::id();
        $category_id = $request->input('category');
        $isEdit = false;

        //Story requests validations (Form)
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'story_title' => 'min:3|max:100',
            'story_description' => 'min:10',
            'main_character' => 'min:2|max:20',
            'category' => 'required',
            'tags',
            'copyright' => 'required',
            'rating'
        ]);


        //Creates new story object
        $story = new Story();

        //checking story  cover for uploading
        if ($request->hasFile('image')) {
            //Get the cover
            $cover = $request->file('image');
            /**Lets generate cover name by concatenating 
             *Story title and date.
             */
            $coverName = time() . '_' . $cover->getClientOriginalName();

            //Upload the image to the disk
            $story->cover = $cover->storeAs('story/cover', $coverName, 'public');
        }

        $story->user_id = $user_id;
        $story->description = trim($request->story_description);
        $story->main_character = trim($request->main_character);
        // $story->category_id = $request->$category_id; 
        $story->title = trim($request->story_title);
        $story->tags = $request->tags;
        // $story->copyright = $request->copyright;
        $story->rating = $request->rating;


        if ($story->save()) {

            $story->categories()->attach($category_id); // Story associated with category

            // Determine the chapter number
            $chapterNumber = $story->chapters()->count() + 1;

            $chapter = new Chapter();
            // Story chapter attributes

            $chapter->title = 'Untitled Chapter';
            $chapter->chapter_number = $chapterNumber;
            $chapter->content = '';
            $chapter->story_id = $story->id; //Chapter associate with a story

            $story->chapters()->save($chapter);

            return redirect()->route('chapter.write', ['story' => $story->id, 'chapter' => $chapter->id, 'isEdit']);
        } else {

            return redirect()->back();
        }
    }

    // Function that returns a view for a single story
    public function editStory($id)
    {

        $user_id = Auth::id(); // Variable to get the ID of the authenticated user
        $story = Story::where('user_id', $user_id)->find($id);
        if (!$story) {

            abort(404);
        }
        $categories = Category::all();

        return view('story.edit-story', compact('story', 'categories'));
    }

    // Function to update (save modified fields) a single story
    public function updateStory(Request $request, string $id)
    {
        /**
         * Variables 
         *Get the authenticated user's ID and Category id
         */
        $user_id = Auth::id();
        $category_id = $request->input('category');

        //Story requests validations (Form)
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'story_title' => 'min:3|max:100',
            'story_description' => 'min:10',
            'main_character' => 'min:2|max:20',
            'category' => 'required',
            'tags',
            'copyright' => 'required',
            'rating'
        ]);


        //Update story object

        $story = Story::where('user_id', $user_id)->findorFail($id);

        if (!$story) {

            abort(404);
        }


        // Check if the image field is updated
        if ($request->hasFile('image')) {
            // Delete the older image from the disk
            if ($story->cover) {
                Storage::disk('public')->delete($story->cover);
            }

            // Get the new cover image
            $cover = $request->file('image');
            $coverName = time() . '_' . $cover->getClientOriginalName();

            // Upload the new image to the disk
            $story->cover = $cover->storeAs('story/cover', $coverName, 'public');
        }

        $story->user_id = $user_id;
        $story->description = $request->story_description;
        $story->main_character = $request->main_character;
        // $story->category_id = $request->$category_id; 
        $story->title = $request->story_title;
        $story->tags = $request->tags;
        // $story->copyright = $request->copyright;
        $story->rating = $request->rating;

        if ($story->update()) {

            // Detach existing categories and attach the new one
            $story->categories()->sync([$category_id]);

            return redirect()->back()->with('success', 'Story was updated');
        } else {

            return redirect()->back();
        }
    }


    //Function to delete a single story
    public function deleteStory(String $id)
    {
        $user_id = Auth::id($id);
        $story = Story::where('user_id', $user_id)->findorFail($id);

        if (!$story) {

            abort(404);
        }

        // Delete the image file associated with the story

        if ($story->cover) {
            Storage::disk('public')->delete($story->cover);
        }


        $story->delete();
        return redirect(url('stories'));

        $story->delete();
        return redirect(url('stories'));
    }
}
