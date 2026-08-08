@auth
<div id="cs-chat-wrapper" class="fixed bottom-6 right-6 z-50 font-body">
    <!-- Chat Button -->
    <button id="chat-toggle-btn" class="w-16 h-16 bg-accent hover:bg-accent-hover text-primary rounded-full shadow-2xl flex items-center justify-center transition-all duration-300 transform hover:scale-110 hover:rotate-6 active:scale-95 focus:outline-none relative group">
        <i class="fas fa-comments text-2xl" id="chat-icon-open"></i>
        <i class="fas fa-times text-2xl hidden" id="chat-icon-close"></i>
        <span class="absolute -top-1 -right-1 w-4 h-4 bg-emerald-500 rounded-full border-2 border-white animate-pulse"></span>
        
        <!-- Notification Badge -->
        <span id="chat-notification-badge" class="hidden absolute -top-2 -right-2 bg-red-500 text-white text-[10px] font-bold w-6 h-6 rounded-full flex items-center justify-center shadow-lg border-2 border-primary animate-bounce">0</span>

        <!-- Tooltip -->
        <span class="absolute right-20 bg-primary text-white text-[10px] uppercase tracking-widest font-bold px-4 py-2 rounded-xl opacity-0 group-hover:opacity-100 transition-opacity duration-300 shadow-xl pointer-events-none whitespace-nowrap border border-white/5">
            Tanya CS Kami
        </span>
    </button>

    <!-- Chat Box -->
    <div id="chat-box" class="hidden absolute bottom-20 right-0 w-[380px] h-[500px] bg-primary border border-white/10 rounded-[30px] shadow-2xl flex flex-col overflow-hidden transition-all duration-300 transform scale-95 opacity-0 origin-bottom-right">
        <!-- Header -->
        <div class="p-6 bg-gradient-to-r from-primary to-secondary border-b border-white/5 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="relative">
                    <img src="https://ui-avatars.com/api/?name=CS+Travelingin&background=D4AF37&color=0A192F&bold=true" class="w-10 h-10 rounded-full border border-accent/20">
                    <span class="absolute bottom-0 right-0 w-3 h-3 bg-emerald-500 rounded-full border-2 border-primary"></span>
                </div>
                <div>
                    <h4 class="text-white font-bold text-sm tracking-wide">Customer Support</h4>
                    <p class="text-emerald-400 text-[10px] font-bold uppercase tracking-widest animate-pulse">Online &bull; Aktif</p>
                </div>
            </div>
            <button id="chat-close-header" class="text-white/40 hover:text-white transition-colors">
                <i class="fas fa-chevron-down text-lg"></i>
            </button>
        </div>

        <!-- Messages Body -->
        <div id="chat-messages" class="flex-1 p-6 overflow-y-auto space-y-4 bg-secondary/30 custom-scrollbar">
            <!-- Initial Welcome Message -->
            <div class="flex items-start gap-3 max-w-[80%]">
                <img src="https://ui-avatars.com/api/?name=CS+Travelingin&background=D4AF37&color=0A192F&bold=true" class="w-7 h-7 rounded-full mt-1">
                <div>
                    <div class="bg-secondary text-white/90 text-xs p-3.5 rounded-2xl rounded-tl-none border border-white/5 leading-relaxed">
                        Halo {{ Auth::user()->name }}! Ada yang bisa kami bantu mengenai rencana liburan Anda?
                    </div>
                    <span class="text-[9px] text-white/30 block mt-1 ml-1">Sekarang</span>
                </div>
            </div>
        </div>

        <!-- Input Footer -->
        <form id="chat-form" class="p-4 bg-primary border-t border-white/5 flex items-center gap-3">
            @csrf
            <input type="text" id="chat-input" placeholder="Tulis pesan Anda..." autocomplete="off" class="flex-1 bg-white/5 border border-white/10 rounded-2xl px-5 py-3 text-xs text-white placeholder-white/30 focus:border-accent outline-none transition-all">
            <button type="submit" class="w-10 h-10 bg-accent hover:bg-accent-hover text-primary rounded-xl flex items-center justify-center transition-all hover:scale-105 active:scale-95">
                <i class="fas fa-paper-plane text-sm"></i>
            </button>
        </form>
    </div>
</div>

