<?php
namespace App\Transformers;

use App\User;
use League\Fractal;
use League\Fractal\TransformerAbstract;

class UserSimpleTransformer extends TransformerAbstract
{
    public function transform(User $user)
    {
        return [
            'id' => $user->id,
            'name' => $user->name,

            'link' => ['uri' => '/user/'.$user->id],
        ];
    }
}