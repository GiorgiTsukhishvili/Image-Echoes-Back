<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
	use HasFactory;

	protected $hidden = ['pivot'];

	public function blogs()
	{
		return $this->belongsToMany(Blog::class, 'blog_tags');
	}
}
