<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Support\Facades\Log; // Logファサードをインポート

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::all();

        return view('admin.notifications.index', compact('notifications'));
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function show($id)
    {
        $notification = Notification::findOrFail($id); // 単一通知
        $user = Auth::user();

        // 既読登録
        $user->notifications()->syncWithoutDetaching([
            $notification->id => ['read_at' => now()],
        ]);

        return view('public.dashboard.notifications.show', compact('notification')); // 単数形で渡す
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);

        return view('admin.notifications.create', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        // バリデーション
        $validator = $this->validateNotification($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            // 編集フォームのルートにリダイレクト
            return redirect(route('admin.notifications.edit', $id))
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        try {
            $notification = Notification::findOrFail($id);

            $notification->saveNotification($request);


        } catch (Exception $e) {
            Log::channel('error')->alert('お知らせテーブルエラー(NotificationController->update)', [$e->getMessage()]);
            return redirect(route('admin.notification.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.notification.index'))->with('success', 'お知らせが正常に登録されました。');
    }

    public function store(Request $request)
    {
        // バリデーション
        $validator = $this->validateNotification($request);

        // バリデーションに失敗した場合
        if ($validator->fails()) {
            return redirect(route('admin.notification.create')) 
                ->withErrors($validator) // エラーメッセージをセッションに保存
                ->withInput(); // 直前に入力されたデータをセッションに保存
        }

        $notification = new Notification();
        try {
            $notification->saveNotification($request); 
        
        } catch (Exception $e) {
            Log::channel('error')->alert('お知らせテーブルエラー(NotificationController->store)', [$e->getMessage()]);
            return redirect(route('admin.notification.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.notification.index'))->with('success', 'お知らせが正常に登録されました。');
    }

    public function destroy($id)
    {
        try {
            $notification = Notification::findOrFail($id);
            
            $notification->delete();
            
        } catch (Exception $e) {
            Log::channel('error')->alert('お知らせテーブルエラー(NotificationController->destroy)', [$e->getMessage()]);
            return redirect(route('admin.notification.index'))->with('error', 'エラーが発生しました。システム管理者に連絡してください。');
        }

        return redirect(route('admin.notification.index'))->with('success', 'お知らせが正常に削除されました。');
    }

    private function validateNotification(Request $request)
    {
        $rules = [
            'title' => 'required',
            'body' => 'required',

        ];

        $messages = [
            'title.required' => ':attributeは必須項目です。',
            'body.required' => ':attributeは必須項目です。',
        ];
        
        $attributes = [
            'title' => 'タイトル',
            'body' => '内容',
         ];

        return Validator::make($request->all(), $rules, $messages, $attributes);
    }
}
