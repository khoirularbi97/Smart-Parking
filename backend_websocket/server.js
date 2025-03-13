const express = require("express");
const http = require("http");
const socketIo = require("socket.io");
const cors = require("cors");

const app = express();
const server = http.createServer(app);
const io = socketIo(server, {
    cors: {
        origin: "*", // Sesuaikan jika perlu
        methods: ["GET", "POST"]
    }
});

app.use(cors());

// Event WebSocket
io.on("connection", (socket) => {
    console.log("User connected:", socket.id);

    socket.on("sendNotification", (data) => {
        console.log("Notif diterima:", data);
        io.emit("receiveNotification", data);
    });

    socket.on("disconnect", () => {
        console.log("User disconnected:", socket.id);
    });
});

// Jalankan server WebSocket di port 3001
server.listen(3001, () => {
    console.log("WebSocket server running on port 3001");
});
