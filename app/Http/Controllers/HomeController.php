<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Comment;
use App\Models\User;
use App\Models\Image;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index()
    {

        $posts = Post::latest()
            ->approved()
            // where('approved',1)
            ->withCount('comments')->paginate(8);
        // phân trang 8 bài
        $recent_posts = Post::latest()->take(5)->get();
        $categories = Category::where('name', '!=', 'Chưa phân loại')->orderBy('created_at', 'DESC')->take(10)->get();
        // $categories = Category::where('name','!=','Chưa phân loại')->withCount('posts')->orderBy('posts_count', 'desc')->take(10)->get();
        $tags = Tag::latest()->take(50)->get();


        /*----- Lấy ra 4 bài viết mới nhất theo các danh mục khác nhau -----*/
        $category_unclassified = Category::where('name', 'Chưa phân loại')->first();

        if (!$category_unclassified) {
            // Handle the case where the "Chưa phân loại" category doesn't exist
            $posts_new = [collect(), collect(), collect(), collect()];
        } else {
            $posts_new = [];

            $posts_new[0] = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->take(1)->get();

            if ($posts_new[0]->isNotEmpty()) {
                $posts_new[1] = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $posts_new[0][0]->category_id)
                    ->take(1)->get();
            } else {
                $posts_new[1] = collect(); // Tạo một bộ sưu tập rỗng nếu không có bài viết nào  
            }

            if ($posts_new[1]->isNotEmpty()) {
                $posts_new[2] = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $posts_new[0][0]->category_id)
                    ->where('category_id', '!=', $posts_new[1][0]->category_id)
                    ->take(1)->get();
            } else {
                $posts_new[2] = collect(); // Tạo một bộ sưu tập rỗng nếu không có bài viết nào  
            }

            if ($posts_new[2]->isNotEmpty()) {
                $posts_new[3] = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $posts_new[0][0]->category_id)
                    ->where('category_id', '!=', $posts_new[1][0]->category_id)
                    ->where('category_id', '!=', $posts_new[2][0]->category_id)
                    ->take(1)->get();
            } else {
                $posts_new[3] = collect(); // Tạo một bộ sưu tập rỗng nếu không có bài viết nào  
            }
        }


        // Lấy ra tin nổi bật -- Lấy theo views  
        $outstanding_posts = Post::orderBy('views', 'DESC')->take(5)->get();

        // Lấy ra tất cả danh mục tin tức 
        $stt_home = 0;
        $category_home = Category::where('name', '!=', 'Chưa phân loại')->orderBy('created_at', 'DESC')->take(10)->get();

        // Initialize variables
        $post_category_home0 = collect();
        $post_category_home1 = collect();
        $post_category_home2 = collect();
        $post_category_home3 = collect();
        $post_category_home4 = collect();
        $post_category_home5 = collect();
        $post_category_home6 = collect();
        $post_category_home7 = collect();
        $post_category_home8 = collect();
        $post_category_home9 = collect();

        foreach ($category_home as $category_item) {
            // Tạo tin tức mới nhất cho layout master
            $stt_home = $stt_home + 1;
            if ($stt_home === 1)
                $post_category_home0 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(5)->get();
            if ($stt_home === 2)
                $post_category_home1 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(6)->get();
            if ($stt_home === 3)
                $post_category_home2 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(8)->get();
            if ($stt_home === 4)
                $post_category_home3 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(5)->get();
            if ($stt_home === 5)
                $post_category_home4 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(6)->get();
            if ($stt_home === 6)
                $post_category_home5 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(5)->get();
            if ($stt_home === 7)
                $post_category_home6 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(5)->get();
            if ($stt_home === 8)
                $post_category_home7 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(5)->get();
            if ($stt_home === 9)
                $post_category_home8 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(8)->get();
            if ($stt_home === 10)
                $post_category_home9 = Post::latest()->approved()->withCount('comments')->where('category_id', $category_item->id)->take(4)->get();
        }

        // Ý kiến người đọc, comments
        $top_commnents = Comment::take(5)->get();

        return view('home', [
            'posts' => $posts,
            'recent_posts' => $recent_posts,
            'posts_new' => $posts_new, // Bài viết mới nhất theo mục
            'post_category_home0' => $post_category_home0, // Bài viết danh mục 5
            'post_category_home1' => $post_category_home1, // Bài viết danh mục 1
            'post_category_home2' => $post_category_home2, // Bài viết danh mục 2
            'post_category_home3' => $post_category_home3, // Bài viết danh mục 3
            'post_category_home4' => $post_category_home4, // Bài viết danh mục 4
            'post_category_home5' => $post_category_home5, // Bài viết danh mục 10
            'post_category_home6' => $post_category_home6, // Bài viết danh mục 6
            'post_category_home7' => $post_category_home7, // Bài viết danh mục 7
            'post_category_home8' => $post_category_home8, // Bài viết danh mục 8
            'post_category_home9' => $post_category_home9, // Bài viết danh mục 9
            'outstanding_posts' => $outstanding_posts, // Bài viết nổi bật
            'categories' => $categories,
            'category_home' => $category_home,
            'tags' => $tags,
            'top_commnents' => $top_commnents, // Lấy ý kiến người đọc mới nhất
        ]);

    }

    public function search(Request $request)
    {

        $recent_posts = Post::latest()->take(5)->get();
        $categories = Category::where('name', '!=', 'Chưa phân loại')->withCount('posts')->orderBy('created_at', 'DESC')->take(10)->get();

        // Get the 'Chưa phân loại' category
        $category_unclassified = Category::where('name', 'Chưa phân loại')->first();

        if (!$category_unclassified) {
            // Handle the case where the category 'Chưa phân loại' does not exist
            $posts_new = array_fill(0, 4, null);
        } else {
            $posts_new = [];
            $excluded_categories = [$category_unclassified->id];

            for ($i = 0; $i < 4; $i++) {
                $query = Post::latest()->approved()
                    ->whereNotIn('category_id', $excluded_categories)
                    ->take(1);

                $posts_new[$i] = $query->get();

                if ($posts_new[$i]->isNotEmpty()) {
                    // Add the category of the found post to the exclusion list for the next iteration
                    $excluded_categories[] = $posts_new[$i][0]->category->id;
                } else {
                    // If no post is found, add null or handle accordingly
                    $posts_new[$i] = null;
                }
            }
        }

        // Now $posts_new contains up to 4 posts or null values if some posts were not found


        // Bài viết nổi bật
        $outstanding_posts = Post::approved()->where('category_id', '!=', $category_unclassified->id)->take(5)->get();

        $key = $request->search;
        // tìm kiếm kết quả danh mục
        // $cat = Category::where('name','like' , '%'.$key.'%')->first();
        // $pro = Category::where('name','like' , '%'.$key.'%')->first();

        $posts = Post::latest()->withCount('comments')->approved()->where('title', 'like', '%' . $key . '%')->paginate(30);

        $title = 'Kết quả tìm kiếm';
        $title_t = 'Kết quả tìm kiếm theo';
        $time = '(0,36 giây) ';

        return view('search', compact('posts', 'title', 'time', 'recent_posts', 'categories', 'key', 'posts_new', 'outstanding_posts'));
    }

    public function newPost()
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
        $posts_new = [];

        // Check if the unclassified category exists
        if ($category_unclassified) {
            // Lấy bài viết đầu tiên  
            $firstPost = Post::latest()->approved()
                ->where('category_id', '!=', $category_unclassified->id)
                ->take(1)
                ->get();
            $posts_new[0] = $firstPost;

            // Kiểm tra bài viết đầu tiên có tồn tại hay không  
            if (!$firstPost->isEmpty()) {
                // Lấy bài viết thứ hai  
                $secondPost = Post::latest()->approved()
                    ->where('category_id', '!=', $category_unclassified->id)
                    ->where('category_id', '!=', $firstPost[0]->category->id)
                    ->take(1)
                    ->get();
                $posts_new[1] = $secondPost;

                // Kiểm tra bài viết thứ hai có tồn tại hay không  
                if (!$secondPost->isEmpty()) {
                    // Lấy bài viết thứ ba  
                    $thirdPost = Post::latest()->approved()
                        ->where('category_id', '!=', $category_unclassified->id)
                        ->where('category_id', '!=', $firstPost[0]->category->id)
                        ->where('category_id', '!=', $secondPost[0]->category->id)
                        ->take(1)
                        ->get();
                    $posts_new[2] = $thirdPost;

                    // Kiểm tra bài viết thứ ba có tồn tại hay không  
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
        }

        // Bài viết nổi bật  
        $outstanding_posts = Post::approved()
            ->when($category_unclassified, function ($query) use ($category_unclassified) {
                return $query->where('category_id', '!=', $category_unclassified->id);
            })
            ->take(5)
            ->get();



        $newPosts_category = Post::latest()->approved()
            ->when($category_unclassified, function ($query) use ($category_unclassified) {
                return $query->where('category_id', '!=', $category_unclassified->id);
            })
            ->take(20)
            ->get();

        return view(
            'newPost',
            compact(
                'recent_posts',
                'categories',
                'posts_new',
                'outstanding_posts',
                'newPosts_category'
            )
        );
    }

    public function hotPost()
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
        $posts_new = [];

        // Check if the unclassified category exists
        if ($category_unclassified) {
            // Define a function to get a post from the latest approved posts excluding specific category IDs
            function getLatestPostExcludingCategories($excludedCategoryIds, $limit = 1)
            {
                return Post::latest()->approved()
                    ->whereNotIn('category_id', $excludedCategoryIds)
                    ->take($limit)
                    ->get();
            }

            // Lấy bài viết đầu tiên
            $firstPost = getLatestPostExcludingCategories([$category_unclassified->id]);
            if (!$firstPost->isEmpty()) {
                $posts_new[0] = $firstPost[0];

                // Lấy bài viết thứ hai
                $excludedCategories = [$category_unclassified->id, $firstPost[0]->category_id];
                $secondPost = getLatestPostExcludingCategories($excludedCategories);
                if (!$secondPost->isEmpty()) {
                    $posts_new[1] = $secondPost[0];

                    // Lấy bài viết thứ ba
                    $excludedCategories = array_merge($excludedCategories, [$secondPost[0]->category_id]);
                    $thirdPost = getLatestPostExcludingCategories($excludedCategories);
                    if (!$thirdPost->isEmpty()) {
                        $posts_new[2] = $thirdPost[0];

                        // Lấy bài viết thứ tư
                        $excludedCategories = array_merge($excludedCategories, [$thirdPost[0]->category_id]);
                        $fourthPost = getLatestPostExcludingCategories($excludedCategories);
                        if (!$fourthPost->isEmpty()) {
                            $posts_new[3] = $fourthPost[0];
                        }
                    }
                }
            }
        }

        // Bài viết nổi bật
        $outstanding_posts = Post::approved()
            ->when($category_unclassified, function ($query) use ($category_unclassified) {
                return $query->where('category_id', '!=', $category_unclassified->id);
            })
            ->take(5)
            ->get();



        // Define an array of category names
        $categoryNames = [
            'Pháp luật' => 'category_phap_luat',
            'Kinh tế' => 'category_kinh_te',
            'Xã hội' => 'category_xa_hoi',
            'Khoa học' => 'category_khoa_hoc',
            'Thế giới' => 'category_the_gioi',
        ];

        // Initialize an empty array to hold the hot posts
        $hotPosts_category = [];

        // Retrieve categories and fetch posts
        foreach ($categoryNames as $name => $variable) {
            // Retrieve the category by name
            $category = Category::where('name', $name)->first();

            // If the category exists, fetch the posts
            if ($category) {
                $hotPosts_category[$variable] = Post::approved()
                    ->where('category_id', $category->id)
                    ->orderBy('created_at', 'DESC')
                    ->take(4)
                    ->get();
            } else {
                // If the category doesn't exist, initialize an empty collection
                $hotPosts_category[$variable] = collect();
            }
        }

        // $hotPosts_category now contains the hot posts for each category or an empty collection if the category was not found


        return view(
            'hotPost',
            compact(
                'recent_posts',
                'categories',
                'posts_new',
                'outstanding_posts',
                'hotPosts_category'
            )
        );
    }

    public function viewPost()
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

        return view(
            'viewPost',
            compact(
                'recent_posts',
                'categories',
                'posts_new',
                'outstanding_posts',
                'viewPosts_category'
            )
        );
    }

    public function erorr404()
    {
        return view('errors.404');
    }

    public function profile()
    {
        return view('profile');
    }

    private $rules = [
        'name' => 'required|min:3',
        'email' => 'required|email|unique:users,email',
        'image' => 'nullable|file|mimes:jpg,png,webp,svg,jpeg|dimensions:max-width:300,max-height:300',
    ];

    public function update(Request $request)
    {
        $user = auth()->user();

        if ($request->email !== $user->email) {
            $this->rules['email'] = ['required', 'email', Rule::unique('users')->ignore($user)];
        } else {
            $this->rules['email'] = '';
        }

        $validated = $request->validate($this->rules);
        $user->update($validated);

        if ($request->has('image')) {
            $image_user = Image::where('imageable_id', $user->id)->first();
            if ($image_user)
                $image_user->delete();

            $image = $request->file('image');
            $filename = $image->getClientOriginalName();
            $file_extension = $image->getClientOriginalExtension();
            $path = $image->store('images', 'public');

            $user->image()->create([
                'name' => $filename,
                'extension' => $file_extension,
                'path' => $path,
            ]);
        }

        return redirect()->route('profile')->with('success', 'Sửa tài khoản thành công.');
    }

}
