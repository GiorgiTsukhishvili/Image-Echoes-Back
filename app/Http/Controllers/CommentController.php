<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentStoreRequest;
use App\Models\Blog;
use App\Models\Comment;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;

class CommentController extends Controller
{
	public function __construct(private Notification $notification)
	{
	}

	public function store(CommentStoreRequest $request): JsonResponse
	{
		$data = $request->validated();

		$comment = Comment::create([
			'user_id' => auth()->user()->id,
			'blog_id' => $data['blog_id'],
			'comment' => $data['comment'],
		]);

		$blog = Blog::firstWhere('id', $data['blog_id']);

		$this->notification->make($blog->user_id, auth()->user()->id, 'comment', $blog->id);

		return response()->json($comment, 200);
	}
}
