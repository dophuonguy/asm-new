<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Contact;
use App\Mail\ContacMail;
use Illuminate\Support\Facades\Validator;

use App\Models\Category;
use App\Models\Post;

class ContactController extends Controller
{
    public function create()
    {
        // Get the 'Chưa phân loại' category
        $category_unclassified = Category::where('name', 'Chưa phân loại')->first();

        if ($category_unclassified) {
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
        } else {
            // Handle the case where 'Chưa phân loại' category was not found
            $posts_new = array_fill(0, 4, null);
        }

        // Now $posts_new contains up to 4 posts or null values if some posts were not found


        return view('contact', [
            'categories' => $categories = Category::where('name', '!=', 'Chưa phân loại')->orderBy('created_at', 'DESC')->take(10)->get(),
            'posts_new' => $posts_new,
        ]);
    }

    public function store()
    {

        $data = array();
        $data['success'] = 0;
        $data['errors'] = [];


        $rules = [
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required',
            // 'subject' => 'nullable|min:5|max:50',
            'subject' => 'required|min:5|max:50',
            'message' => 'required|min:5|max:500',
        ];

        $validated = Validator::make(request()->all(), $rules);


        if ($validated->fails()) {
            $data['errors']['first_name'] = $validated->errors()->first('first_name');
            $data['errors']['last_name'] = $validated->errors()->first('last_name');
            $data['errors']['email'] = $validated->errors()->first('email');
            $data['errors']['subject'] = $validated->errors()->first('subject');
            $data['errors']['message'] = $validated->errors()->first('message');

            $data['message'] = "Thông báo lỗi: kiểm tra thông tin và nhập lại lần nữa";

        } else {
            $attributes = $validated->validated();
            Contact::create($attributes);

            // Mail::to("anhtuanlop10a2812001@gmail.com")->send(new ContacMail(
            Mail::to(env('ADMIN_EMAIL'))->send(
                new ContacMail(
                    $attributes['first_name'],
                    $attributes['last_name'],
                    $attributes['email'],
                    $attributes['subject'],
                    $attributes['message']
                )
            );

            $data['success'] = 1;
            $data['message'] = "Bạn đã gửi liên hệ thành công. Chúng tôi sẽ phản hổi cho bạn sớm nhất có thể";

        }


        // return redirect()->route('contact.create')->with('success', 
        // 'Bạn đã gửi liên hệ thành công. Chúng tôi sẽ phản hổi cho bạn sớm nhất có thể !');

        return response()->json($data);
    }
}
