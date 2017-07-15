<?php

namespace App\Http\Controllers\Api\V1;

use App\Transformers\ArticleSimpleTransformer;
use App\Transformers\CommentTransformer;
use App\Transformers\UserSimpleTransformer;
use Illuminate\Http\Request;
use App\User;
use App\Transformers\UserTransformer;
use Illuminate\Support\Facades\Input;

class UserController extends ApiController
{
    public function show($id)
    {
        $user = User::findOrFail($id);
//        $array = $user->toArray();
        return $this->response->item($user, new UserTransformer);
//        return response()->json($array);
    }

    public function update(Request $request)
    {
        $newUser = [
            'name' => $request->get('name'),
        ];
        $rules = [
            'name' => 'required|min:3|max:10|unique:users,name',
        ];
        $validator = \Validator::make($newUser, $rules);
        if ($validator->fails()) {
            throw new \Dingo\Api\Exception\StoreResourceFailedException('Could not change name.', $validator->errors());
        }
        $user = $this->auth->user();
        $user->name = $request->name;
        $user->save();
        return $this->response->noContent();
    }

    public function follow($id)
    {
        $user = $this->auth->user();
        if ($user->hasFollowed($id)) {
            return [
                'error' => 1,
                'message' => '已经关注！'
            ];
        } else {
            $user->followThisUser($id);
            return [
                'error' => 0,
                'message' => '关注成功！'
            ];
        }
    }

    public function unfollow($id)
    {
        $user = $this->auth->user();
        if ($user->hasFollowed($id)) {
            $user->unfollowThisUser($id);
            return [
                'error' => 0,
                'message' => '取消关注成功！'
            ];
        } else {
            return [
                'error' => 1,
                'message' => '已经取消关注！'
            ];
        }
    }

    public function articles($id)
    {
        $user = User::find($id);
        $array = $user->articles;
        return $this->response->collection($array, new ArticleSimpleTransformer);
    }

    public function followers($id)
    {
        $user = User::find($id);
        $array = $user->followers;
        return $this->response->collection($array, new UserTransformer);
    }

    public function following($id)
    {
        $user = User::find($id);
        $array = $user->following;
        return $this->response->collection($array, new UserTransformer);
    }

    public function comments($id)
    {
        $user = User::find($id);
        $array = $user->comments;
        return $this->response->collection($array, new CommentTransformer);
    }
}
