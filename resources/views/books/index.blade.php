@extends('layouts.app')

@section('content')
  <div>
    <h1>Book List</h1>
    <hr/>
    <p class="pull-right">
      <a href="{{ route('books.create') }}" class="btn btn-primary">Add New Book</a>
    </p>
    <table class="table table-bordered">
      <thead>
        <tr>
          <th>#</th>
          <th>Image</th>
          <th>Title</th>
          <th>Price</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        @foreach($books as $book)
          <tr>
            <td>{{$book->id}}</td>
            <td><img src={{$book->image}} class="thumbnail col-xs-4 col-md-2" /></td>
            <td>{{$book->title}}</td>
            <td>$ {{$book->price}}</td>
            <td>
              <div>
                <a href="{{ route('books.edit', $book->id) }}" class="btn btn-success">Edit</a>
                {!! Form::open([
                  'method' => 'DELETE',
                  'route' => ['books.destroy', $book->id]
                ]) !!}
                  {!! Form::submit('Delete', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
              </div>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
@endsection
