<?php
/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/
use App\Category;
use App\Post;
use App\Product;

Route::resource('admin/posts', 'PostsController');
Route::resource('admin/categories', 'CategoriesController');
Route::resource('admin/questions', 'QuestionsController');
Route::resource('admin/products', 'ProductsController');
Route::resource('admin/settings', 'SettingsController');
Route::resource('admin/contacts', 'ContactsController');
Route::resource('admin/videos', 'VideosController');


Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);


Route::post('saveContact', ['as' => 'saveContact', 'uses' => 'MainController@saveContact']);
Route::post('createQuestion', ['as' => 'createQuestion', 'uses' => 'MainController@createQuestion']);
Route::post('registerEmail', ['as' => 'registerEmail', 'uses' => 'MainController@registerEmail']);

Route::get('admin', 'AdminController@index');
Route::get('tim-kiem', 'MainController@search');

Route::get('san-pham/{value?}', 'MainController@product');
Route::get('video/{value?}', 'MainController@video');
Route::get('phan-phoi', 'MainController@phanphoi');
Route::get('lien-he', 'MainController@lienhe');



Route::get('/', 'MainController@index');

Route::get('{value}', function ($value) {
    if (preg_match('/([a-z0-9\-]+)\.html/', $value, $matches)) {
        $page = 'post_detail';
        $post = Post::where('slug', $matches[1])->first();

        return view('frontend.post_detail', compact('post', 'page'))->with([
            'meta_title' => $post->title . ' | Giảo Cổ Lam',
            'meta_desc' => $post->desc,
            'meta_keywords' => ($post->tagList) ? implode(',', $post->tagList) : 'Giảo Cổ Lam, huongdan, bai viet',
        ]);
    } else {
        $page = $value;

        if ($value == 'hoi-dap-chuyen-gia') {
            $questions = \App\Question::paginate(10);
            return view('frontend.'.$value, compact('page', 'questions'))->with([
                'meta_title' => (!empty($settings['meta_title'])) ? $settings['meta_title'] : 'Giảo Cổ Lam',
                'meta_desc' => (!empty($settings['meta_desc'])) ? $settings['meta_desc'] : 'Giảo Cổ Lam',
                'meta_keywords' => (!empty($settings['meta_keywords'])) ? $settings['meta_keywords'] : 'Giảo Cổ Lam',
            ]);
        }
        $category = Category::where('slug', $value)->first();

        return view('frontend.category', compact(
            'category', 'page'
        ))->with([
            'meta_title' => (!empty($settings['meta_title'])) ? $settings['meta_title'] : $category->name.' | Giảo Cổ Lam',
            'meta_desc' => (!empty($settings['meta_desc'])) ? $settings['meta_desc'] : $category->name.' Giảo Cổ Lam',
            'meta_keywords' => (!empty($settings['meta_keywords'])) ? $settings['meta_keywords'] : 'Giảo Cổ Lam',
        ]);
    }
});




