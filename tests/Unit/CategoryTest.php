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
    public function testCreatedTest()
    {
        $add =2;
        $oldcount = Category::all()->count()+$add;
        factory(Category::class,$add)->create(['created_at'=>now()]);
        $newcount = Category::all()->count();
        $this->assertEquals($oldcount,$newcount);
    }
    public function testAddTest()
    {
        $oldcount = Category::all()->count();
        $this->visit('/categories')
            ->click('Create')
            ->seePageIs('/categories/create')
            ->type('Psychology','name')
            ->type('Some information about what you need','description')
            ->press('Ok')
            ->seePageIs('/categories')
        ;
        $newcount = Category::all()->count();
        $this->assertEquals($oldcount+1,$newcount);
        $this->seeInDatabase('Categories',['name'=>'Psychology','description'=>'Some information about what you need']);

    }
    public function testNamesOfCategoriesTest()
    {
        $categories = Category::all();
        foreach ($categories as $category)
        $this->visit('/categories')
            ->see($category->name)
        ;

    }
    public function testPostsOfCategoryTest()
    {
        $category = Category::all()->first();
        $posts = Post::all()->where('category_id',$category->id);
        foreach ($posts as $post)
            $this->visit('/categories')
                ->click('posts-'.$category->id)
                ->seePageIs('/categories/'.$category->id)
                ->see($category->name)
                ->see($post->name)
                ;

    }
    public function testEditTest()
    {
        $oldcount = Category::all()->count();
        $somecategory = Category::all()->first();
        $this->visit('/categories')
            ->click('edit-'.$somecategory->id)
            ->see('Edit')
            ->seePageIs('/categories/'.$somecategory->id.'/edit')
            ->type('Biology','name')
            ->type('Some information about what you need','description')
            ->press('Ok')
            ->seePageIs('/categories')
        ;
        $newcount = Category::all()->count();
        $this->assertEquals($oldcount,$newcount);
        $this->seeInDatabase('Categories',['id'=>$somecategory->id,'name'=>'Biology','description'=>'Some information about what you need']);

    }
    public function testDeleteTest()
    {
        $oldcount = Category::all()->count();
        $somecategory = Category::all()->last();
        $url = '/categorydestroy';
        $this->post($url, ['category_id' => $somecategory->id])
            ->seeJson([$somecategory->id]);
        $newcount = Category::all()->count();
        $this->assertEquals($oldcount-1,$newcount);

    }
    protected function ajaxPost($uri, array $data = [])
    {
        return $this->post($uri, $data, array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    }

    /**
     * Make ajax GET request
     */
    protected function ajaxGet($uri, array $data = [])
    {
        return $this->get($uri, array('HTTP_X-Requested-With' => 'XMLHttpRequest'));
    }


}
