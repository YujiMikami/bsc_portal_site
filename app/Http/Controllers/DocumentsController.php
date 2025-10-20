<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documents;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Response;

class DocumentsController extends Controller
{
    // 一覧表示
    public function index()
    {
        $documents = Documents::latest()->get();
        return view('public.documents.index', compact('documents'));
    }

    // 作成フォーム
    public function create()
    {
        return view('public.documents.create');
    }

    // 保存処理
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|mimes:pdf,jpg,jpeg|max:10240', // 10MB
        ]);
            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filename = mb_convert_encoding($filename, 'UTF-8', 'auto');
            $path = $file->storeAs('documents', $filename, 'public');
            $ext = strtolower($file->getClientOriginalExtension());

        Documents::create([
            'title' => $request->title,
            'file_path' => $path,
            'file_type' => $ext,
        ]);

        return redirect()->route('public.documents.index')->with('success', '資料をアップロードしました。');
    }

    // 編集フォーム
    public function edit($document_id)
    {
        $document = Documents::findOrFail($document_id);
        return view('public.documents.edit', compact('document'));
    }

    // 更新処理
    public function update(Request $request, Documents $document)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'nullable|mimes:pdf,jpg,jpeg|max:10240',
        ]);

        $updateData = ['title' => $request->title];

        // 新しいファイルがアップロードされた場合
        if ($request->hasFile('file')) {
            // 古いファイル削除
            Storage::disk('public')->delete($document->file_path);

            $file = $request->file('file');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filename = mb_convert_encoding($filename, 'UTF-8', 'auto');
            $path = $file->storeAs('documents', $filename, 'public');
            $ext = strtolower($file->getClientOriginalExtension());

            $updateData['file_path'] = $path;
            $updateData['file_type'] = $ext;
        }

        $document->update($updateData);

        return redirect()->route('public.documents.index')->with('success', '資料を更新しました。');
    }

    // 削除処理
    public function destroy(Documents $document)
    {
        // ファイル削除
        Storage::disk('public')->delete($document->file_path);
        $document->delete();

        return redirect()->route('public.documents.index')->with('success', '資料を削除しました。');
    }

    // PDFビュー
    public function view($id)
    {
        $document = Documents::findOrFail($id);

        $path = storage_path('app/public/' . $document->file_path);

        // ファイルが存在しなければ 404
        if (!file_exists($path)) {
            abort(404, 'ファイルが存在しません');
        }

        // MIMEタイプ自動判定
        $mimeType = \Illuminate\Support\Facades\File::mimeType($path) ?? 'application/octet-stream';

        // Content-Disposition は inline のみ（filenameは指定しない）
        return Response::make(file_get_contents($path), 200, [
        'Content-Type' => $mimeType,
        'Content-Disposition' => 'inline', // filename を削除
        ]);
    }
}
