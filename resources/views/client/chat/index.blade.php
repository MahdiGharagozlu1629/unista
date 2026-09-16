@extends('client.layout')

@section('main')
    <div class="direct-container {{ $activeConversation ? 'has-active-chat' : '' }}">
        {{-- Right Panel: Conversations List --}}
        <div class="direct-sidebar">
            <div class="direct-sidebar-header">
                <div class="direct-current-user">
                    <span class="direct-current-username">{{ $currentUser->username ?? 'پیام‌ها' }}</span>
                </div>
                <a href="{{ route('search') }}" class="direct-new-chat-btn" title="شروع گفت‌وگوی جدید">
                    <span class="fe fe-edit"></span>
                </a>
            </div>

            {{-- Thread Search --}}
            <div class="direct-search-box">
                <span class="fe fe-search direct-search-icon"></span>
                <input type="text" id="threadSearchInput" class="direct-search-input" placeholder="جستجوی گفت‌وگوها..." autocomplete="off">
            </div>

            {{-- Threads List --}}
            <div class="direct-threads-list" id="directThreadsList">
                @forelse($conversations as $conv)
                    @php
                        $peer = $conv->other_user;
                        $isActive = $activeConversation && $activeConversation->id === $conv->id;
                    @endphp
                    @if($peer)
                        <a href="{{ route('chat.show', ['conversationId' => $conv->id]) }}" 
                           class="direct-thread-item {{ $isActive ? 'active' : '' }}" 
                           data-conversation-id="{{ $conv->id }}"
                           data-peer-id="{{ $peer->id }}"
                           data-peer-name="{{ $peer->username }}">
                            <div class="direct-thread-avatar-wrap">
                                <img src="{{ $peer->avatar_url }}" alt="{{ $peer->username }}" class="direct-thread-avatar">
                            </div>
                            <div class="direct-thread-info">
                                <div class="direct-thread-top">
                                    <span class="direct-thread-name">{{ $peer->username }}</span>
                                    <span class="direct-thread-time" id="thread-time-{{ $conv->id }}">
                                        {{ $conv->last_message_at ? $conv->last_message_at->diffForHumans(null, true) : '' }}
                                    </span>
                                </div>
                                <div class="direct-thread-bottom">
                                    <span class="direct-thread-preview" id="thread-preview-{{ $conv->id }}">
                                        {{ $conv->last_message ? \Illuminate\Support\Str::limit($conv->last_message, 35) : 'شروع مکالمه...' }}
                                    </span>
                                    <span class="direct-unread-badge" id="thread-unread-{{ $conv->id }}" style="{{ $conv->unread_count > 0 ? '' : 'display: none;' }}">
                                        {{ $conv->unread_count }}
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endif
                @empty
                    <div class="direct-threads-empty">
                        <span class="fe fe-message-circle direct-empty-icon"></span>
                        <p class="direct-empty-text">هنوز پیامی وجود ندارد.</p>
                        <a href="{{ route('search') }}" class="direct-start-btn">یافتن مخاطبان</a>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Left Panel: Active Chat or Empty State --}}
        <div class="direct-chat-area">
            @if($activeConversation && $activeConversation->other_user)
                @php
                    $peer = $activeConversation->other_user;
                @endphp
                {{-- Active Chat Header --}}
                <div class="direct-chat-header">
                    <div class="direct-header-user">
                        <a href="{{ route('chat.index') }}" class="direct-back-btn" title="بازگشت به گفت‌وگوها">
                            <span class="fe fe-arrow-right"></span>
                        </a>
                        <a href="{{ route('users.show', ['id' => $peer->id]) }}" class="direct-header-avatar-link">
                            <img src="{{ $peer->avatar_url }}" alt="{{ $peer->username }}" class="direct-header-avatar">
                        </a>
                        <div class="direct-header-info">
                            <a href="{{ route('users.show', ['id' => $peer->id]) }}" class="direct-header-name">
                                {{ $peer->username }}
                            </a>
                        </div>
                    </div>
                    <div class="direct-header-actions">
                        <a href="{{ route('users.show', ['id' => $peer->id]) }}" class="direct-action-btn" title="مشاهده پروفایل">
                            <span class="fe fe-info"></span>
                        </a>
                    </div>
                </div>

                {{-- Messages Stream --}}
                <div class="direct-messages-stream" id="directMessagesStream">
                    <div class="direct-conversation-start">
                        <img src="{{ $peer->avatar_url }}" alt="{{ $peer->username }}" class="direct-start-avatar">
                        <h4 class="direct-start-title">{{ $peer->username }}</h4>
                        <p class="direct-start-desc">دانشجوی فعال در Unista</p>
                        <a href="{{ route('users.show', ['id' => $peer->id]) }}" class="direct-view-profile-btn">مشاهده پروفایل</a>
                    </div>

                    <div class="direct-messages-container" id="directMessagesContainer">
                        @foreach($messages as $msg)
                            @php
                                $isMe = ($msg->sender_id == $currentUserId);
                            @endphp
                            <div class="direct-msg-row {{ $isMe ? 'msg-row-me' : 'msg-row-peer' }}" data-msg-id="{{ $msg->id }}">
                                @if(!$isMe)
                                    <img src="{{ $peer->avatar_url }}" alt="" class="direct-msg-avatar">
                                @endif
                                <div class="direct-bubble {{ $isMe ? 'bubble-me' : 'bubble-peer' }}">
                                    <div class="direct-bubble-text">{{ $msg->body }}</div>
                                    <div class="direct-bubble-meta">
                                        <span class="direct-bubble-time">{{ $msg->time_formatted }}</span>
                                        @if($isMe)
                                            <span class="direct-bubble-status">
                                                <span class="fe fe-check msg-check {{ $msg->is_read ? 'is-read' : '' }}"></span>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Message Input Bar --}}
                <div class="direct-input-bar">
                    <form id="directSendForm" class="direct-send-form" autocomplete="off">
                        @csrf
                        <input type="hidden" name="conversation_id" value="{{ $activeConversation->id }}">
                        <input type="hidden" name="receiver_id" value="{{ $peer->id }}">

                        <div class="direct-input-wrap">
                            <textarea id="directMessageInput" 
                                      name="body" 
                                      class="direct-textarea" 
                                      placeholder="ارسال پیام..." 
                                      rows="1" 
                                      required></textarea>
                            
                            <button type="submit" class="direct-send-btn" id="directSendBtn" title="ارسال پیام" disabled>
                                <span class="fe fe-send"></span>
                            </button>
                        </div>
                    </form>
                </div>
            @else
                {{-- No Active Conversation Selected (Empty State) --}}
                <div class="direct-empty-selection">
                    <div class="direct-empty-inner">
                        <div class="direct-empty-icon-ring">
                            <span class="fe fe-send"></span>
                        </div>
                        <h3 class="direct-empty-title">پیام‌های شما</h3>
                        <p class="direct-empty-subtitle">عکس‌ها و پیام‌های خصوصی خود را با دوستانتان به اشتراک بگذارید.</p>
                        <a href="{{ route('search') }}" class="ig-btn ig-btn-primary direct-start-chat-btn">
                            ارسال پیام
                        </a>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@section('js')
    {{-- Local Socket.IO Client Library --}}
    <script src="{{ asset('js/socket.io.min.js') }}"></script>

    <script>
        $(document).ready(function () {
            const currentUserId = {{ (int)$currentUserId }};
            const activeConversationId = {{ $activeConversation ? (int)$activeConversation->id : 'null' }};
            const activePeerId = {{ ($activeConversation && $activeConversation->other_user) ? (int)$activeConversation->other_user->id : 'null' }};
            const currentUsername = "{{ $currentUser->username ?? '' }}";
            const csrfToken = "{{ csrf_token() }}";

            // 1. Initialize Socket.IO Client
            let socket = null;
            let socketConnected = false;
            const socketUrl = window.location.protocol + '//' + window.location.hostname + ':3000';

            try {
                socket = io(socketUrl, {
                    transports: ['websocket', 'polling'],
                    reconnection: true,
                    reconnectionAttempts: 10,
                    reconnectionDelay: 1500,
                    timeout: 4000
                });

                socket.on('connect', function () {
                    socketConnected = true;
                    console.log('[Socket] Connected to server:', socket.id);
                    socket.emit('register', currentUserId);
                });

                socket.on('disconnect', function () {
                    socketConnected = false;
                    console.log('[Socket] Disconnected from server');
                });

                socket.on('connect_error', function (err) {
                    socketConnected = false;
                    // Silent failover to standard HTTP AJAX
                });

                // Real-time message receiver
                socket.on('receive_message', function (msg) {
                    handleIncomingMessage(msg);
                });

                // Message sent from other tab of same user
                socket.on('message_sent', function (msg) {
                    if (activeConversationId && msg.conversationId === activeConversationId) {
                        if ($('#directMessagesContainer').find('[data-msg-id="' + msg.messageId + '"]').length === 0) {
                            appendMessageBubble(msg, true);
                        }
                    }
                    updateThreadSnippet(msg.conversationId, msg.body, 'چند لحظه پیش', false);
                });

                // Read receipts
                socket.on('messages_marked_read', function (data) {
                    if (activeConversationId && data.conversationId === activeConversationId) {
                        $('.msg-row-me .msg-check').addClass('is-read');
                    }
                });

            } catch (e) {
                console.warn('[Socket] Could not initialize socket client, fallback to AJAX:', e);
            }

            // 2. Incoming Message Handler
            function handleIncomingMessage(msg) {
                if (activeConversationId && Number(msg.conversationId) === Number(activeConversationId)) {
                    // Conversation is currently active on screen
                    appendMessageBubble(msg, false);

                    // Mark as read immediately on server & emit receipt
                    markConversationRead(activeConversationId, msg.senderId);
                } else {
                    // Update badge and preview on conversation thread item
                    incrementThreadUnread(msg.conversationId);
                }

                updateThreadSnippet(msg.conversationId, msg.body, 'چند لحظه پیش', true);
            }

            // 3. Mark conversation read
            function markConversationRead(conversationId, senderId) {
                $.ajax({
                    url: '{{ url("direct/read") }}/' + conversationId,
                    type: 'POST',
                    data: { _token: csrfToken }
                });

                if (socket && socketConnected) {
                    socket.emit('mark_read', {
                        conversationId: conversationId,
                        readerId: currentUserId,
                        senderId: senderId
                    });
                }

                $('#thread-unread-' + conversationId).hide().text('0');
            }

            // 4. Append message to chat container
            function appendMessageBubble(msg, isMe) {
                const bubbleHtml = `
                    <div class="direct-msg-row ${isMe ? 'msg-row-me' : 'msg-row-peer'}" data-msg-id="${msg.messageId || msg.id}">
                        ${!isMe ? `<img src="${msg.senderAvatar || msg.sender_avatar || '{{ $activeConversation && $activeConversation->other_user ? $activeConversation->other_user->avatar_url : asset('img/profile.jpg') }}'}" class="direct-msg-avatar" alt="">` : ''}
                        <div class="direct-bubble ${isMe ? 'bubble-me' : 'bubble-peer'}">
                            <div class="direct-bubble-text">${escapeHtml(msg.body)}</div>
                            <div class="direct-bubble-meta">
                                <span class="direct-bubble-time">${msg.timeFormatted || msg.time_formatted || 'الان'}</span>
                                ${isMe ? `
                                    <span class="direct-bubble-status">
                                        <span class="fe fe-check msg-check ${msg.is_read ? 'is-read' : ''}"></span>
                                    </span>
                                ` : ''}
                            </div>
                        </div>
                    </div>
                `;

                $('#directMessagesContainer').append(bubbleHtml);
                $('#directTypingRow').hide();
                scrollChatToBottom();
            }

            // 5. Scroll chat to bottom
            function scrollChatToBottom(smooth = true) {
                const stream = document.getElementById('directMessagesStream');
                if (stream) {
                    if (smooth) {
                        stream.scrollTo({ top: stream.scrollHeight, behavior: 'smooth' });
                    } else {
                        stream.scrollTop = stream.scrollHeight;
                    }
                }
            }

            // Auto-scroll on initial load
            scrollChatToBottom(false);

            // 6. Update thread item snippet in sidebar
            function updateThreadSnippet(convId, text, time, unread) {
                const $thread = $('[data-conversation-id="' + convId + '"]');
                if ($thread.length) {
                    $('#thread-preview-' + convId).text(text);
                    if (time) $('#thread-time-+' + convId).text(time);
                    // Move thread to top of list
                    $('#directThreadsList').prepend($thread);
                }
            }

            function incrementThreadUnread(convId) {
                const $badge = $('#thread-unread-' + convId);
                if ($badge.length) {
                    let count = parseInt($badge.text()) || 0;
                    count += 1;
                    $badge.text(count).show();
                }
            }

            // 7. Input & Send Handling
            const $msgInput = $('#directMessageInput');
            const $sendBtn = $('#directSendBtn');
            const $sendForm = $('#directSendForm');

            // Auto-grow textarea & enable send button
            $msgInput.on('input', function () {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';

                const text = $(this).val().trim();
                $sendBtn.prop('disabled', text.length === 0);
            });

            // Enter key to send (Shift+Enter for newline)
            $msgInput.on('keydown', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    if (!$sendBtn.prop('disabled')) {
                        $sendForm.trigger('submit');
                    }
                }
            });

            // Submit message form
            $sendForm.on('submit', function (e) {
                e.preventDefault();
                const body = $msgInput.val().trim();
                if (!body) return;

                $msgInput.val('').css('height', 'auto');
                $sendBtn.prop('disabled', true);

                // AJAX request to Laravel for database persistence
                $.ajax({
                    url: '{{ route("chat.send") }}',
                    type: 'POST',
                    data: {
                        _token: csrfToken,
                        conversation_id: activeConversationId,
                        receiver_id: activePeerId,
                        body: body
                    },
                    dataType: 'json',
                    success: function (res) {
                        if (res.success && res.message) {
                            const msg = res.message;
                            // Append bubble
                            appendMessageBubble(msg, true);
                            updateThreadSnippet(activeConversationId, body, 'الان', false);

                            // Broadcast via Socket.IO
                            if (socket && socketConnected) {
                                socket.emit('send_message', {
                                    messageId: msg.id,
                                    conversationId: activeConversationId,
                                    senderId: currentUserId,
                                    receiverId: activePeerId,
                                    body: msg.body,
                                    timeFormatted: msg.time_formatted,
                                    timeHuman: msg.time_human,
                                    createdAt: msg.created_at,
                                    senderUsername: currentUsername,
                                    senderAvatar: msg.sender_avatar
                                });
                            }
                        }
                    },
                    error: function (xhr) {
                        alert(xhr.responseJSON?.message || 'خطا در ارسال پیام. لطفاً دوباره تلاش کنید.');
                    }
                });
            });

            // 8. Thread Search Filter in Sidebar
            $('#threadSearchInput').on('input', function () {
                const query = $(this).val().toLowerCase().trim();
                $('.direct-thread-item').each(function () {
                    const name = ($(this).data('peer-name') || '').toLowerCase();
                    if (!query || name.includes(query)) {
                        $(this).show();
                    } else {
                        $(this).hide();
                    }
                });
            });

            function escapeHtml(text) {
                if (!text) return '';
                const map = { '&': '&amp;', '<': '&lt;', '>': '&gt;', '"': '&quot;', "'": '&#039;' };
                return text.replace(/[&<>"']/g, function (m) { return map[m]; });
            }
        });
    </script>
@endsection
