const io = require("socket.io-client");
const socket = io("http://localhost:3001");

socket.on("connect", () => {
    console.log("Terhubung ke WebSocket Server:", socket.id);
    socket.emit("sendNotification", { message: "Test dari Node.js Client!" });
});

socket.on("receiveNotification", (data) => {
    console.log("Notifikasi diterima:", data);
});
