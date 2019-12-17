<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravelista\Comments\Comment;
use willvincent\Rateable\Rating;

class myCommentController extends Controller
{
    private $comment;

    public function __construct()
    {
        $this->middleware(['checkRole']);
        $this->comment = new Comment();
    }

    public function index()
    {
        $comments  = $this->comment->orderBy('id','desc')->with('commenter','commentable')->paginate(20);
        return view('admin.comments.index',compact('comments'));
    }

    public function newComments()
    {
        $comments  = $this->comment->where('approved' , 0 )->with('commenter','commentable')->paginate(20);
        return view('admin.comments.index',compact('comments'));
    }

    public function approve($id)
    {
        if (ctype_digit($id)){
            $comment = $this->comment->findOrFail($id)->update(['approved' => 1]);
            return response()->json(['success' => $comment]);
        }
    }

    public function store(Request $request)
    {
        // If guest commenting is turned off, authorize this action.
        if (config('comments.guest_commenting') == false) {
            $this->authorize('create-comment', Comment::class);
        }

        // Define guest rules if user is not logged in.
        if (!auth()->check()) {
            $guest_rules = [
                'guest_name' => 'required|string|max:255',
                'guest_email' => 'required|string|email|max:255',
            ];
        }

        // Merge guest rules, if any, with normal validation rules.
        $this->validate($request, array_merge($guest_rules ?? [], [
            'commentable_type' => 'required|string',
            'commentable_id' => 'required|string|min:1',
            'message' => 'required|string',
            'rating'  => 'nullable|numeric'
        ]));

        $model = $request->commentable_type::findOrFail($request->commentable_id);

        $commentClass = config('comments.model');
        $comment = new $commentClass;

        if (!auth()->check()) {
            $comment->guest_name = $request->guest_name;
            $comment->guest_email = $request->guest_email;
        } else {
            $comment->commenter()->associate(auth()->user());
            //save rating
            if ($request->input('rating')){
                $rating = new Rating();
                $rating->rating = $request->input('rating');
                $rating->user_id = auth()->id();
                $model->ratings()->save($rating);
            }

        }

        $comment->commentable()->associate($model);
        $comment->comment = $request->message;
        $comment->approved = !config('comments.approval_required');
        $comment->save();

        return response()->json(['success' => 'ok'],200);
    }

    public function destroy($id)
    {
        $this->comment->findOrFail($id)->delete();
        return response()->json(['success' => 'ok']);
    }


}
