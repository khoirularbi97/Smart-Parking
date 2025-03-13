<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard WebSocket</title>
    <script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>
</head>
<body>
    <h2>WebSocket Laravel Test</h2>
    <button onclick="sendNotification()">Kirim Notifikasi</button>

    <script>
        var socket = io("http://localhost:3001"); // Jika pakai Python, ubah ke "http://localhost:5000"

        // Menerima notifikasi dari server WebSocket
        socket.on("receiveNotification", function(data) {
            alert("Notifikasi Diterima: " + data.message);
        });

        // Mengirim notifikasi ke server WebSocket
        function sendNotification() {
            socket.emit("sendNotification", { message: "Saldo parkir terpakai!" });
        }
    </script>
</body>
</html>
