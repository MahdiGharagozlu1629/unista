const http = require('http');
const { Server } = require('socket.io');

const PORT = process.env.SOCKET_PORT || 3000;

// Create HTTP server with health check
const server = http.createServer((req, res) => {
    // Set CORS headers for simple HTTP requests
    res.setHeader('Access-Control-Allow-Origin', '*');
    res.setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS');
    res.setHeader('Access-Control-Allow-Headers', 'Content-Type');

    if (req.method === 'OPTIONS') {
        res.writeHead(204);
        res.end();
        return;
    }

    if (req.url === '/' || req.url === '/health') {
        res.writeHead(200, { 'Content-Type': 'application/json; charset=utf-8' });
        res.end(JSON.stringify({
            status: 'ok',
            service: 'Unista Real-Time Socket.IO Server',
            port: PORT,
            timestamp: new Date().toISOString()
        }));
        return;
    }

    res.writeHead(404, { 'Content-Type': 'application/json' });
    res.end(JSON.stringify({ error: 'Not Found' }));
});

// Initialize Socket.IO with permissive CORS for local development
const io = new Server(server, {
    cors: {
        origin: '*',
        methods: ['GET', 'POST'],
        credentials: true
    }
});

io.on('connection', (socket) => {
    let currentUserId = null;

    // 1. User Registration to personal room
    socket.on('register', (userId) => {
        if (!userId) return;
        currentUserId = String(userId);
        const roomName = `user_${currentUserId}`;

        socket.join(roomName);
        console.log(`[Socket] User ${currentUserId} registered on socket ${socket.id}`);
    });

    // 2. Real-time message dispatch
    socket.on('send_message', (payload) => {
        if (!payload || !payload.receiverId) return;

        console.log(`[Socket] Message from ${payload.senderId} to ${payload.receiverId}: "${payload.body}"`);

        const receiverRoom = `user_${payload.receiverId}`;
        const senderRoom = `user_${payload.senderId}`;

        // Send to receiver
        socket.to(receiverRoom).emit('receive_message', payload);

        // Also broadcast to other tabs of the sender
        socket.to(senderRoom).emit('message_sent', payload);
    });

    // 3. Read receipts
    socket.on('mark_read', (payload) => {
        if (!payload || !payload.senderId) return;
        socket.to(`user_${payload.senderId}`).emit('messages_marked_read', {
            conversationId: payload.conversationId,
            readerId: payload.readerId
        });
    });

    // Disconnect cleanup
    socket.on('disconnect', () => {
        console.log(`[Socket] Socket disconnected: ${socket.id}`);
    });
});

server.listen(PORT, () => {
    console.log(`=========================================`);
    console.log(` Unista Real-Time Chat Server (Socket.IO) `);
    console.log(` Running on: http://localhost:${PORT}     `);
    console.log(`=========================================`);
});
