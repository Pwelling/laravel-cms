<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Group;
use App\Page;
class PageController extends Controller {
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		//
	}

	/**
	 * Show the form for creating a new resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		$groups = $this -> getGroups();
		return view('page', ['groups' => $groups]);
	}

	/**
	 * Opent het scherm om een groep te bewerken
	 * @param $seo
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function editPage($seo)
	{
		// \DB::enableQueryLog();
		$page = Page::where('seo', '=', $seo) -> first();
		// dd($page);
		// dd(\DB::getQueryLog());
		$groups = $this -> getGroups();
		return view('page', compact('page', 'groups'));
	}

	/**
	 * @return array
	 */
	function getGroups()
	{
		$groupsSrc = Group::all();
		$groups = array();
		$groups[0] = "Maak een keuze";
		foreach ($groupsSrc AS $key => $group) {
			$groups[$group -> id] = $group -> name;
		}
		return $groups;
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param $id
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request, $id = false)
	{
		$messages = ['required' => 'Verplicht veld.', ];
		$validator = Validator::make($request -> all(), ['title' => 'required|max:255', 'body' => 'required', 'group_id' => 'required', ], $messages);
		if ($validator -> fails()) {
			return redirect() -> back() -> withErrors($validator) -> withInput();
		}
		if ($id === false) {//Het is een insert
			$page = new Page;
			$page -> title = $request -> title;
			$page -> body = $request -> body;
			$page -> seo = str_slug($request -> title);
			$page -> group_id = $request -> group_id;
			$page -> save();
			$mes = 'Pagina is opgeslagen!';
		} else {//het is een update
			Page::where('id', $id) -> update(['title' => $request -> input('title'), 'body' => $request -> input('body'), 'seo' => str_slug($request -> title), 'group_id' => $request -> group_id]);
			$mes = 'Pagina is Bijgewerkt!';
		}
		return redirect('/page/' . str_slug($request -> input('title'))) -> with('status', $mes);
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		//
		if ($id === false) {

		}
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		//
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		//
	}

	/**
	 * Remove the specified resource from storage.
	 * @param Request $request
	 */
	public function destroy(Request $request)
	{
		$id = $request -> pId;
		Page::where('id', $id) -> delete();
	}

	/**
	 * Gets the groups and adds the pages. Used to display the groups-page
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	function listPages()
	{
		$groups = Group::all();
		foreach ($groups AS $key => $group) {
			$pages = Group::find($group -> id) -> getPages;
			$groups[$key]['pages'] = $pages;
		}
		return view('pages', ['groups' => $groups]);
	}

}
