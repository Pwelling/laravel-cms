<?php

namespace App\Http\Controllers;

use App\Helpers\MenuHelper;
use Illuminate\Http\Request;
use App\Menu;

class MenuController extends Controller {
	/**
	 *
	 */
	public function edit() {
		return view('menu');
	}

	/**
	 *
	 */
	public function getMenuJson() {
		return response() -> json(MenuHelper::getSubItems(0));
	}

	/**
	 *
	 */
	public function saveMenu(Request $request) {
	    //We have to empty the menu before we can store the new menu-structure
        MenuHelper::emptyMenu();
		foreach ($request->menuItems as $item) {
			MenuHelper::saveMenuItem($item, 0);
		}
        return response() -> json(['error' => false]);
	}
}
