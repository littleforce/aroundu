<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/

/** @var \Illuminate\Database\Eloquent\Factory $factory */
$factory->define(App\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'password' => $password ?: $password = bcrypt('secret'),
        'avatar' => $faker->imageUrl(),
        'remember_token' => str_random(10),
    ];
});

$factory->define(App\Article::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    return [
        'user_id' =>  $user_ids,
        'title' => $faker->sentence(mt_rand(3,10)),
        'content' => $faker->text(),
        'image' => $faker->imageUrl(),
        'location' => "{\"uid\": \"8eb48fa1321a56bff32d8323\", \"url\": \"http://map.baidu.com/?s=inf%26uid%3D8eb48fa1321a56bff32d8323%26c%3D125&i=0&sr=1\", \"city\": \"海口市\", \"tags\": [\"餐饮\"], \"type\": 0, \"point\": {\"lat\": 20.026771, \"lng\": 110.328649}, \"title\": \"上邦百汇城\", \"address\": \"上邦百汇城位于海口市龙华路98号\", \"postcode\": \"570105\", \"province\": \"海南省\", \"detailUrl\": \"http://api.map.baidu.com/place/detail?uid=8eb48fa1321a56bff32d8323&output=html&source=jsapi\", \"isAccurate\": true, \"phoneNumber\": \"(0898)68571118\"}",
        'type' => 1,
    ];
});

$factory->define(App\Comment::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    $upper_ids = \App\User::pluck('id')->random();
    $commentable_ids = \App\Article::pluck('id')->random();
    return [
        'user_id' =>  $user_ids,
        'content' => $faker->text(),
        'upper_id' => $upper_ids,
        'commentable_id' => $commentable_ids,
        'commentable_type' => 'App\Article',
    ];
});

$factory->define(App\Vote::class, function (Faker\Generator $faker) {
    $user_ids = \App\User::pluck('id')->random();
    if (random_int(1,100)%4 >2) {
        $votable_ids = \App\Comment::pluck('id')->random();
        $votable_type = 'App\Comment';
    } else {
        $votable_ids = \App\Article::pluck('id')->random();
        $votable_type = 'App\Article';
    }
    return [
        'user_id' =>  $user_ids,
        'votable_id' => $votable_ids,
        'votable_type' => $votable_type,
    ];
});

$factory->define(App\Follow::class, function (Faker\Generator $faker) {
    $follower_ids = \App\User::pluck('id')->random();
    $followed_ids = \App\User::pluck('id')->random();
    return [
        'follower_id' => $follower_ids,
        'followed_id' => $followed_ids,
    ];
});