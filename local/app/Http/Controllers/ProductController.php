<?php

namespace App\Http\Controllers;


use App\CategoryItem;
use App\Product;
use App\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products = Product::orderBy('id', 'DESC')->paginate(5);
        $products->makeVisible('id');
        return view('backend.admin.product.index', compact('products'))->with('i', ($request->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $dd_category_products = CategoryItem::where('type', CATEGORY_PRODUCT)->orderBy('order')->get();
        foreach ($dd_category_products as $key => $data) {
            if ($data->level == CATEGORY_PRODUCT_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_PRODUCT_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_PRODUCT_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            } else if ($data->level == CATEGORY_PRODUCT_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $newArray = [];
        self::showCategoryDropDown($dd_category_products, 0, $newArray);
        $dd_category_products = array_pluck($newArray, 'name', 'id');
        return view('backend.admin.product.create', compact('roles', 'dd_category_products'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = new Product();
        $seo=new Seo();
        $name = $request->input('name');
        $description = $request->input('description');
        $content = $request->input('content');
        $order = $request->input('order');
        $isActive = $request->input('is_active');
        $categoryPostID = $request->input('category_product');
        $seoTitle = $request->input('seo_title');
        $seoDescription = $request->input('seo_description');
        $seoKeywords = $request->input('seo_keywords');
        $code = $request->input('code');
        $price = $request->input('price');
        $sale = $request->input('sale');
        $finalSale = $request->input('final_price');
        if (!IsNullOrEmptyString($price)) {
            if (!IsNullOrEmptyString($sale)) {
                $product->price = $price;
                $product->sale = $sale;
                $product->final_price = $finalSale;
            } else {
                $product->price = $price;
                $product->sale = 0;
                $product->final_price = 0;
            }
        } else {
            $product->price = 0;
            $product->sale = 0;
            $product->final_price = 0;
        }
        if (!IsNullOrEmptyString($code)) {
            $product->code = $code;
        }
        if (!IsNullOrEmptyString($order)) {
            $product->order = $order;
        }
        if (!IsNullOrEmptyString($isActive)) {
            $product->isActive = 1;
        } else {
            $product->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $product->description = $description;
        }
        $seo->seo_title= $seoTitle;
        $seo->seo_description= $seoDescription;
        $seo->seo_keywords= $seoKeywords;
        $seo->save();
        $image = $request->input('image');
        $image = substr($image, strpos($image, 'images'), strlen($image) - 1);

        $product->name = $name;
        $product->path = chuyen_chuoi_thanh_path($name);
        $product->image = $image;

        $product->content = $content;
        $product->category_product_id = $categoryPostID;
        $product->user_id = Auth::user()->id;
        $product->seo_id=$seo->id;
        $product->save();
        return redirect()->route('product.index')->with('success', 'Tạo Mới Thành Công Sản Phẩm');
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
        $product = Product::find($id);
        $dd_category_products = CategoryItem::where('type', CATEGORY_PRODUCT)->orderBy('order')->get();
        foreach ($dd_category_products as $key => $data) {
            if ($data->level == CATEGORY_PRODUCT_CAP_1) {
                $data->name = ' ---- ' . $data->name;
            } else if ($data->level == CATEGORY_PRODUCT_CAP_2) {
                $data->name = ' --------- ' . $data->name;
            } else if ($data->level == CATEGORY_PRODUCT_CAP_3) {
                $data->name = ' ------------------ ' . $data->name;
            }
        }
        $newArray = [];
        self::showCategoryDropDown($dd_category_products, 0, $newArray);
        $dd_category_products = array_pluck($newArray, 'name', 'id');
        $dd_category_products = array_map(function ($index, $value) {
            return ['index' => $index, 'value' => $value];
        }, array_keys($dd_category_products), $dd_category_products);
        return view('backend.admin.product.edit', compact('product', 'dd_category_products'));
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

        $product = Product::find($id);
        $name = $request->input('name');
        $description = $request->input('description');
        $content = $request->input('content');
        $order = $request->input('order');
        $isActive = $request->input('is_active');
        $categoryPostID = $request->input('category_product');
        $seoTitle = $request->input('seo_title');
        $seoDescription = $request->input('seo_description');
        $seoKeywords = $request->input('seo_keywords');
        $code = $request->input('code');
        $price = $request->input('price');
        $sale = $request->input('sale');
        $finalSale = $request->input('final_price');
        if (!IsNullOrEmptyString($price)) {
            if (!IsNullOrEmptyString($sale)) {
                $product->price = $price;
                $product->sale = $sale;
                $product->final_price = $finalSale;
            } else {
                $product->price = $price;
                $product->sale = 0;
                $product->final_price = 0;
            }
        } else {
            $product->price = 0;
            $product->sale = 0;
            $product->final_price = 0;
        }
        if (!IsNullOrEmptyString($code)) {
            $product->code = $code;
        }
//        if (!IsNullOrEmptyString($price)) {
//            $product->price = $price;
//            if (!IsNullOrEmptyString($sale)) {
//                $product->sale = $sale;
//                if ($sale != 0 && $price != 0)
//                    $product->final_price = (int)$price - ((int)$price * (int)$sale / 100);
//                else
//                    $product->final_price=0;
//            }
//        }
//        else{
//            $product->price=0;
//            $product->sale = 0;
//            $product->final_price=0;
//        }
        if (!IsNullOrEmptyString($order)) {
            $product->order = $order;
        }
        if (!IsNullOrEmptyString($isActive)) {
            $product->isActive = 1;
        } else {
            $product->isActive = 0;
        }
        if (!IsNullOrEmptyString($description)) {
            $product->description = $description;
        }
        $product->seos->seo_title = $seoTitle;
        $product->seos->seo_description = $seoDescription;
        $product->seos->seo_keywords = $seoKeywords;
        $product->seos->save();
        $image = $request->input('image');
        $image = substr($image, strpos($image, 'images'), strlen($image) - 1);
        $product->name = $name;
        $product->path = chuyen_chuoi_thanh_path($name);
        $product->image = $image;
        $product->content = $content;
        $product->category_product_id = $categoryPostID;
        $product->user_id = Auth::user()->id;
        $product->save();
        return redirect()->route('product.index')->with('success', 'Tạo Mới Thành Công Sản Phẩm');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::find($id);
        $product->seos->delete();
        $product->delete();
        return redirect()->route('product.index')->with('success', 'Đã Xóa Thành Công');
    }

    public function search(Request $request)
    {
        $keywords = preg_replace('/\s+/', ' ', $request->input('txtSearch'));
        $products = Product::where('name', 'like', '%' . $keywords . '%')->orderBy('id', 'DESC')->paginate(5);
        return view('backend.admin.product.index', compact('products', 'keywords'))->with('i', ($request->input('product', 1) - 1) * 5);
    }

    public function showCategoryDropDown($dd_category_products, $parent_id = 0, &$newArray)
    {
        foreach ($dd_category_products as $key => $data) {
            if ($data->parent_id == $parent_id) {
                array_push($newArray, $data);
                $dd_category_products->forget($key);
                self::showCategoryDropDown($dd_category_products, $data->id, $newArray);
            }
        }
    }

    public function paste(Request $request)
    {
        $listId = $request->input('listID');
        $products = Product::find(explode(',', $listId));
        foreach ($products as $key => $data) {
            $data->name = $data->name . ' ' . rand(pow(10, 2), pow(10, 3) - 1);
            $data->path = chuyen_chuoi_thanh_path($data->name);
        }
        Product::insert($products->toArray());
        return redirect()->route('product.index')->with('success', 'Tạo Mới Thành Công Sản Phẩm');
    }
}
