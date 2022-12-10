@extends('layouts.default')
<style>

</style>
@section('content')
<div class="container">
  <div class="card">
    <p class="title mb-15">Todo List</p>
    <div class="todo">
      @error('content')
      <p class="err-msg">{{$message}}</p>
      @enderror
      <form action="/create" method="POST" class="flex between mb-30">
        @csrf
        <input type="text" name="content" class="input-add">
        <input type="submit" value="追加" class="button-add">
      </form>
      @isset($todos)
      <table>
        <tr>
          <th>作成日</th>
          <th>タスク名</th>
          <th>更新</th>
          <th>削除</th>
        </tr>
        @foreach ($todos as $todo)
        <tr>
          <td>{{$todo->created_at}}</td>
          <form action="{{ route('update', ['id' => $todo->id])}}" method="POST">
            @csrf
            <td><input type="text" name="content" value="{{$todo->content}}" class="input-update"></td>
            <td><input type="submit" value="更新" class="button-update"></td>
          </form>
          <form action="{{ route('remove', ['id' => $todo->id])}}" method="POST">
            @csrf
            <td><input type="submit" value="削除" class="button-delete"></td>
          </form>
        </tr>
        @endforeach
      </table>
      @endisset
    </div>
  </div>
</div>
@endsection