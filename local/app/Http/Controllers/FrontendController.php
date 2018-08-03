<?php

namespace App\Http\Controllers;

use App\Repositories\Frontend\FrontendRepositoryInterface;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    protected $frontendRepository;

    public function __construct(FrontendRepositoryInterface $frontendRepository)
    {
        $this->frontendRepository = $frontendRepository;
    }

    public function getProductByCategoryMain($path)
    {
        $data = $this->frontendRepository->getProductByCategoryMain($path);
        return view('frontend.category.index', compact('data'));
    }

    public function getProductByCategorySub($pathParent, $pathSub)
    {
        $data = $this->frontendRepository->getProductByCategorySub($pathParent, $pathSub);
        return view('frontend.category.index', compact('data'));
    }


    public function getAllListCategoryAndProduct()
    {
        $data = $this->frontendRepository->getAllListCategoryAndProduct();
        return view('frontend.home.index', compact('data'));
    }

    public function getProductInfo($productPath)
    {
        $data = $this->frontendRepository->getProductInfo($productPath);
        return view('frontend.product.index', compact('data'));
    }


    public function getPageContent($path)
    {
        $data = $this->frontendRepository->getPageContent($path);
        return view('frontend.page.index', compact('data'));
    }

    public function getSearch(Request $request)
    {
        $data = $this->frontendRepository->getSearch($request->input('key-search'));
        return view('frontend.search.index', compact('data'));
    }

    public function getCategoryPostContent($path)
    {
        $data = $this->frontendRepository->getCategoryPostContent($path);
        return view('frontend.post.index', compact('data'));
    }

    public function getPostDetail($pathParent, $pathSub)
    {
        $data = $this->frontendRepository->getPostDetail($pathParent, $pathSub);
        return view('frontend.post.index', compact('data'));

    }

    public function getAllNews(){
        $data = $this->frontendRepository->getAllNews();
        return view('frontend.news.index', compact('data'));
    }

    public function getNewsDetail($path){
        $data = $this->frontendRepository->getNewsDetail($path);
        return view('frontend.news.index', compact('data'));
    }

}

