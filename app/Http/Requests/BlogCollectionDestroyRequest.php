<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogCollectionDestroyRequest extends FormRequest
{
	public function authorize(): bool
	{
		$blogCollection = $this->route('collection');

		return $blogCollection->user_id === auth()->user()->id;
	}

	public function rules(): array
	{
		return [
		];
	}
}
