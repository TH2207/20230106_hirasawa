@extends('layouts.default')
<style>

</style>
@section('content')
<div class="container">
  <div class="card">
    <div class="card__header">
      <p class="title mb-15">タスク検索</p>
      <div class="auth mb-15">
        @if (Auth::check())
        <p class="detail">「{{$user_name}}」でログイン中</p>
        @else
        <p class="detail">「エラー」でログイン中</p>
        @endif
        <form method="post" action="{{route('logout')}}">
          @csrf
          <input class="btn btn-logout" type="submit" value="ログアウト">
        </form>
      </div>
    </div>
    <div class="todo">
      @error('content')
      <p class="err-msg">{{$message}}</p>
      @enderror
      <form action="{{ route('search') }}" method="POST" class="flex between mb-30">
        @csrf
        <input type="text" name="content" class="input-add"">
        <select name="tag_id" class="select-tag">
        <option disabled selected value></option>
        @foreach ($tags as $tag)
        <option value="{{$tag->id}}">{{$tag->content}}</option>
        @endforeach
        </select>
        <input type="submit" value="検索" class="btn btn-add">
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
          <form action="{{ route('update', ['id' => $todo->id])}}" method="POST">
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
    <a class="btn btn-back" href="/">戻る</a>
  </div>
</div>
@endsection