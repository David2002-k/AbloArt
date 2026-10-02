<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessageController extends Controller
{
    public function index(): View
    {
        $messages = Message::query()->latest()->get();

        return view('admin.messages.index', compact('messages'));
    }

    public function update(Request $request, Message $message): RedirectResponse
    {
        $validated = $request->validate([
            'statut' => ['required', 'in:non_lu,lu,traite'],
        ]);

        $message->update($validated);

        return redirect()
            ->route('admin.messages.index')
            ->with('success', 'Le statut du message a été mis à jour.');
    }
}
