<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use Auth;

class HomeController extends Controller
{
    public function index() {
        $data = [
            'title' => 'Гостевая книга. Главная',
            'messages' => Book::latest()->paginate(3),
            'count' => Book::count()
        ];
        return view('pages.index', $data);
    }
    public function store(Request $request)
    {
        $text = $request->get('text');
        $stopWords = [
            'какашка',
            'дибил',
            'идиот'
        ];
        $resultCheckWord  = $this->containsStopWord($text, $stopWords);

        if($resultCheckWord){
            $book = new Book();
            $book->name = Auth::user()->name;
            $book->email = Auth::user()->email;
            $book->message = $text;
            $book->save();

            return redirect()->route('index');
        }

        $data = [
            'title' => 'Гостевая книга. Главная',
            'messages' => Book::latest()->paginate(3),
            'count' => Book::count(),
            'warning' => 'ОШИБКА!!! Вы ввели МАТ!!! Запись не добавлена',
            'text' => $text
        ];
        return view('pages.index', $data);
    }
    public function edit($id) {
        $data = [
            'title' => 'Книга:'.$id.'. Редактирование',
            'message' => Book::where('id', $id)->first(),
            'id' => $id
        ];
        return view('pages.edit', $data);
    }
    public function update(Request $request, $id) {
        $text = $request->get('text');
        $stopWords = [
            'какашка',
            'дибил',
            'идиот'
        ];
        $resultCheckWord  = $this->containsStopWord($text, $stopWords);

        if($resultCheckWord) {
            $book = Book::where('id', $id)->first();
            $book->message = $request->get('text');
            $book->save();

            return redirect()->route('index');
        }
        $data = [
            'title' => 'Книга:'.$id.'. Редактирование',
            'message' => Book::where('id', $id)->first(),
            'warning' => 'ОШИБКА!!! Вы ввели МАТ!!! Запись не добавлена',
            'text' => $text,
            'id' => $id
        ];
        return view('pages.edit', $data);
    }

    public function delete($id) {
        $message = Book::where('id', $id)->first();
        if ($message->email == Auth::user()->email || Auth::user()->admin == 1) {
            Book::where('id', $id)->delete();
            return redirect()->route('index');
        }
        $data = [
            'title' => 'Гостевая книга. Главная',
            'messages' => Book::latest()->paginate(3),
            'count' => Book::count(),
            'id' => $id,
            'warningdel' => 'Вы не можете удалить данную запись!!!'
        ];
        return view('pages.index', $data);
    }

    function containsStopWord($text, $stopWords) {
        foreach($stopWords as $stopWord) {
            if (mb_stripos($text, $stopWord) !== false) {
                return false;
            }
        }
        return true;
    }
}
