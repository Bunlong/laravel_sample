<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use App\Models\Book;
use Validator;
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
    // $this->validate($request, [ 'title' => 'required', 'price' => 'required' ]);
    // dd($request->all());

    $file = array('image' => Input::file('image')); // getting all of the post data

    $rules = array('image' => 'required',); //mimes: jpeg,bmp,png and for max size max:10000

    $validator = Validator::make($file, $rules); // doing the validation, passing post data, rules and the messages

    if ($validator->fails()) {
      return Redirect::to('create')->withInput()->withErrors($validator);
    }
    else {
      if (Input::file('image')->isValid()) { // checking file is valid.
        $destinationPath = 'uploads'; // uploads directory path

        $extension = Input::file('image')->getClientOriginalExtension(); // getting image extension

        $fileName = rand(11111,99999).'.'.$extension; // renaming image

        $uploadedFile = Input::file('image')->move($destinationPath, $fileName); // uploading file to given path
        
        $input = $request->all();
        $input['image'] = $uploadedFile;

        $result = Book::create($input);

        if($result) {
          Session::flash('message', 'Successfully added.');
          return redirect()->route('books.index');
        }
        else {
          return redirect()->back();
        }
      }
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

    $result = $book->update(Input::only('title', 'price', 'image'));

    if(file_exists('file_path')){
      @unlink('file_path');
    }

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

  private function delete_file($file_path) {
    if(file_exists($file_path)){
      @unlink($file_path);
    }
  }
}
