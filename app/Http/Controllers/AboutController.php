<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;

class AboutController extends Controller
{

    public function __invoke(Request $request)
    {
        // Bài viết mới nhất
        $recent_posts = Post::latest()->take(5)->get();
        $categories = Category::where('name', '!=', 'Chưa phân loại')
            ->withCount('posts')
            ->orderBy('created_at', 'DESC')
            ->take(10)
            ->get();

        /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
        $category_unclassified = Category::where('name', 'Chưa phân loại')->first();

        // Initialize arrays
        $posts_new = [];
        $uniqueCategories = [];

        // Proceed if the unclassified category exists
        if ($category_unclassified) {
            // Retrieve approved posts excluding 'Chưa phân loại' category
            $posts = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->with('category') // Eager load category to prevent N+1 queries
                ->get();

            // Filter and select posts from unique categories
            foreach ($posts as $post) {
                if (!in_array($post->category_id, $uniqueCategories) && count($posts_new) < 4) {
                    $posts_new[] = $post;
                    $uniqueCategories[] = $post->category_id; // Track used categories
                }
            }
        }

        // Handle cases where some posts might not be available
        foreach ($posts_new as $index => $post) {
            if (empty($post)) {
                $posts_new[$index] = null; // Or handle accordingly if needed
            }
        }

        // Bài viết nổi bật
        $outstanding_posts = Post::approved()
            ->when($category_unclassified, function ($query) use ($category_unclassified) {
                return $query->where('category_id', '!=', $category_unclassified->id);
            })
            ->take(5)
            ->get();

        // Bài viết theo lượt xem
        $viewPosts_category = Post::approved()
            ->when($category_unclassified, function ($query) use ($category_unclassified) {
                return $query->where('category_id', '!=', $category_unclassified->id);
            })
            ->orderBy('views', 'DESC')
            ->take(20)
            ->get();


        return view('about', [
            'categories' => $categories = Category::where('name', '!=', 'Chưa phân loại')->orderBy('created_at', 'DESC')->take(10)->get(),
            'posts_new' => $posts_new,
        ]);
    }
}
