var admin = require("firebase-admin");
var express = require("express");
var bodyParser = require("body-parser");

var serviceAccount = require("./push-notificacion-e38ac-firebase-adminsdk-fbsvc-6365ad118a.json");

admin.initializeApp({
  credential: admin.credential.cert(serviceAccount)
});

var app = express();
app.use(bodyParser.json());

app.post("/send-notification", (req, res) => {
  var data = req.body;
  var message = {
    notification: {
      title: data.asunto,
      body: data.mensaje
    },
    token: data.token // Usar el token recibido
  };

  admin.messaging().send(message)
    .then((response) => {
      res.json({ status: "success", message: "Notificación enviada", response });
    })
    .catch((error) => {
      res.status(500).json({ status: "error", message: "Error al enviar notificación", error });
    });
});

app.listen(3000, () => {
  console.log("Servidor Node.js corriendo en http://localhost:3000");
});
