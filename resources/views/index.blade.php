@extends('layouts.default')
<style>

</style>
@section('content')
<div class="container">
  <div class="card">
    <div class="card__header">
      <p class="title mb-15">Todo List</p>
      <div class="auth mb-15">
        @if (Auth::check())
        <p class="detail">「{{$user_name}}」でログイン中</p>
        @endif
        <form method="post" action="/logout">
          @csrf
          <input class="btn btn-logout" type="submit" value="ログアウト">
        </form>
      </div>
    </div>
    <form method="post" action="/find">
      @csrf
      <input class="btn btn-search" type="submit" value="タスク検索">
    </form>
    <div class="todo">
      @error('content')
      <p class="err-msg">{{$message}}</p>
      @enderror
      <form action="{{ route('create', ['user_id' => $user_id] )}}" method="POST" class="flex between mb-30">
        @csrf
        <input type="text" name="content" class="input-add">
        <select name="tag_id" class="select-tag">
          @foreach ($tags as $tag)
          @if ($tag->id === 1)
          <option selected value="{{$tag->id}}">{{$tag->content}}</option>
          @else
          <option value="{{$tag->id}}">{{$tag->content}}</option>
          @endif
          @endforeach
        </select>
        <input type="submit" value="追加" class="btn btn-add">
      </form>
      @isset($todos)
      <table>
        <tr>
          <th>作成日</th>
          <th>タスク名</th>
          <th>タグ</th>
          <th>更新</th>
          <th>削除</th>
        </tr>
        @foreach ($todos as $todo)
        <tr>
          <td>{{$todo->created_at}}</td>
          <form action="{{ route('update', ['id' => $todo->id] )}}" method="POST">
            @csrf
            <td><input type="text" name="content" value="{{$todo->content}}" class="input-update"></td>
            <td>
              <select name="tag_id" class="select-tag">
                @foreach ($tags as $tag)
                @if ($tag->id === $todo->tag_id)
                <option selected value="{{$tag->id}}">{{$tag->content}}</option>
                @else
                <option value="{{$tag->id}}">{{$tag->content}}</option>
                @endif
                @endforeach
              </select>
            </td>
            <td><input type="submit" value="更新" class="btn btn-update"></td>
          </form>
          <form action="{{ route('remove', ['id' => $todo->id] )}}" method="POST">
            @csrf
            <td><input type="submit" value="削除" class="btn btn-delete"></td>
          </form>
        </tr>
        @endforeach
      </table>
      @endisset
    </div>
  </div>
</div>
@endsection