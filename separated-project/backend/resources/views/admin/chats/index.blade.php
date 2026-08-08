@extends('layouts.admin')

@section('title', 'Live Chat Customer Service')

@section('content')
<div class="bg-white rounded-[30px] border border-gray-100 shadow-xl overflow-hidden h-[calc(100vh-220px)] flex">
    
    <!-- Left Sidebar: Active User List -->
    <div class="w-80 border-r border-gray-100 flex flex-col">
        <div class="p-6 border-b border-gray-50 bg-gray-50/50">
            <h3 class="text-lg font-bold text-primary">Percakapan Aktif</h3>
            <p class="text-xs text-gray-400 mt-1">Daftar pengguna yang mengirim pesan</p>
        </div>

        <div class="flex-1 overflow-y-auto divide-y divide-gray-50" id="user-chat-list">
            @forelse($activeChats as $chatUser)
                <button onclick="selectUser({{ $chatUser->id }})" id="user-btn-{{ $chatUser->id }}" class="w-full text-left p-5 flex items-start gap-4 hover:bg-gray-50/50 transition-colors focus:outline-none group">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($chatUser->name) }}&background=0A192F&color=D4AF37&bold=true" class="w-10 h-10 rounded-full">
                    <div class="flex-1 min-w-0">
                        <div class="flex justify-between items-baseline mb-1">
                            <h4 class="text-sm font-bold text-primary truncate group-hover:text-accent transition-colors">{{ $chatUser->name }}</h4>
                        </div>
                        <p class="text-xs text-gray-400 truncate">{{ $chatUser->chats->first()->message }}</p>
                        <span class="text-[9px] text-gray-300 font-bold block mt-1 uppercase tracking-wider">
                            {{ $chatUser->chats->first()->created_at->diffForHumans() }}
                        </span>
                    </div>
                </button>
            @empty
                <div class="p-8 text-center text-gray-400 text-sm">
                    <i class="far fa-comment-dots text-3xl mb-3 block text-gray-300"></i>
                    Belum ada percakapan masuk.
                </div>
            @endforelse
        </div>
    </div>

    <!-- Right Area: Chat Window -->
    <div class="flex-1 flex flex-col bg-slate-50/30" id="chat-window-empty">
        <div class="flex-1 flex flex-col items-center justify-center text-center p-8">
            <div class="w-20 h-20 bg-accent/10 text-accent rounded-full flex items-center justify-center text-3xl mb-6 animate-bounce">
                <i class="fas fa-comments"></i>
            </div>
            <h3 class="text-xl font-bold text-primary mb-2">Pilih Percakapan</h3>
            <p class="text-sm text-gray-400 max-w-sm">Pilih salah satu pengguna di sebelah kiri untuk melihat pesan dan mulai membalas chat bantuan.</p>
        </div>
    </div>

    <div class="flex-1 flex flex-col bg-slate-50/30 hidden" id="chat-window-active">
        <!-- Header -->
        <div class="p-6 bg-white border-b border-gray-100 flex items-center justify-between shadow-sm">
            <div class="flex items-center gap-4">
                <img id="active-user-avatar" src="" class="w-11 h-11 rounded-full">
                <div>
                    <h4 id="active-user-name" class="text-base font-bold text-primary"></h4>
                    <p id="active-user-email" class="text-xs text-gray-400"></p>
                </div>
            </div>
            <span class="bg-emerald-50 text-emerald-600 text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider">
                Sesi Aktif
            </span>
        </div>

        <!-- Messages Box -->
        <div id="admin-chat-messages" class="flex-1 p-8 overflow-y-auto space-y-4 custom-scrollbar">
            <!-- Loaded dynamically via JS -->
        </div>

        <!-- Footer Input -->
        <form id="admin-chat-form" class="p-6 bg-white border-t border-gray-100 flex items-center gap-4 shadow-inner">
            <input type="text" id="admin-chat-input" placeholder="Tulis balasan Anda di sini..." autocomplete="off" class="flex-1 bg-gray-50 border-none rounded-2xl px-6 py-4.5 text-sm text-primary font-medium focus:ring-2 focus:ring-accent outline-none">
            <button type="submit" class="bg-primary hover:bg-secondary text-accent font-bold px-6 py-4.5 rounded-2xl shadow-xl transition-all hover:scale-105 active:scale-95 flex items-center gap-2 text-sm uppercase tracking-wider">
                <span>Kirim</span>
                <i class="fas fa-paper-plane text-xs"></i>
            </button>
        </form>
    </div>

</div>

