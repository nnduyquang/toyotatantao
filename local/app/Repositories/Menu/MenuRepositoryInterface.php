<?php

namespace App\Repositories\Menu;

interface MenuRepositoryInterface
{
    public function getAllMenuTree();

    public function findChildMenu($menus, $parent_id = 0, &$newArray);

    public function loadMenuIndex();

    public function createNewMenu($request);

    public function updateMenu($request, $id);

    public function findMenuById($id);

    public function updateNodeFamily($id, $parentId);

    public function updateMenuChildDelete(&$listMenu, $menu);

    public function deleteMenu($id);

    public function showMenu();
}