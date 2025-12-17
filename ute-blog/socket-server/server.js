const express = require('express');
const http = require('http');
const { Server } = require('socket.io');
const cors = require('cors');
const bodyParser = require('body-parser');

const app = express();
app.use(cors());
app.use(bodyParser.json());

const server = http.createServer(app);
const io = new Server(server, {
    cors: {
        origin: "*", // Allow all origins for simplicity in development
        methods: ["GET", "POST"]
    }
});

io.on('connection', (socket) => {
    console.log('A user connected: ' + socket.id);

    socket.on('disconnect', () => {
        console.log('User disconnected: ' + socket.id);
    });
});

// Webhook endpoint for Laravel to notify about new comments
app.post('/api/comments/notify', (req, res) => {
    const commentData = req.body;
    console.log('Received new comment:', commentData);

    // Broadcast the event to all connected clients
    io.emit('new_comment', commentData);

    res.status(200).json({ status: 'success', message: 'Comment broadcasted' });
});

const PORT = 3000;
server.listen(PORT, () => {
    console.log(`Socket server running on port ${PORT}`);
});
