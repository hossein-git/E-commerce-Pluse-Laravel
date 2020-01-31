<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AppBaseController;
use App\Http\Controllers\Controller;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Laravelista\Comments\Comment;
use willvincent\Rateable\Rating;

class myCommentController extends AppBaseController
{
    private $comment;
    /**
     * @var CommentRepository
     */
    private $commentRepo;

    public function __construct(CommentRepository $repository)
    {
        $this->middleware(['checkRole']);
        $this->commentRepo = $repository;
        $this->comment = new Comment();
    }

    public function index()
    {
        $comments = $this->comment->orderBy('id', 'desc')->with('commenter', 'commentable')->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function newComments()
    {
        $comments = $this->comment->where('approved', 0)->with('commenter', 'commentable')->paginate(20);
        return view('admin.comments.index', compact('comments'));
    }

    public function approve($id)
    {
        $comment = $this->commentRepo->update(['approved' => 1], $id);
        if ($comment) {
            return $this->sendSuccess(__('models/comments.singular') . ' ' . __('messages.restored'));
        }
        return $this->sendError(__('models/comments.singular') . ' ' . __('messages.restoredFailed'));

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
            'rating' => 'nullable|numeric'
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
            if ($request->input('rating')) {
                $rating = new Rating();
                $rating->rating = $request->input('rating');
                $rating->user_id = auth()->id();
                $model->ratings()->save($rating);
            }

        }

        $comment->commentable()->associate($model);
        $comment->comment = $request->message;
        $comment->approved = !config('comments.approval_required');
        if ($comment->save()) {
            return $this->sendSuccess(__('models/comments.singular') . ' ' . __('messages.saved'));
        }
        return $this->sendError(__('models/comments.singular') . ' ' . __('messages.savedFailed'));

    }

    public function destroy($id)
    {
        $comment = $this->commentRepo->delete($id);
        return $this->commentRepo->passViewAfterDeleted($comment, 'comments');
    }


}
