// Import required libraries
const express = require('express');
const http = require('http');
const socketIo = require('socket.io');
const dotenv = require('dotenv');
const Redis = require('ioredis');

// Load environment variables from .env file
dotenv.config();

// Initialize Express app
const app = express();

// Create HTTP server using Express app
const server = http.createServer(app);

// Initialize Socket.io server and configure CORS settings
const io = socketIo(server, {
    cors: {
        origin: "*",
        methods: ["GET", "POST"],
        credentials: true
    }
});

// Get Redis connection parameters from environment variables or use defaults
const redisPort = process.env.REDIS_PORT || 6379;
const redisHost = process.env.REDIS_HOST || 'localhost';
const redisPassword = process.env.REDIS_PASSWORD || null; // Assuming password might not be set

// Create Redis client instance
const redis = new Redis({
    port: redisPort,
    host: redisHost,
    password: redisPassword
});

// Handle socket connections
io.on('connection', (socket) => {
    // Event handler for when a user connects
    socket.on('user_connected', function (user_id) {
        console.log(`User connected: ${user_id}`);
    });

    // Event handler for when a user disconnects
    socket.on('disconnect', function() {
        console.log(`User disconnected: ${socket.id}`);
    });

    // When the server receives a 'chat-message' event from a client
    socket.on('chat-message', (data) => {
        console.log(`Received chat message: ${data.message}`);
        // Broadcast the received message to all connected clients
        io.emit('chat-message', { message: data.message });
    });
});

// Subscribe to the Redis channel for chat messages
const redisChannel = 'chat';
redis.subscribe(redisChannel, (err, count) => {
    if (err) {
        console.error('Error subscribing to Redis channel:', err);
    } else {
        console.log(`Subscribed to Redis channel: ${redisChannel}`);
    }
});

// Event handler for incoming messages from Redis
redis.on('message', function (channel, message) {
    console.log(`Received message in Redis channel ${channel}: ${message}`);
    // Emit the received message to all connected clients
    io.emit('chat-message', { message: message });
});

// Event handler for errors in receiving Redis messages
redis.on('error', function (error) {
    console.error('Error receiving message from Redis:', error);
});

// Define the port for the server to listen on
const port = process.env.PORT || 3000;

// Start the server and listen on the specified port
server.listen(port, () => {
    console.log(`Server is running on port ${port}`);
});
