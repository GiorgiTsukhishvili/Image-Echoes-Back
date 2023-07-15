<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
	use HasApiTokens;

	use HasFactory;

	use Notifiable;

	protected $fillable = [
		'name',
		'email',
		'password',
		'background_image'
	];

	protected $hidden = [
		'password',
		'remember_token',
	];

	protected $casts = [
		'email_verified_at' => 'datetime',
		'password'          => 'hashed',
	];

	public function blogs()
	{
		return $this->hasMany(Blog::class);
	}

	public function collections()
	{
		return $this->hasMany(BlogCollection::class);
	}

	public function subscribers()
	{
		return $this->hasMany(Subscribe::class);
	}
}
