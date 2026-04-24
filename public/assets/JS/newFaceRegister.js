document.addEventListener("DOMContentLoaded", () => {
  const video = document.getElementById("video");
  const btn = document.getElementById("capture_btn");
  Promise.all([
    faceapi.nets.tinyFaceDetector.loadFromUri("/public/model"),
    faceapi.nets.faceLandmark68Net.loadFromUri("/public/model"),
    faceapi.nets.faceRecognitionNet.loadFromUri("/public/model"),
  ]).then(() => {
    navigator.mediaDevices
      .getUserMedia({
        video: {},
      })
      .then((stream) => {
        video.srcObject = stream;
        document.getElementById("status").innerText =
          "Position yourself facing the camera";
      });
  });
  video.addEventListener("play", () => {
    const canvas = document.getElementById("overlay");

    const displaySize = {
      width: video.clientWidth,
      height: video.clientHeight,
    };

    faceapi.matchDimensions(canvas, displaySize);

    setInterval(async () => {
      const detection = await faceapi
        .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
        .withFaceLandmarks()
        .withFaceDescriptor();

      if (detection) {
        const resizedDetections = faceapi.resizeResults(detection, displaySize);

        // Nettoyage et dessin
        const ctx = canvas.getContext("2d");
        ctx.clearRect(0, 0, canvas.width, canvas.height);

        // Dessine les points bleus
        faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
        // Optionnel : dessine aussi la boîte de détection pour vérifier
        faceapi.draw.drawDetections(canvas, resizedDetections);

        document.getElementById("face_data").value = JSON.stringify(
          Array.from(detection.descriptor)
        );
        btn.disabled = false;
        btn.innerText = "Visage détecté : Prêt à enregistrer";
      }
    }, 500);
  });
});
