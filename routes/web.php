<?php

use Illuminate\Support\Facades\Route;
use App\Post;
use App\Video;
use App\Tag;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/create', function () {

    for ($i = 1; $i <= 3; $i++) {

        Post::create([
            'name' => 'post' . $i,
        ]);

        Video::create([
            'name' => 'video' . $i,
        ]);
    }

    $post = Post::findOrFail(1);

    for ($i = 1; $i <= 3; $i++) {

        $post->tags()->create(['name' => 'tag' . $i]);
    }

    $video = Video::findOrFail(1);

    for ($i = 4; $i <= 9; $i++) {

        $video->tags()->create(['name' => 'tag' . $i]);
    }

    echo "Created Successful!";
});

Route::get('/read', function () {

    echo "Post-> Tag <br/>";
    $post = Post::findOrFail(1);

    $tags = $post->tags;


    foreach ($tags as $tag) {
        echo $tag->name . '<br/>';
    }

    echo "Tag -> Post <br/>";
    $tag = Tag::findOrFail(1);

    $posts = $tag->posts;

    foreach ($posts as $post) {
        echo $post->name . '<br/>';
    }

    echo "Video -> Tag <br/>";
    $video = Video::findOrFail(1);

    $tags = $video->tags;

    foreach ($tags as $tag) {
        echo $tag->name . '<br/>';
    }

    echo "Tag -> Video <br/>";
    $tag = Tag::findOrFail(9);

    $videos = $tag->videos;

    foreach ($videos as $video) {
        echo $video->name . '<br/>';
    }
});

Route::get('/update', function () {

    $post = Post::findOrFail(1);

    $tag = ['name' => 'tag1 updated'];

    $post->tags()->where('tag_id', 2)->update($tag);

    echo "Updated Successful!";

    // $post->tags()->attach(2);

    // $post->tags()->detach(2);

    $post->tags()->sync([1, 2, 3, 4, 5]);
});


Route::get('/delete', function () {

    $post = Post::findOrFail(1);

    $post->tags()->where('id', 1)->delete();

    echo "Deleted Successful!";
});