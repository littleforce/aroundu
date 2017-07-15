<?php
namespace App\Transformers;

use App\User;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class UserTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'level' => $user->level,
            'effect' => $user->effect,
            'experience' => $user->experience,
            'created_at' => (string)$user->created_at,
            'updated_at' => (string)$user->updated_at,
            'article_count' => $user->articles->count(),
            'follower_count' => $user->followers->count(),
            'following_count' => $user->following->count(),
        ];
    }
}