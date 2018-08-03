<?php

namespace App\Http\Controllers;

use App\CategoryItem;

use App\Seo;
use Illuminate\Http\Request;

class CategoryPostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dd_categorie_posts = CategoryItem::where('type', CATEGORY_POST)->orderBy('order')->get();
        foreach ($dd_categorie_posts as $key => $data) {
            if ($data->level == CATEGORY_POST_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $categoryposts = [];
        self::showCategoryItemDropDown($dd_categorie_posts, 0, $categoryposts);
        return view('backend.admin.categorypost.index', compact('categoryposts'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dd_categorie_posts = CategoryItem::where('type', CATEGORY_POST)->orderBy('order')->get();
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
        $dd_categorie_posts = array_prepend(array_pluck($newArray, 'name', 'id'), 'Cấp Cha', '-1');
        return view('backend.admin.categorypost.create', compact('roles','dd_categorie_posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categorypost = new CategoryItem();
        $seo=new Seo();
        $name = $request->input('name');
        $order = $request->input('order');
        $parentID = $request->input('parent');
        $description = $request->input('description');
        $seoTitle = $request->input('seo_title');
        $seoDescription = $request->input('seo_description');
        $seoKeywords=$request->input('seo_keywords');
        $isActive = $request->input('page_is_active');
        $image = $request->input('image');
        $image = substr($image, strpos($image, 'images'), strlen($image) - 1);
        if ($parentID != CATEGORY_POST_CAP_CHA) {
            $categorypost->parent_id = $parentID;
            $level = CategoryItem::where('id', '=', $parentID)->first()->level;
            $categorypost->level = (int)$level + 1;
        } else
            $categorypost->level = 0;
        if (!IsNullOrEmptyString($order)) {
            $categorypost->order = $order;
        }
        if (!IsNullOrEmptyString($isActive)) {
            $categorypost->isActive = 1;
        } else {
            $categorypost->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $categorypost->description = $description;
        }
        $seo->seo_title= $seoTitle;
        $seo->seo_description= $seoDescription;
        $seo->seo_keywords= $seoKeywords;
        $seo->save();
        $categorypost->name = $name;
        $categorypost->type = CATEGORY_POST;
        $categorypost->path = chuyen_chuoi_thanh_path($name);
        $categorypost->image = $image;
        $categorypost->seo_id=$seo->id;
        $categorypost->save();
        return redirect()->route('categorypost.index')->with('success', 'Tạo Mới Thành Công Chuyên Mục');
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
        $categorypost = CategoryItem::find($id);
        $dd_category_post = CategoryItem::where('type', CATEGORY_POST)->orderBy('order')->get();
        foreach ($dd_category_post as $key => $data) {
            if ($data->level == CATEGORY_POST_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $newArray=[];
        self::showCategoryItemDropDown($dd_category_post, 0, $newArray);
        $dd_category_post = array_prepend(array_pluck($newArray, 'name', 'id'), 'Cấp Cha', '-1');
        $dd_category_post = array_map(function ($index, $value) {
            return ['index' => $index, 'value' => $value];
        }, array_keys($dd_category_post), $dd_category_post);
        return view('backend.admin.categorypost.edit', compact('categorypost','dd_category_post'));
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
        $categorypost = CategoryItem::find($id);
        $name = $request->input('name');
        $order = $request->input('order');
        $parentID = $request->input('parent');
        $description = $request->input('description');
        $seoTitle = $request->input('seo_title');
        $seoDescription = $request->input('seo_description');
        $seoKeywords=$request->input('seo_keywords');
        $isActive = $request->input('page_is_active');
        $image = $request->input('image');
        $image = substr($image, strpos($image, 'images'), strlen($image) - 1);
        if ($parentID != CATEGORY_POST_CAP_CHA) {
            $categorypost->parent_id = $parentID;
            $level = CategoryItem::where('id', '=', $parentID)->first()->level;
            $categorypost->level = (int)$level + 1;
        } else
            $categorypost->level = 0;
        if (!IsNullOrEmptyString($order)) {
            $categorypost->order = $order;
        }
        if (!IsNullOrEmptyString($isActive)) {
            $categorypost->isActive = 1;
        } else {
            $categorypost->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $categorypost->description = $description;
        }
        $categorypost->seos->seo_title = $seoTitle;
        $categorypost->seos->seo_description = $seoDescription;
        $categorypost->seos->seo_keywords = $seoKeywords;
        $categorypost->seos->save();
        $categorypost->name = $name;
        $categorypost->type = CATEGORY_POST;
        $categorypost->path = chuyen_chuoi_thanh_path($name);
        $categorypost->image = $image;
        $categorypost->save();
        return redirect()->route('categorypost.index')->with('success', 'Cập Nhật Thành Công Chuyên Mục');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categorypost = CategoryItem::find($id);
        $categorypost->seos->delete();
        $categorypost->delete();
        return redirect()->route('categorypost.index')->with('success', 'Đã Xóa Thành Công');
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
