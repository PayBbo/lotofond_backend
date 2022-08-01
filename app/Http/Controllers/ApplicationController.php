<?php

namespace App\Http\Controllers;

use App\Http\Requests\ApplicationRequest;
use App\Http\Requests\ContactsRequest;
use App\Http\Requests\QuestionRequest;
use App\Jobs\SendApplication;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class ApplicationController extends Controller
{
    public function sendApplication(ApplicationRequest $request)
    {
        $user = User::find(auth()->id());
        $socials = 'Не указаны';
        if (gettype($request->socialsForAnswer) == 'array') {
            $socials = '';
            $count = count($request->socialsForAnswer);
            foreach ($request->socialsForAnswer as $key => $social) {
                if (++$key !== $count) {
                    $socials .= $social . ' ,';
                } else {
                    $socials .= $social;
                }
            }
        }
        $username = $user->surname . ' ' . $user->name;
        $lot = URL::to('/lot/' . $request->lotId);
        $html = "Пользователь $username оставил заявку на покупку без ЕЦП лота
            <a> $lot </a>
            <br>
            <strong>Почта: $request->email</strong>
             <br>
            <strong>Телефон: $request->phone</strong>
            <p>Социальные сети для ответа: $socials</p>";
        if (isset($request->dateForCallback) && strlen($request->dateForCallback) > 0) {
            $dateForCallback = Carbon::parse($request->dateForCallback)->format('d.m.Y H:i');
            $html .= " <p>Дата и время для ответа: $dateForCallback</p>";
        }
        $subject = 'Новая заявка на покупку без ЕЦП';
        dispatch_sync(new SendApplication($html, $subject, $request->email));
        return response(null, 200);
    }

    public function sendQuestion(QuestionRequest $request)
    {
        $user = User::find(auth()->id());
        $username = $user->surname . ' ' . $user->name;
        $html = "Пользователь $username  задал вопрос по теме:
            <p>$request->topic</p>
            <p>$request->question</p>
            <strong>Почта: $request->email</strong>";

        if ($request->hasFile('file')) {
            $path = Storage::disk('public')->put('questions/user-' . auth()->id(), $request->file);
            $path = Storage::url($path);
            $html .= " <br><a href=$path> Прикрепленный файл </a>";
        }
        $subject = 'Новый вопрос';
        dispatch_sync(new SendApplication($html, $subject, $request->email));
        return response(null, 200);
    }

    public function sendContacts(ContactsRequest $request)
    {
        $user = User::find(auth()->id());
        $communication = 'Почта для ответа: '.$request->communication;
        if($request->communicationType == 'phone'){
            $communication = 'Телефон для ответа: '.$request->communication;
        }
        $username = $user->surname . ' ' . $user->name;
        $html = "Пользователь $username  задал вопрос:
            <p>$request->question</p>
            <strong>$communication</strong>";
        $subject = 'Новый вопрос';
        dispatch_sync(new SendApplication($html, $subject, $request->communication));
        return response(null, 200);
    }
}
