<?php

namespace Tests\Unit;

use App\Post;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Category;
use Tests\CreatesApplication;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Laravel\BrowserKitTesting\TestCase as BaseTestCase;


class CategoryTest extends BaseTestCase
{
    use CreatesApplication;
    public $baseUrl = 'http://localhost';
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testAddTest()
    {
        $posts = Post::all();
        $oldcount = Post::all()->count();
        $this->visit('/categories/'.$posts->first()->category_id)
            ->click('Create a new post')
            ->seePageIs('/categories/'.$posts->first()->category_id.'/posts/create')
            ->type('PostNameTest','name')
            ->type('PostContentTest','content')
            ->type($posts->first()->category_id,'category_id')
            ->type('C:\OSPanel\domains\blogMMG\public\img\amazing-desktopography-world.jpg','file')
            ->press('Ok')
            ->seePageIs('/categories/'.$posts->first()->category_id.'/posts/'.Post::all()->last()->id)
        ;
        $newcount = Post::all()->count();
        $this->assertEquals($oldcount+1,$newcount);
        $this->seeInDatabase('Posts',['name'=>'PostNameTest','content'=>'PostContentTest','category_id'=>$posts->first()->category_id]);

    }

    public function testEditTest()
    {
        $post = Post::all()->last();
        $oldcount = Post::all()->count();
        $this->visit('/categories/'.$post->category_id.'/posts/'.$post->id)
            ->click('edit')
            ->see('Edit')
            ->seePageIs('/categories/'.$post->category_id.'/posts/'.$post->id.'/edit')
            ->type('PostEditedTest','name')
            ->type('PostEditedContentTest','content')
            ->type(Post::all()->first()->category_id,'category_id')
            ->type('C:\OSPanel\domains\blogMMG\public\img\chili-vulkan-molnii.jpg','file')
            ->press('Ok')
            ->seePageIs('/categories/'.$post->category_id.'/posts/'.$post->id)
        ;
        $newcount = Post::all()->count();
        $this->assertEquals($oldcount,$newcount);
        $this->seeInDatabase('Posts',['name'=>'PostEditedTest','content'=>'PostEditedContentTest','category_id'=>$post->category_id]);

    }
    public function testDeleteTest()
    {
        $post = Post::all()->last();
        $oldcount = Post::all()->count();
        $this->visit('/categories/'.$post->category_id.'/posts/'.$post->id)
            ->press('delete')
            ->seePageIs('/categories/'.$post->category_id)
            ;
        $newcount = Post::all()->count();
        $this->assertEquals($oldcount-1,$newcount);
    }

}
