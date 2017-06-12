<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Book;
use Session;

class BookController extends Controller
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index(){
    $books = Book::all();
    return view('books.index')->withBooks($books);
  }

  /**
   * Show the form for creating a new resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function create() {
    return view('books.create');
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @return \Illuminate\Http\Response
   */
  public function store(Request $request) {
    // dd($request->all());
    $this->validate($request, [ 'title' => 'required', 'price' => 'required' ]);

    $input = $request->all();

    $result = Book::create($input);

    if($result) {
      Session::flash('message', 'Successfully added.');
      return redirect()->route('books.index');
    }
    else {
      return redirect()->back();
    }
  }


  /**
   * Show the form for editing the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function edit($id) {
    $book = Book::findOrFail($id);
    return view('books.edit')->withBook($book);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
  */
  public function update(Request $request, $id) {
    $book = Book::findOrFail($id);

    $this->validate($request, [ 'title' => 'required', 'price' => 'required' ]);

    $input = $request->all();

    $result = $book->fill($input)->save();


    if($result) {
      Session::flash('message', 'Successfully updated.');
      return redirect()->route('books.index');
    }
    else {
      return redirect()->back();
    }
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id) {
    $book = Book::findOrFail($id);
    $result = $book->delete();

    if($result) {
      Session::flash('message', 'Successfully deleted.');
    }
    else{
      Session::flash('message', 'Unsuccessfully delete.');
    }
    
    return redirect()->route('books.index');
  }
  
  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
  */
  public function show($id) {

  }
}
