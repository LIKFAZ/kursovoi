<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PageController extends Controller
{
    public function about()
    {
        return view('pages.about');
    }

    public function contact()
    {
        return view('pages.contact');
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        // Здесь можно добавить отправку email или сохранение в базу данных
        // Mail::to('admin@fishstore.ru')->send(new ContactMessage($request->all()));

        return back()->with('success', 'Ваше сообщение отправлено! Мы свяжемся с вами в ближайшее время.');
    }
}
