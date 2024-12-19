@extends('layouts.template')
@section('content')
<h1>Tambah</h1>
<form action="{{route('store.alex')}}" method="POST">
    @csrf
    
    <label for="email">Email : </label>
    <input type="email" name="email" id="email" required>
    <br>
    <label for="password">Password : </label>
    <input type="password" name="password" id="password" required>
    <br>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>
@endsection