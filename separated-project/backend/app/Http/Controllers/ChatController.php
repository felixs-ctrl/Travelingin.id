<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class ChatController extends Controller
{
    // For User: Fetch chat history
    public function fetchUserMessages(Request $request): JsonResponse
    {
        $messages = Chat::where('user_id', $request->user()->id)
            ->oldest()
            ->get()
            ->map(function ($chat) {
                return [
                    'message' => $chat->message,
                    'is_from_admin' => $chat->is_from_admin,
                    'time' => $chat->created_at->format('H:i'),
                ];
            });

        return response()->json($messages);
    }

    // For User: Send a new message
    public function sendUserMessage(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::create([
            'user_id' => $request->user()->id,
            'message' => $request->message,
            'is_from_admin' => false,
        ]);

        return response()->json([
            'success' => true,
            'message' => $chat->message,
            'time' => $chat->created_at->format('H:i'),
        ]);
    }

    // For Admin: Halaman panel chat CS
    public function adminIndex(): View
    {
        // Get all unique users who have sent messages
        $activeChats = User::whereHas('chats')
            ->with(['chats' => function ($query) {
                $query->latest();
            }])
            ->get()
            ->sortByDesc(function ($user) {
                return $user->chats->first()->created_at;
            });

        return view('admin.chats.index', compact('activeChats'));
    }

    // For Admin: Fetch active chats list as JSON
    public function adminFetchActiveChats(): JsonResponse
    {
        $activeChats = User::whereHas('chats')
            ->with(['chats' => function ($query) {
                $query->latest();
            }])
            ->get()
            ->map(function ($user) {
                $lastChat = $user->chats->first();
                return [
                    'id' => $user->id,
                    'name' => $user->name,
                    'last_message' => $lastChat->message,
                    'is_from_admin' => $lastChat->is_from_admin,
                    'time' => $lastChat->created_at->diffForHumans(),
                    'timestamp' => $lastChat->created_at->toIso8601String(),
                ];
            })
            ->sortByDesc('timestamp')
            ->values();

        return response()->json($activeChats);
    }

    // For Admin: Get chat history of specific user
    public function adminFetchMessages($userId): JsonResponse
    {
        $user = User::findOrFail($userId);
        $messages = Chat::where('user_id', $userId)
            ->oldest()
            ->get()
            ->map(function ($chat) {
                return [
                    'message' => $chat->message,
                    'is_from_admin' => $chat->is_from_admin,
                    'time' => $chat->created_at->format('H:i'),
                ];
            });

        return response()->json([
            'user' => [
                'name' => $user->name,
                'email' => $user->email,
            ],
            'messages' => $messages
        ]);
    }

    // For Admin: Send reply to specific user
    public function adminSendMessage(Request $request, $userId): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        $chat = Chat::create([
            'user_id' => $userId,
            'message' => $request->message,
            'is_from_admin' => true,
        ]);

        return response()->json([
            'success' => true,
            'message' => $chat->message,
            'time' => $chat->created_at->format('H:i'),
        ]);
    }
}
