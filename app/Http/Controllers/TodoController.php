<?php

namespace App\Http\Controllers;

use App\Models\Todo;
use App\Models\Tag;
use App\Http\Requests\TodoRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TodoController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $tags = Tag::all();
        $user_id = $user->id;
        $user_name = $user->name;
        $todos = Todo::where('user_id', '=', $user_id)->get();
        $param = ['todos' => $todos, 'user_id' => $user_id, 'user_name' => $user_name, 'tags' => $tags];
        return view('index', $param);
    }

    public function create(TodoRequest $request)
    {
        $form = $request->all();
        unset($form['_token']);
        Todo::create($form);
        return redirect('/');
    }

    public function update(TodoRequest $request)
    {
        $form = $request->all();
        unset($form['_token']);
        Todo::where('id', $request->id)->update($form);
        $before_path = parse_url(url()->previous(), PHP_URL_PATH);
        if ($before_path === '/') {
            return redirect('/');
        } else {
            $user = Auth::user();
            $tags = Tag::all();
            $user_id = $user->id;
            $user_name = $user->name;
            $content = $request->session()->get('content');
            $tag_id = $request->session()->get('tag_id');

            if (isset($content) && isset($tag_id)) {
                $cond = [['user_id', "=", $user_id], ['content', 'like', "%$content%"], ['tag_id', '=', $tag_id]];
            } elseif (isset($content)) {
                $cond = [['user_id', "=", $user_id], ['content', 'like', "%$content%"]];
            } elseif (isset($tag_id)) {
                $cond = [['user_id', "=", $user_id], ['tag_id', '=', $tag_id]];
            } else {
                $cond = [['user_id', "=", $user_id]];
            }

            $todos = Todo::where($cond)->get();
            $param = ['todos' => $todos, 'user_name' => $user_name, 'tags' => $tags];
            return view('search', $param);
        }
    }

    public function remove(Request $request)
    {
        Todo::find($request->id)->delete();
        $before_path = parse_url(url()->previous(), PHP_URL_PATH);
        if ($before_path === '/') {
            return redirect('/');
        } else {
            $user = Auth::user();
            $tags = Tag::all();
            $user_id = $user->id;
            $user_name = $user->name;
            $content = $request->session()->get('content');
            $tag_id = $request->session()->get('tag_id');

            if (isset($content) && isset($tag_id)) {
                $cond = [['user_id', "=", $user_id], ['content', 'like', "%$content%"], ['tag_id', '=', $tag_id]];
            } elseif (isset($content)) {
                $cond = [['user_id', "=", $user_id], ['content', 'like', "%$content%"]];
            } elseif (isset($tag_id)) {
                $cond = [['user_id', "=", $user_id], ['tag_id', '=', $tag_id]];
            } else {
                $cond = [['user_id', "=", $user_id]];
            }

            $todos = Todo::where($cond)->get();
            $param = ['todos' => $todos, 'user_name' => $user_name, 'tags' => $tags];
            return view('search', $param);
        }
    }

    public function login(Request $request)
    {
        return redirect('/');
    }

    public function logout(Request $request)
    {
        return redirect('/logout');
    }


    public function find()
    {
        $user = Auth::user();
        $tags = Tag::all();
        $user_name = $user->name;
        $param = ['user_name' => $user_name, 'tags' => $tags];
        return view('find', $param);
    }

    public function search(Request $request)
    {
        $user = Auth::user();
        $tags = Tag::all();
        $user_id = $user->id;
        $user_name = $user->name;
        $content = $request->content;
        $tag_id = $request->tag_id;

        $request->session()->put('content', $content);
        $request->session()->put('tag_id', $tag_id);

        if (isset($content) && isset($tag_id)) {
            $cond = [['user_id', "=", $user_id], ['content', 'like', "%$content%"], ['tag_id', '=', $tag_id]];
        } elseif (isset($content)) {
            $cond = [['user_id', "=", $user_id], ['content', 'like', "%$content%"]];
        } elseif (isset($tag_id)) {
            $cond = [['user_id', "=", $user_id], ['tag_id', '=', $tag_id]];
        } else {
            $cond = [['user_id', "=", $user_id]];
        }

        $todos = Todo::where($cond)->get();
        $param = ['todos' => $todos, 'user_name' => $user_name, 'tags' => $tags];
        return view('search', $param);
    }
}
