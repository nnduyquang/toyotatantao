<?php

namespace App\Http\Controllers;

use App\CategoryItem;
use App\Post;
use App\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::where('post_type','=',IS_POST)->orderBy('id', 'DESC')->get();
        return view('backend.admin.post.index', compact('posts'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dd_categorie_posts = CategoryItem::where('type',CATEGORY_POST)->orderBy('order')->get();
        foreach ($dd_categorie_posts as $key => $data) {
            if ($data->level == CATEGORY_POST_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $newArray = [];
        self::showCategoryItemDropDown($dd_categorie_posts, 0, $newArray);
        $dd_categorie_posts=$newArray;
//        $dd_categorie_posts = array_pluck($newArray, 'name', 'id');
        return view('backend.admin.post.create', compact('roles', 'dd_categorie_posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $post = new Post();
        $seo=new Seo();
        $title = $request->input('title');
        $description = $request->input('description');
        $content = $request->input('content');
        $listCategory=$request->input('list_category');
        $seoTitle = $request->input('seo_title');
        $seoDescription = $request->input('seo_description');
        $seoKeywords=$request->input('seo_keywords');
        $isActive = $request->input('post_is_active');
        $image = $request->input('image');
        if ($image) {
            $image = substr($image, strpos($image, 'images'), strlen($image) - 1);
            $post->image = $image;
        }
        $categoryItemId = $request->input('parent');
        if (!IsNullOrEmptyString($isActive)) {
            $post->isActive = 1;
        } else {
            $post->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $post->description = $description;
        }
        $seo->seo_title= $seoTitle;
        $seo->seo_description= $seoDescription;
        $seo->seo_keywords= $seoKeywords;
        $seo->save();
        $post->title = $title;
        $post->path = chuyen_chuoi_thanh_path($title);
        $post->content = $content;
        $post->category_item_id=$categoryItemId;
        $post->post_type = IS_POST;
        $post->user_id = Auth::user()->id;
        $post->seo_id=$seo->id;
        $post->save();
        $post->categoryitems()->attach($listCategory);
        return redirect()->route('post.index')->with('success', 'Tạo Mới Thành Công Bài Viết');
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);
        $dd_categorie_posts = CategoryItem::where('type',CATEGORY_POST)->orderBy('order')->get();
        foreach ($dd_categorie_posts as $key => $data) {
            if ($data->level == CATEGORY_POST_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $newArray = [];
        self::showCategoryItemDropDown($dd_categorie_posts, 0, $newArray);
        $dd_categorie_posts=$newArray;
//        $dd_categorie_posts = array_pluck($newArray, 'name', 'id');
//        $dd_categorie_posts = array_map(function ($index, $value) {
//            return ['index' => $index, 'value' => $value];
//        }, array_keys($dd_categorie_posts), $dd_categorie_posts);
        return view('backend.admin.post.edit', compact('post', 'dd_categorie_posts'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $post = Post::find($id);
        $title = $request->input('title');
        $description = $request->input('description');
        $content = $request->input('content');
        $listCategory=$request->input('list_category');
        $seoTitle = $request->input('seo_title');
        $seoDescription = $request->input('seo_description');
        $seoKeywords=$request->input('seo_keywords');
        $isActive = $request->input('post_is_active');
        $image = $request->input('image');
        if ($image) {
            $image = substr($image, strpos($image, 'images'), strlen($image) - 1);
            $post->image = $image;
        } else {
            $post->image = NULL;
        }
        $categoryItemId = $request->input('parent');
        if (!IsNullOrEmptyString($isActive)) {
            $post->isActive = 1;
        } else {
            $post->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $post->description = $description;
        }
        $post->seos->seo_title = $seoTitle;
        $post->seos->seo_description = $seoDescription;
        $post->seos->seo_keywords = $seoKeywords;
        $post->seos->save();
        $post->title = $title;
        $post->path = chuyen_chuoi_thanh_path($title);

        $post->content = $content;
        $post->category_item_id=$categoryItemId;
        $post->post_type = IS_POST;
        $post->user_id = Auth::user()->id;
        $post->save();
        $post->categoryitems()->sync($listCategory);
        return redirect()->route('post.index')->with('success', 'Cập Nhật Thành Công Bài Viết');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->seos->delete();
        $post->categoryitems()->detach();
        $post->delete();
        return redirect()->route('post.index')
            ->with('success', 'Đã Xóa Thành Công');
    }

    public function showCategoryItemDropDown($dd_categorie_posts, $parent_id = 0, &$newArray)
    {
        foreach ($dd_categorie_posts as $key => $data) {
            if ($data->parent_id == $parent_id) {
                array_push($newArray, $data);
                $dd_categorie_posts->forget($key);
                self::showCategoryItemDropDown($dd_categorie_posts, $data->id, $newArray);
            }
        }
    }
}
