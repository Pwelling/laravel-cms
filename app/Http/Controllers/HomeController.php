<?php

namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;

class HomeController extends Controller {
	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this -> middleware('auth');
	}

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		return view('home');
	}

	/**
	 * @return \Illuminate\Http\RedirectResponse
	 */
	public function checkLogged()
	{
		if (\Auth::check()) {
			return redirect() -> route('home');
		} else {
			return redirect() -> route('home');
		}
	}

}
