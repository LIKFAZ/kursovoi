<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class PageController extends Controller
{
    public function about()
    {
        // Добавим данные для страницы "О нас"
        $teamMembers = [
            [
                'name' => 'Алексей Иванов',
                'position' => 'Основатель и CEO',
                'description' => 'Рыболов с 20-летним стажем',
                'image' => 'images/team/team-1.jpg'
            ],
            [
                'name' => 'Мария Петрова',
                'position' => 'Менеджер по продажам',
                'description' => 'Эксперт по снастям',
                'image' => 'images/team/team-2.jpg'
            ],
            [
                'name' => 'Дмитрий Сидоров',
                'position' => 'Технический директор',
                'description' => 'Разработчик платформы',
                'image' => 'images/team/team-3.jpg'
            ]
        ];
        
        return view('pages.about', compact('teamMembers'));
    }

    public function contact()
    {
        // Данные для карты - Красная площадь в Москве
        $mapData = [
            'address' => 'г. Москва, Красная площадь, д. 1',
            'lat' => 55.7558,
            'lng' => 37.6173,
            'zoom' => 15
        ];
        
        return view('pages.contact', compact('mapData'));
    }

    public function contactStore(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string|max:2000',
        ]);

        try {
            // Отправляем email
            Mail::to(config('mail.admin_email', 'admin@fishstore.ru'))
                ->send(new ContactMessage($request->all()));

            // Логируем успешную отправку
            Log::info('Contact form submitted', [
                'name' => $request->name,
                'email' => $request->email,
                'subject' => $request->subject,
            ]);

            return back()->with('success', 'Ваше сообщение отправлено! Мы свяжемся с вами в ближайшее время.');

        } catch (\Exception $e) {
            // Логируем ошибку
            Log::error('Failed to send contact email', [
                'error' => $e->getMessage(),
                'name' => $request->name,
                'email' => $request->email,
            ]);

            return back()->with('error', 'Произошла ошибка при отправке сообщения. Попробуйте позже или свяжитесь с нами по телефону.');
        }
    }
}
