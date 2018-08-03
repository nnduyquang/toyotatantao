<?php

namespace App\Http\Controllers;

use App\CategoryItem;
use App\Seo;
use Illuminate\Http\Request;

class CategoryProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dd_categorie_posts = CategoryItem::where('type', CATEGORY_PRODUCT)->orderBy('order')->get();
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
        return view('backend.admin.categoryproduct.index', compact('categoryposts'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dd_category_products = CategoryItem::orderBy('order')->get();
        foreach ($dd_category_products as $key => $data) {
            if ($data->level == CATEGORY_POST_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $newArray = [];
        self::showCategoryItemDropDown($dd_category_products, 0, $newArray);
        $dd_categorie_posts = array_prepend(array_pluck($newArray, 'name', 'id'), 'Cấp Cha', '-1');
        return view('backend.admin.categoryproduct.create', compact('roles', 'dd_categorie_posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $categoryproduct = new CategoryItem();
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
        $imageMobile = $request->input('image_mobile');
        $imageMobile = substr($imageMobile, strpos($imageMobile, 'images'), strlen($imageMobile) - 1);
        if ($parentID != CATEGORY_POST_CAP_CHA) {
            $categoryproduct->parent_id = $parentID;
            $level = CategoryItem::where('id', '=', $parentID)->first()->level;
            $categoryproduct->level = (int)$level + 1;
        } else
            $categoryproduct->level = 0;
        if (!IsNullOrEmptyString($order)) {
            $categoryproduct->order = $order;
        }
        if (!IsNullOrEmptyString($isActive)) {
            $categoryproduct->isActive = 1;
        } else {
            $categoryproduct->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $categoryproduct->description = $description;
        }
        $seo->seo_title= $seoTitle;
        $seo->seo_description= $seoDescription;
        $seo->seo_keywords= $seoKeywords;
        $seo->save();
        $categoryproduct->name = $name;
        $categoryproduct->type = CATEGORY_PRODUCT;
        $categoryproduct->path = chuyen_chuoi_thanh_path($name);
        $categoryproduct->image = $image;
        $categoryproduct->image_mobile = $imageMobile;
        $categoryproduct->seo_id=$seo->id;
        $categoryproduct->save();
        return redirect()->route('categoryproduct.index')->with('success', 'Tạo Mới Thành Công Chuyên Mục');
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
        $categoryproduct = CategoryItem::find($id);
        $dd_category_products = CategoryItem::orderBy('order')->get();
        foreach ($dd_category_products as $key => $data) {
            if ($data->level == CATEGORY_POST_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_POST_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $newArray = [];
        self::showCategoryItemDropDown($dd_category_products, 0, $newArray);
        $dd_category_products = array_prepend(array_pluck($newArray, 'name', 'id'), 'Cấp Cha', '-1');
        $dd_category_products = array_map(function ($index, $value) {
            return ['index' => $index, 'value' => $value];
        }, array_keys($dd_category_products), $dd_category_products);
        return view('backend.admin.categoryproduct.edit', compact('categoryproduct', 'dd_category_products'));
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
        $categoryproduct = CategoryItem::find($id);
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
        $imageMobile = $request->input('image_mobile');
        $imageMobile = substr($imageMobile, strpos($imageMobile, 'images'), strlen($imageMobile) - 1);
        if ($parentID != CATEGORY_POST_CAP_CHA) {
            $categoryproduct->parent_id = $parentID;
            $level = CategoryItem::where('id', '=', $parentID)->first()->level;
            $categoryproduct->level = (int)$level + 1;
        } else
            $categoryproduct->level = 0;
        if (!IsNullOrEmptyString($order)) {
            $categoryproduct->order = $order;
        }
        if (!IsNullOrEmptyString($isActive)) {
            $categoryproduct->isActive = 1;
        } else {
            $categoryproduct->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $categoryproduct->description = $description;
        }
        $categoryproduct->seos->seo_title = $seoTitle;
        $categoryproduct->seos->seo_description = $seoDescription;
        $categoryproduct->seos->seo_keywords = $seoKeywords;
        $categoryproduct->seos->save();
        $categoryproduct->name = $name;
        $categoryproduct->type = CATEGORY_PRODUCT;
        $categoryproduct->path = chuyen_chuoi_thanh_path($name);
        $categoryproduct->image = $image;
        $categoryproduct->image_mobile = $imageMobile;
        $categoryproduct->save();
        return redirect()->route('categoryproduct.index')->with('success', 'Cập Nhật Thành Công Chuyên Mục');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $categoryproduct = CategoryItem::find($id);
        $categoryproduct->seos->delete();
        $categoryproduct->delete();
        return redirect()->route('categoryproduct.index')->with('success', 'Đã Xóa Thành Công');
    }

    public function showCategoryItemDropDown($dd_category_products, $parent_id = 0, &$newArray)
    {
        foreach ($dd_category_products as $key => $data) {
            if ($data->parent_id == $parent_id) {
                array_push($newArray, $data);
                $dd_category_products->forget($key);
                self::showCategoryItemDropDown($dd_category_products, $data->id, $newArray);
            }
        }
    }
    public function search(Request $request)
    {
        $keywords = preg_replace('/\s+/', ' ', $request->input('txtSearch'));
        $categoryposts = CategoryItem::where('name', 'like', '%' . $keywords . '%')->orderBy('id', 'DESC')->paginate(5);
        return view('backend.admin.categoryproduct.index', compact('categoryposts', 'keywords'))->with('i', ($request->input('categoryposts', 1) - 1) * 5);
    }
    public function paste(Request $request)
    {
        $listId = $request->input('listID');
        $categoryposts = CategoryItem::find(explode(',', $listId));
        foreach ($categoryposts as $key => $data) {
            $data->name = $data->name . ' ' . rand(pow(10, 2), pow(10, 3) - 1);
            $data->path = chuyen_chuoi_thanh_path($data->name);
        }
        CategoryItem::insert($categoryposts->toArray());
        return redirect()->route('categoryproduct.index')->with('success', 'Tạo Mới Thành Công Loại');
    }


}
