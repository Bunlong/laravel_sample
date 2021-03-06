@extends('layouts.app')

@section('content')
  <div class="col-md-6">
    <h1>Edit "{{ $book->title }}"</h1>
    <hr/>
    
    @if($errors->any())
      <div class="alert alert-danger">
        @foreach($errors->all() as $error)
          <p>{{ $error }}</p>
        @endforeach
      </div>
    @endif

    {!! Form::model($book, [
      'method' => 'PATCH',
      'route' => ['books.update', $book->id]
    ]) !!}

      <div class="form-group">
        {!! Form::file('image') !!}
        {!!$errors->first('image')!!}
      </div>

      <div class="form-group">
        {!! Form::label('title', 'Title:', ['class' => 'control-label']) !!}
        {!! Form::text('title', null, ['class' => 'form-control']) !!}
      </div>

      <div class="form-group">
          {!! Form::label('price', 'Price:', ['class' => 'control-label']) !!}
          {!! Form::text('price', null, ['class' => 'form-control']) !!}
      </div>

      <hr/>

      {!! Form::submit('Update book', ['class' => 'btn btn-primary']) !!}
      <a href="{{ route('books.index') }}">Go back to all books.</a></p>

    {!! Form::close() !!}
  </div>  
@endsection