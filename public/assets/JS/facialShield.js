window.onload = () => {
 const video = document.getElementById("loginvideo");
 const status = document.getElementById("face_status");
 const canvas = document.getElementById("overlay");
 const form = document.getElementById("biometry_form"); // Ton formulaire de login

 // Sécurité : si on n'est pas sur la page avec la vidéo, on arrête le script
 if (!video || !canvas) return;

 let isProcessing = false; // Verrou pour éviter les soumissions multiples

 // 1. Charger les modèles (Chemin corrigé pour ton dossier 'public/model')
 Promise.all([
   faceapi.nets.tinyFaceDetector.loadFromUri("/public/model"),
   faceapi.nets.faceLandmark68Net.loadFromUri("/public/model"),
   faceapi.nets.faceRecognitionNet.loadFromUri("/public/model"),
 ]).then(startCamera);

 // 2. Activer la Webcam
 async function startCamera() {
   if (navigator.mediaDevices && navigator.mediaDevices.getUserMedia) {
     try {
       const stream = await navigator.mediaDevices.getUserMedia({ video: {} });
       video.srcObject = stream;
     } catch (err) {
       if (status) status.innerText = "Accès webcam refusé ou HTTPS requis.";
       console.error("Erreur caméra : ", err);
     }
   } else {
     if (status)
       status.innerText = "Navigateur non compatible (vérifiez le HTTPS).";
   }
 }

 // 3. Analyse et Dessin
 video.addEventListener("play", () => {
   // On utilise la taille réelle d'affichage pour le canvas
   const displaySize = {
     width: video.clientWidth,
     height: video.clientHeight,
   };
   faceapi.matchDimensions(canvas, displaySize);

   const scanInterval = setInterval(async () => {
     if (isProcessing) return; // Stop si on a déjà envoyé les données

     const detection = await faceapi
       .detectSingleFace(video, new faceapi.TinyFaceDetectorOptions())
       .withFaceLandmarks()
       .withFaceDescriptor();

     if (detection) {
       // A. Redimensionner les coordonnées pour le dessin
       const resizedDetections = faceapi.resizeResults(detection, displaySize);

       // B. Nettoyer le canvas
       const ctx = canvas.getContext("2d");
       ctx.clearRect(0, 0, canvas.width, canvas.height);

       // C. DESSINER LES POINTS BLEUS ET LE CARRÉ
       faceapi.draw.drawFaceLandmarks(canvas, resizedDetections);
       faceapi.draw.drawDetections(canvas, resizedDetections);

       if (status) status.innerText = "Visage identifié. Authentification...";

       // D. Extraire le descripteur (Array de 128 chiffres)
       const descriptor = detection.descriptor;
       const field = document.getElementById("face_descriptor");

       if (field && form) {
         field.value = JSON.stringify(Array.from(descriptor));

         // Verrouillage et soumission
         isProcessing = true;
         clearInterval(scanInterval); // Arrête le scan

         // Petit délai visuel pour que l'admin voie le scan réussir
         setTimeout(() => {
           form.submit();
         }, 1000);
       }
     } else {
       // Si pas de visage, on nettoie le canvas
       canvas.getContext("2d").clearRect(0, 0, canvas.width, canvas.height);
       if (status) status.innerText = "Position yourself facing the camera";
     }
   }, 800); // Scan toutes les 800ms
 });
};
