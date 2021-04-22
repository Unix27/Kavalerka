<?php


namespace Blog\Http\Controllers;


use Admin\Theme\Init;
use App\Http\Controllers\Controller;
use Blog\DataGrids\BlogPostsDataGrid;
use Blog\Models\BlogPost;
use Blog\Repositories\BlogPostRepository;
use Illuminate\Http\Request;
use Localization;


class PostsAdminController extends Controller
{
    protected $repository;

    public function __construct()
    {
        $this->middleware('admin');
        $this->repository = app(BlogPostRepository::class);
    }

    public function index()
    {
        $datagrid = new BlogPostsDataGrid();
        $page_title = 'Статьи';
        return view('admin::blog.posts.index', compact('datagrid', 'page_title'));
    }

    public function create()
    {
        config()->set('admin.layout.subheader.display', false);
        config()->set('admin.layout.content.width', 'fixed');
        Init::run();

        return view('admin::blog.posts.create');
    }

    public function edit(BlogPost $post)
    {
        config()->set('admin.layout.subheader.display', false);
        config()->set('admin.layout.content.width', 'fixed');
        Init::run();

        if (request()->has('locale')) {
            $editorLocale = request()->input('locale');
        } else {
            $editorLocale = Localization::getDefaultLocale();
        }

        $translation = $post->translations()->where('locale', $editorLocale)->first();

        return view('admin::blog.posts.edit', compact('post', 'editorLocale', 'translation'));
    }

    public function store(Request $request)
    {
        if ($request->has('post_id')) {
            $post = BlogPost::findOrFail($request->input('post_id'));
            $post = $this->repository->update($post, $request->all());
            return response()->json(['saved' => true]);
        }

        $post = $this->repository->create($request->all());
        return response()->json(['redirect_url' => route('admin.blog.posts.edit', $post->id)]);
    }

    public function publish($id)
    {
        $post = $this->repository->publish($id);

        return redirect()->back()
            ->with('success', 'Пост успешно опубликован');
    }

    public function unpublish($id)
    {
        $post = $this->repository->unpublish($id);

        return redirect()->back()
            ->with('success', 'Пост снят с публикации');
    }
}