<script>
    let currentSelectedUserId = null;
    let adminPollingInterval = null;
    let lastAdminMessageCount = 0;

    const chatWindowEmpty = document.getElementById('chat-window-empty');
    const chatWindowActive = document.getElementById('chat-window-active');
    const activeUserAvatar = document.getElementById('active-user-avatar');
    const activeUserName = document.getElementById('active-user-name');
    const activeUserEmail = document.getElementById('active-user-email');
    const adminChatMessages = document.getElementById('admin-chat-messages');
    const adminChatForm = document.getElementById('admin-chat-form');
    const adminChatInput = document.getElementById('admin-chat-input');

    function selectUser(userId) {
        currentSelectedUserId = userId;
        chatWindowEmpty.classList.add('hidden');
        chatWindowActive.classList.remove('hidden');

        // Clear previous interval if any
        if (adminPollingInterval) {
            clearInterval(adminPollingInterval);
        }

        lastAdminMessageCount = 0;
        fetchAdminMessages();
        
        // Poll messages for selected user every 3 seconds
        adminPollingInterval = setInterval(fetchAdminMessages, 3000);
        
        // Re-fetch chat list immediately to clear red dots
        fetchActiveChatsList();
    }

    function fetchAdminMessages() {
        if (!currentSelectedUserId) return;

        fetch(`/admin/chats/${currentSelectedUserId}/messages`)
            .then(response => response.json())
            .then(data => {
                activeUserName.textContent = data.user.name;
                activeUserEmail.textContent = data.user.email;
                activeUserAvatar.src = `https://ui-avatars.com/api/?name=${encodeURIComponent(data.user.name)}&background=0A192F&color=D4AF37&bold=true`;

                if (data.messages.length > lastAdminMessageCount) {
                    adminChatMessages.innerHTML = '';
                    
                    data.messages.forEach(msg => {
                        const messageDiv = document.createElement('div');
                        messageDiv.className = msg.is_from_admin 
                            ? 'flex items-start gap-3 max-w-[70%] ml-auto flex-row-reverse' 
                            : 'flex items-start gap-3 max-w-[70%]';

                        const avatarSrc = msg.is_from_admin 
                            ? 'https://ui-avatars.com/api/?name=CS+Travelingin&background=D4AF37&color=0A192F&bold=true'
                            : `https://ui-avatars.com/api/?name=${encodeURIComponent(data.user.name)}&background=0A192F&color=D4AF37&bold=true`;

                        messageDiv.innerHTML = `
                            <img src="${avatarSrc}" class="w-8 h-8 rounded-full mt-1">
                            <div>
                                <div class="${msg.is_from_admin ? 'bg-primary text-accent font-bold border-accent/10' : 'bg-white text-gray-700 border-gray-100'} text-xs p-4 rounded-2xl border leading-relaxed shadow-sm ${msg.is_from_admin ? 'rounded-tr-none' : 'rounded-tl-none'}">
                                    ${msg.message}
                                </div>
                                <span class="text-[9px] text-gray-400 block mt-1 ${msg.is_from_admin ? 'mr-1 text-right' : 'ml-1'}">${msg.time}</span>
                            </div>
                        `;
                        adminChatMessages.appendChild(messageDiv);
                    });

                    lastAdminMessageCount = data.messages.length;
                    scrollToAdminChatBottom();
                }
            })
            .catch(error => console.error("Error loading chat:", error));
    }

    // Poll the active user list every 4 seconds
    function fetchActiveChatsList() {
        fetch("{{ route('admin.chats.list') }}")
            .then(response => response.json())
            .then(users => {
                const chatListContainer = document.getElementById('user-chat-list');
                if (!chatListContainer) return;

                chatListContainer.innerHTML = '';
                if (users.length === 0) {
                    chatListContainer.innerHTML = `
                        <div class="p-8 text-center text-gray-400 text-sm">
                            <i class="far fa-comment-dots text-3xl mb-3 block text-gray-300"></i>
                            Belum ada percakapan masuk.
                        </div>
                    `;
                    return;
                }

                users.forEach(user => {
                    const isActive = (currentSelectedUserId === user.id);
                    const hasUnread = (!user.is_from_admin && !isActive);
                    
                    const btn = document.createElement('button');
                    btn.onclick = () => selectUser(user.id);
                    btn.id = `user-btn-${user.id}`;
                    btn.className = `w-full text-left p-5 flex items-start gap-4 hover:bg-gray-50/50 transition-colors focus:outline-none group ${isActive ? 'bg-gray-100/70 border-l-4 border-accent' : ''}`;
                    
                    btn.innerHTML = `
                        <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(user.name)}&background=0A192F&color=D4AF37&bold=true" class="w-10 h-10 rounded-full">
                        <div class="flex-1 min-w-0">
                            <div class="flex justify-between items-baseline mb-1">
                                <h4 class="text-sm font-bold text-primary truncate group-hover:text-accent transition-colors flex items-center gap-1.5">
                                    ${user.name}
                                    ${hasUnread ? '<span class="w-2.5 h-2.5 bg-red-500 rounded-full inline-block animate-pulse shadow-md" title="Pesan Baru"></span>' : ''}
                                </h4>
                            </div>
                            <p class="text-xs ${hasUnread ? 'text-primary font-bold' : 'text-gray-400'} truncate">${user.last_message}</p>
                            <span class="text-[9px] text-gray-300 font-bold block mt-1 uppercase tracking-wider">
                                ${user.time}
                            </span>
                        </div>
                    `;
                    chatListContainer.appendChild(btn);
                });
            })
            .catch(error => console.error("Error fetching active chats list:", error));
    }

    adminChatForm.addEventListener('submit', function (e) {
        e.preventDefault();
        const message = adminChatInput.value.trim();
        if (!message || !currentSelectedUserId) return;

        adminChatInput.value = '';

        const formData = new FormData();
        formData.append('message', message);
        formData.append('_token', "{{ csrf_token() }}");

        fetch(`/admin/chats/${currentSelectedUserId}/send`, {
            method: "POST",
            body: formData,
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                fetchAdminMessages();
                fetchActiveChatsList();
            }
        })
        .catch(error => console.error("Error sending admin reply:", error));
    });

    function scrollToAdminChatBottom() {
        adminChatMessages.scrollTop = adminChatMessages.scrollHeight;
    }

    // Call active chat list update initially and on interval
    fetchActiveChatsList();
    setInterval(fetchActiveChatsList, 4000);
</script>

<style>
    /* Custom scrollbar styling */
    .custom-scrollbar::-webkit-scrollbar {
        width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(10, 25, 47, 0.1);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(10, 25, 47, 0.2);
    }
</style>
@endsection
