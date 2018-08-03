<?php

namespace App\Http\Controllers;

use App\Repositories\Menu\MenuRepositoryInterface;
use Illuminate\Http\Request;

class MenuController extends Controller
{
    protected $menuRepository;

    public function __construct(MenuRepositoryInterface $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    public function loadTreeMenu()
    {
        return response()->json($this->menuRepository->getAllMenuTree());
    }

    public function loadMenuIndex()
    {
        return $this->menuRepository->loadMenuIndex();
    }

    public function createNewMenu(Request $request)
    {
        $this->menuRepository->createNewMenu($request);
        return redirect()->route('menu.index')->with('success', 'Tạo Mới Thành Công Bài Viết');
    }

    public function updateMenu(Request $request, $id)
    {
        $this->menuRepository->updateMenu($request,$id);
        return redirect()->route('menu.index')->with('success', 'Cập Nhật Thành Công Menu');
    }

    public function findMenuById($id)
    {
        return response()->json($this->menuRepository->findMenuById($id));
    }

    public function updateNodeFamily($id, $parentId)
    {
        $this->menuRepository->updateNodeFamily($id, $parentId);
    }

    public function deleteMenu($id)
    {
        $this->menuRepository->deleteMenu($id);
        return redirect()->route('menu.index')->with('success', 'Xóa Thành Công Menu');
    }

}
