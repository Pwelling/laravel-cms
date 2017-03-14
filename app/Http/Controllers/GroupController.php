<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Group;
class GroupController extends Controller {
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
		//
	}

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request) {
		//
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
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		//
	}
	
	/**
	 * 
	 */
	public function getPages()
	{
		return $this -> hasMany('App\Page');
	}

	/**
	 * Opent het scherm met het overzicht van de groepen
	 */
	public function listGroups()
	{
		$groups = Group::all();
		return view('groups', ['groups' => $groups]);
	}

	/**
	 * Opent het scherm om een groep te bewerken
	 * @param $groupName
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function editGroup($groupName)
	{
		$group = Group::where('slug', '=', $groupName) -> first();
		return view('group', ['group' => $group]);
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function newGroup()
	{
		return view('group');
	}

	/**
	 * Functie die het opslaan van een groep regelt
	 * @param Request $request
	 * @param bool $id
	 * @return $this|\Illuminate\Http\RedirectResponse
	 */
	public function saveGroup(Request $request, $id = false)
	{
		$messages = ['required' => 'De groepsnaam is verplicht.', ];
		$validator = Validator::make($request -> all(), ['name' => 'required|max:255', ], $messages);
		if ($validator -> fails()) {
			return redirect() -> back() -> withErrors($validator) -> withInput();
		}
		if ($id === false) {//Het is een insert
			$group = new Group;
			$group -> name = $request -> name;
            $group->slug = str_slug($request->name);
            $group->description = $request->description;
			$group -> save();
			$mes = 'Groep is opgeslagen!';
		} else {//het is een update
			Group::where('id', $id) -> update([
			    'name' => $request -> input('name'),
                'slug' => str_slug($request->input('name')),
                'description' => $request->input('description')
            ]);
			$mes = 'Groep is Bijgewerkt!';
		}
		return redirect('/group/' . str_slug($request -> input('name'))) -> with('status', $mes);
	}

	/**
	 * @param Request $request
	 */
	public function removeGroup(Request $request)
	{
		$id = $request -> gId;
		Group::where('id', $id) -> delete();
	}

	/**
	 * @param Request $request
	 * @return \Illuminate\Http\JsonResponse
	 */
	public function checkForPages(Request $request)
	{
		$id = $request -> gId;
		$return = array();
		$pages = Group::where('id', '=', $id) -> first() -> getPages;
		$return['result'] = (count($pages) > 0) ? false : true;
		return response() -> json($return);
	}

}
