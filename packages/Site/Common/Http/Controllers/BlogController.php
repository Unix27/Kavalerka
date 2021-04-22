<?php


namespace Site\Common\Http\Controllers;

use App\Http\Controllers\Controller;
use Blog\Models\BlogCategory;
use Blog\Models\BlogPost;
use Customers\Models\Customer;

use Illuminate\Database\Eloquent\Relations\Relation;

use http\Env\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Pages\Models\Page;

class BlogController extends Controller
{
	public function index($category = 'women'){

//		if(request()->ajax()) {
//			$input = request()->all();
//
//			$category_posts = BlogPost::where('category_id', '=', $input['id'])
//				->where('active', '=', 1)
//				->paginate(9);
//
//			return response()->json([
//				'input' => $input,
//				'count' => $category_posts->count(),
//				'html'  => view('site::blog.partials.articles')->with('category_posts',$category_posts)->render(),
//			]);
//		} else {
			$page = Page::where('slug', '=', 'blog')->first();
			$category = BlogCategory::whereTranslationLike('slug', $category)->first();
			$categories = BlogCategory::all();
			$category_posts = BlogPost::where('category_id', '=', $category->id)
				->join('blog_post_translations', 'post_id', '=', 'blog_posts.id')
				->where('locale', '=', app()->getLocale())
				->where('active', '=', 1)
				->paginate(9);

			return view('site::blog.index', compact(['page', 'categories', 'category_posts', 'category']));
	}

	public function show($category, $slug){

		$article = BlogPost::where('slug', '=', $slug)->first();
		$category = BlogCategory::whereTranslationLike('slug', $category)->first();
		$article->views += 1;
		$article->save();

		return view('site::blog.article', compact( [ 'article', 'category' ] ));
	}

	public function getPosts(){
		$input = request()->all();
		$page = $input['page'];
		$category_posts = BlogPost::join('blog_post_translations', 'blog_post_translations.post_id', 'blog_posts.id')
			->where('category_id', '=', $input['category_id'])
			->where('active', '=', 1)
			->where('locale', '=', app()->getLocale())
			->take(9)
			->skip(($page - 1) * 9)
			->paginate(9);

		exit(json_encode([
			'input' => $input,
			'html'  => view('site::blog.partials.articles')->with('category_posts',$category_posts)->render(),
			'count' => count($category_posts),
			'page'  => $page,
			'skip'  => ($page - 1) * 9,
			]));
	}

}
