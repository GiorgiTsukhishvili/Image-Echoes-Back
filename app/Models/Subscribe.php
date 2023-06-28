<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
	use HasFactory;

	protected $fillable = ['user_id', 'subscribed_id'];

	public function user()
	{
		return $this->belongsTo(User::class);
	}

	public function subscribes()
	{
		return $this->hasMany(User::class, 'id', 'subscribed_id');
	}
}