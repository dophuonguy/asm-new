<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;

class CategoryController extends Controller
{

    public function index()
    {
        // Truy xuất danh mục "Chưa phân loại"
        $category_unclassified = Category::where('name', 'Chưa phân loại')->first();

        // Khởi tạo mảng để chứa các bài viết mới nhất
        $posts_new = [];

        // Kiểm tra xem danh mục đã được tìm thấy chưa
        if ($category_unclassified) {
            // Lấy các bài viết gần đây nhất từ ​​các danh mục khác nhau
            $posts_new[0] = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->take(1)->get();

            if ($posts_new[0]->isNotEmpty()) {
                $posts_new[1] = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $posts_new[0][0]->category->id)
                    ->take(1)->get();
            } else {
                $posts_new[1] = collect();// Khởi tạo dưới dạng bộ sưu tập trống nếu không có kết quả
            }

            if ($posts_new[1]->isNotEmpty()) {
                $posts_new[2] = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $posts_new[0][0]->category->id)
                    ->where('category_id', '!=', $posts_new[1][0]->category->id)
                    ->take(1)->get();
            } else {
                $posts_new[2] = collect(); // Khởi tạo dưới dạng bộ sưu tập trống nếu không có kết quả
            }

            if ($posts_new[2]->isNotEmpty()) {
                $posts_new[3] = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $posts_new[0][0]->category->id)
                    ->where('category_id', '!=', $posts_new[1][0]->category->id)
                    ->where('category_id', '!=', $posts_new[2][0]->category->id)
                    ->take(1)->get();
            } else {
                $posts_new[3] = collect(); // Khởi tạo dưới dạng bộ sưu tập trống nếu không có kết quả
            }
        } else {
            // Xử lý trường hợp không tìm thấy danh mục
            $posts_new = array_fill(0, 4, collect()); // Fill with empty collections
        }


        return view('categories.index', [
            'categories' => $categories = Category::where('name', '!=', 'Chưa phân loại')->orderBy('created_at', 'DESC')->take(10)->get(),
            'category_all' => Category::where('name', '!=', 'Chưa phân loại')->orderBy('created_at', 'DESC')->withCount('posts')->paginate(100),
            'posts_new' => $posts_new,

        ]);
    }

    public function show(Category $category)
    {

        $recent_posts = Post::latest()->take(5)->get();
        $categories = Category::where('name', '!=', 'Chưa phân loại')->withCount('posts')->orderBy('created_at', 'DESC')->take(10)->get();
        $tags = Tag::latest()->take(50)->get();

        /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
        $category_unclassified = Category::where('name', 'Chưa phân loại')->first();
        $posts_new = [];

        // Lấy bài viết đầu tiên  
        $firstPost = Post::latest()->approved()
            ->where('category_id', '!=', $category_unclassified->id)
            ->take(1)
            ->get();
        $posts_new[0] = $firstPost;

        if (!$firstPost->isEmpty()) {
            // Lấy bài viết thứ hai  
            $secondPost = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->where('category_id', '!=', $firstPost[0]->category->id)
                ->take(1)
                ->get();
            $posts_new[1] = $secondPost;

            if (!$secondPost->isEmpty()) {
                // Lấy bài viết thứ ba  
                $thirdPost = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $firstPost[0]->category->id)
                    ->where('category_id', '!=', $secondPost[0]->category->id)
                    ->take(1)
                    ->get();
                $posts_new[2] = $thirdPost;

                if (!$thirdPost->isEmpty()) {
                    // Lấy bài viết thứ tư  
                    $fourthPost = Post::latest()->approved()
                        ->where('category_id', '!=', $category_unclassified->id)
                        ->where('category_id', '!=', $firstPost[0]->category->id)
                        ->where('category_id', '!=', $secondPost[0]->category->id)
                        ->where('category_id', '!=', $thirdPost[0]->category->id)
                        ->take(1)
                        ->get();
                    $posts_new[3] = $fourthPost;
                }
            }
        }

        // Bài viết nổi bật  
        $outstanding_posts = Post::approved()
            ->where('category_id', '!=', $category_unclassified->id)
            ->take(5)
            ->get();

        return view('categories.show', [
            'category' => $category,
            'posts' => $category->posts()->approved()->orderBy('created_at', 'DESC')->paginate(10),
            'recent_posts' => $recent_posts,
            'categories' => $categories,
            'tags' => $tags,
            'posts_new' => $posts_new,
            'outstanding_posts' => $outstanding_posts, // bài viết xu hướng
        ]);
    }
}
