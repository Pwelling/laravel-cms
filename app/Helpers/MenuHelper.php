<?php
namespace App\Helpers;

use App\Group;
use App\Page;
use App\Menu;

class MenuHelper
{
    /**
     * @return array
     */
    public static function getMenuItemOptionsArray()
    {
        $options = [];
        $options['Overig'] = [];
        $options['Overig'][] = ['value' => '0|0', 'text' => 'Geen'];
        $options['Overig'][] = ['value' => '3|0', 'text' => 'Eigen url'];
        $groups = Group::all();
        if (count($groups) > 0) {
            $options['Groepen'] = [];
            foreach ($groups as $group) {
                $options['Groepen'][] = ['value' => '1|' . $group -> id, 'text' => $group -> name];
            }
        }
        $pages = Page::all();
        if (count($pages) > 0) {
            $options['Paginas'] = [];
            foreach ($pages as $page) {
                $options['Paginas'][] = ['value' => '2|' . $page -> id,  'text' => $page -> title];
            }
        }
        return $options;
    }

    /**
     *
     */
    public static function emptyMenu()
    {
        Menu::truncate();
    }

    /**
     * @param array $item
     * @param $parent
     */
    public static function saveMenuItem(array $item, $parent)
    {
        $chosenItem = explode('|', $item['chosenItem']);

        if (count($chosenItem) != 2) {
            return;
        }
        $menuItem = new Menu();
        $menuItem->type = $chosenItem[0];
        $menuItem->itemId = $chosenItem[1];
        $menuItem->parentId = $parent;
        $menuItem->text = $item['term'];
        $menuItem->url = $item['url'];
        $menuItem->save();

        if (isset($item['children'])) {
            foreach ($item['children'] as $child) {
                self::saveMenuItem($child, $menuItem->id);
            }
        }
        return;
    }

    /**
     *
     */
    public static function getSubItems($parent) {
        $menu = Menu::where('parentId', '=', $parent) -> get();
        $return = [];
        if (count($menu) > 0) {
            foreach ($menu AS $key => $item) {
                $return[] = [
                    'id' => $item -> id,
                    'title' => $item -> text,
                    'url' => $item -> url,
                    'selectItem' => $item -> type.'|'.$item->itemId,
                    'selectTarget' => $item->target,
                    'children' => self::getSubItems($item -> id),
                    '__domenu_params' => []
                ];
            }
        }
        return $return;
    }
}