<style>
    /* Custom Scrollbar for Chat Box */
    .custom-scrollbar::-webkit-scrollbar {
        width: 4px;
    }
    .custom-scrollbar::-webkit-scrollbar-track {
        background: transparent;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
        background: rgba(212, 175, 55, 0.2);
        border-radius: 10px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb:hover {
        background: rgba(212, 175, 55, 0.4);
    }
    #chat-box.show {
        display: flex !important;
        transform: scale(1) !important;
        opacity: 1 !important;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('chat-toggle-btn');
        const chatBox = document.getElementById('chat-box');
        const iconOpen = document.getElementById('chat-icon-open');
        const iconClose = document.getElementById('chat-icon-close');
        const closeHeader = document.getElementById('chat-close-header');
        const chatMessages = document.getElementById('chat-messages');
        const chatForm = document.getElementById('chat-form');
        const chatInput = document.getElementById('chat-input');
        const badge = document.getElementById('chat-notification-badge');
        
        let lastMessageCount = 0;
        let unreadCount = 0;

        // Toggle Chat Window
        toggleBtn.addEventListener('click', toggleChat);
        closeHeader.addEventListener('click', toggleChat);

        function toggleChat() {
            chatBox.classList.toggle('show');
            iconOpen.classList.toggle('hidden');
            iconClose.classList.toggle('hidden');

            if (chatBox.classList.contains('show')) {
                unreadCount = 0;
                updateNotificationBadge();
                scrollToBottom();
                fetchMessages();
            }
        }

        function updateNotificationBadge() {
            if (unreadCount > 0) {
                badge.textContent = unreadCount;
                badge.classList.remove('hidden');
            } else {
                badge.classList.add('hidden');
            }
        }

        // Fetch Messages from Server
        function fetchMessages() {
            fetch("{{ route('chat.messages') }}")
                .then(response => response.json())
                .then(messages => {
                    const isChatOpen = chatBox.classList.contains('show');

                    // If new messages exist
                    if (messages.length > lastMessageCount) {
                        // Count unread if chat is closed and it's not the initial load
                        if (!isChatOpen && lastMessageCount > 0) {
                            const newAdminMsgs = messages.slice(lastMessageCount).filter(msg => msg.is_from_admin).length;
                            unreadCount += newAdminMsgs;
                            updateNotificationBadge();
                        }

                        // Clear all except initial CS welcome message
                        const welcomeMessage = chatMessages.firstElementChild;
                        chatMessages.innerHTML = '';
                        chatMessages.appendChild(welcomeMessage);

                        messages.forEach(msg => {
                            const messageDiv = document.createElement('div');
                            messageDiv.className = msg.is_from_admin 
                                ? 'flex items-start gap-3 max-w-[80%]' 
                                : 'flex items-start gap-3 max-w-[80%] ml-auto flex-row-reverse';

                            const avatarSrc = msg.is_from_admin 
                                ? 'https://ui-avatars.com/api/?name=CS+Travelingin&background=D4AF37&color=0A192F&bold=true'
                                : 'https://ui-avatars.com/api/?name=' + encodeURIComponent("{{ Auth::user()->name }}") + '&background=0A192F&color=D4AF37&bold=true';

                            messageDiv.innerHTML = `
                                <img src="${avatarSrc}" class="w-7 h-7 rounded-full mt-1">
                                <div>
                                    <div class="${msg.is_from_admin ? 'bg-secondary text-white/90' : 'bg-accent text-primary font-bold'} text-xs p-3.5 rounded-2xl border border-white/5 leading-relaxed ${msg.is_from_admin ? 'rounded-tl-none' : 'rounded-tr-none'}">
                                        ${msg.message}
                                    </div>
                                    <span class="text-[9px] text-white/30 block mt-1 ${msg.is_from_admin ? 'ml-1' : 'mr-1 text-right'}">${msg.time}</span>
                                </div>
                            `;
                            chatMessages.appendChild(messageDiv);
                        });

                        lastMessageCount = messages.length;
                        
                        if (isChatOpen) {
                            scrollToBottom();
                        }
                    }
                })
                .catch(error => console.error("Error fetching messages:", error));
        }

        // Send Message
        chatForm.addEventListener('submit', function (e) {
            e.preventDefault();
            const message = chatInput.value.trim();
            if (!message) return;

            chatInput.value = '';

            const formData = new FormData();
            formData.append('message', message);
            formData.append('_token', "{{ csrf_token() }}");

            fetch("{{ route('chat.send') }}", {
                method: "POST",
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    fetchMessages();
                }
            })
            .catch(error => console.error("Error sending message:", error));
        });

        function scrollToBottom() {
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Start background polling immediately
        fetchMessages();
        setInterval(fetchMessages, 3000);
    });
</script>
@endauth
