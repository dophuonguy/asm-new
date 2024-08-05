<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Tag;
use App\Models\Category;
use App\Models\Post;

class TagController extends Controller
{
    public function index()
    {
        // view all categories in web
    }

    public function show(Tag $tag)
    {
        $recent_posts = Post::latest()->take(5)->get();
        $categories = Category::where('name', '!=', 'Chưa phân loại')->withCount('posts')->orderBy('created_at', 'DESC')->take(10)->get();
        $tags = Tag::latest()->take(50)->get();

        /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
        $category_unclassified = Category::where('name', 'Chưa phân loại')->first();

        $posts_new = [];

        // Bài viết đầu tiên  
        $posts_new[0] = Post::latest()->approved()
            ->where('category_id', '!=', $category_unclassified->id)
            ->take(1)->get();

        // Kiểm tra bài viết đầu tiên có tồn tại  
        if (!$posts_new[0]->isEmpty()) {
            // Bài viết thứ hai  
            $posts_new[1] = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->where('category_id', '!=', $posts_new[0][0]->category_id)
                ->take(1)->get();
        } else {
            $posts_new[1] = collect(); // Thay thế bằng một collection rỗng  
        }

        // Kiểm tra bài viết thứ hai có tồn tại  
        if (!$posts_new[1]->isEmpty()) {
            // Bài viết thứ ba  
            $posts_new[2] = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->where('category_id', '!=', $posts_new[0][0]->category_id)
                ->where('category_id', '!=', $posts_new[1][0]->category_id)
                ->take(1)->get();
        } else {
            $posts_new[2] = collect(); // Thay thế bằng một collection rỗng  
        }

        // Kiểm tra bài viết thứ ba có tồn tại  
        if (!$posts_new[2]->isEmpty()) {
            // Bài viết thứ tư  
            $posts_new[3] = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->where('category_id', '!=', $posts_new[0][0]->category_id)
                ->where('category_id', '!=', $posts_new[1][0]->category_id)
                ->where('category_id', '!=', $posts_new[2][0]->category_id)
                ->take(1)->get();
        } else {
            $posts_new[3] = collect(); // Thay thế bằng một collection rỗng  
        }

        // Bài viết nổi bật  
        $outstanding_posts = Post::approved()
            ->where('category_id', '!=', $category_unclassified->id)
            ->take(5)->get();
        return view('tags.show', [
            'tag' => $tag,
            'posts' => $tag->posts()->paginate(8),
            'recent_posts' => $recent_posts,
            'categories' => $categories,
            'tags' => $tags,
            'posts_new' => $posts_new,
            'outstanding_posts' => $outstanding_posts,
        ]);
    }
}
