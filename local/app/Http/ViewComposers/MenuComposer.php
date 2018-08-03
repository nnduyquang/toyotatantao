<?php

namespace App\Http\ViewComposers;

use App\Repositories\Menu\MenuRepository;
use Illuminate\View\View;

class MenuComposer
{
    public $listMenu;

    /**
     * Create a movie composer.
     *
     * @return void
     */
    public function __construct(MenuRepository $menu)
    {
       $this->listMenu = $menu->getAllMenuTree();
    }

    /**
     * Bind data to the view.
     *
     * @param  View $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('listMenu', $this->listMenu);
    }
}