## 📱 VidVibe - Satire-TikTok – Own Video Feed Project (English)

This project is a simple **TikTok-like video app** where users can share short videos by uploading or recording them directly with the camera.  
By **swiping up/down**, the next or previous video is loaded.  
This app was created as a joke while I was lying in bed with the flu. However, I didn’t find the result that bad, and maybe someone can use it as a template.  
This project is meant to be simple and is not suitable for high scalability, as it does not use a database but rather JSON files, which are sent fully to the client and processed by it. There is no queue for encoding or load balancer. With a few adjustments, more could be done, but for fun with a small group of trusted friends, this app should be enough. A container virtualization is recommended. Encoder settings should be adjusted, the AV1 preset might be too high for slow servers, and the quality is optimized for small videos. The path of the log file should be changed or the log file should be turned off.

---

## ✨ Features  
✅ **Vertical video display** (similar to TikTok)  
✅ **Swipe to navigate** (Swipe up/down for next/previous video)  
✅ **Video upload** from the gallery or **direct camera recording**  
✅ **Auto-play & loop**  
✅ **Lightweight JSON-based video management**  

---

## 📷 Demo  
![VidVibe Preview Image](https://raw.githubusercontent.com/JanisPlayer/VidVibe/refs/heads/main/preview.webp)  

---

## 🚀 Installation & Usage  

### 1️⃣ Requirements  
- PHP-enabled web server  
- [FFmpeg](https://github.com/btbn/ffmpeg-builds/releases) (for video conversion)  

### 2️⃣ Setup  
1. **Clone the project**  
   ```
   mkdir /var/www/html/vidvibe
   cd /var/www/html/vidvibe
   wget https://raw.githubusercontent.com/JanisPlayer/VidVibe/refs/heads/main/index.html
   wget https://raw.githubusercontent.com/JanisPlayer/VidVibe/refs/heads/main/upload.php
   new_password=$(openssl rand -base64 16); sed -i "s/\$requiredPassword = 'PositiveVidVibes';/\$requiredPassword = '$new_password';/" /var/www/html/vidvibe/upload.php; echo "Your password is set to: $new_password"
   chown -R www-data:www-data /var/www/html/vidvibe
   chmod 750 /var/www/html/vidvibe/*
   ```
2. **Install FFmpeg** (if not already installed)  
   ```
   sudo apt install ffmpeg
   ```

---

## 📜 API Endpoints  
| Route            | Method | Description |
|------------------|--------|-------------|
| `/upload.php`    | `POST` | Video upload |
| `/v_index.json`  | `GET`  | List all videos |
| `/videos/`       | `GET`  | Access stored videos |

---

## 🔧 Technology Stack  
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Video Processing:** FFmpeg  

---

## 🛠 Future Development  
📌 **Feature Ideas:**  
- User profiles & login  
- Admin panel for allowing/approving video uploads, deleting videos, and managing encoder settings.  
- Allow users to delete videos.  
- Video comments  
- Like/Dislike functionality  

---

## 📜 License  
GPL-3.0 License – Feel free to use, modify, and improve as you like!  

---

## 📱 VidVibe - Satire-TikTok – Eigenes Video-Feed-Projekt (Deutsch)

Dieses Projekt ist eine einfache **TikTok-ähnliche Video-App**, in der Nutzer durch Hochladen oder direkte Kameraaufnahme kurze Videos teilen können.  
Mit **Wischen nach oben/unten** wird das nächste bzw. vorherige Video geladen.  
Diese Seite App ist entstanden, als Witz, als ich im Bett lag und die Grippe bekommen habe. Ich fand das Ergebnis aber gar nicht so schlecht und vielleicht kann es jemand als Vorlage brauchen.  
Dieses Projekt ist möglichst einfach gehalten und nicht für hohe Skalierung geeignet, da es keine Datenbank, sondern JSON-Dateien nutzt. Diese Dateien werden komplett an den Client gesendet und von diesem verarbeitet. Es gibt keine Warteschlange für das Encodieren und auch keinen Loadbalancer. Mit ein paar Anpassungen wäre jedoch mehr möglich. Als kleiner Spaß für eine kleine Gruppe von Freunden, denen man vertraut, sollte die App aber genügen. Eine Container-Virtualisierung wird empfohlen. Encoder-Einstellungen sollten angepasst werden, der AV1-Preset könnte zu hoch für langsame Server sein, und die Qualität ist auf kleine Videos optimiert. Der Pfad der Protokolldatei sollte geändert oder die Protokolldatei deaktiviert werden.

---

## ✨ Features  
✅ **Vertikale Videoanzeige** (ähnlich wie TikTok)  
✅ **Wischen zum Navigieren** (Swipe nach oben/unten für nächstes/vorheriges Video)  
✅ **Video-Upload** aus der Galerie oder **direkter Kameraaufnahme**  
✅ **Automatische Wiedergabe & Endlosschleife**  
✅ **Leichtgewichtige JSON-basierte Verwaltung der Videos**  

---

## 📷 Demo  
![VidVibe Vorschau Bild](https://raw.githubusercontent.com/JanisPlayer/VidVibe/refs/heads/main/preview.webp)  

---

## 🚀 Installation & Nutzung  

### 1️⃣ Voraussetzungen  
- PHP-fähiger Webserver  
- [FFmpeg](https://github.com/btbn/ffmpeg-builds/releases) (für die Videokonvertierung)  

### 2️⃣ Setup  
1. **Projekt klonen**  
   ```
   mkdir /var/www/html/vidvibe
   cd /var/www/html/vidvibe
   wget https://raw.githubusercontent.com/JanisPlayer/VidVibe/refs/heads/main/index.html
   wget https://raw.githubusercontent.com/JanisPlayer/VidVibe/refs/heads/main/upload.php
   new_password=$(openssl rand -base64 16); sed -i "s/\$requiredPassword = 'PositiveVidVibes';/\$requiredPassword = '$new_password';/" /var/www/html/vidvibe/upload.php; echo "Your password is set to: $new_password"
   chown -R www-data:www-data /var/www/html/vidvibe
   chmod 750 /var/www/html/vidvibe/*
   ```
2. **FFmpeg installieren** (Falls noch nicht vorhanden)  
   ```
   sudo apt install ffmpeg
   ```

---

## 📜 API-Endpunkte  
| Route            | Methode | Beschreibung |
|------------------|---------|--------------|
| `/upload.php`    | `POST`  | Video-Upload |
| `/v_index.json`  | `GET`   | Liste aller Videos |
| `/videos/`       | `GET`   | Zugriff auf gespeicherte Videos |

---

## 🔧 Technologie-Stack  
- **Frontend:** HTML, CSS, JavaScript  
- **Backend:** PHP  
- **Video-Verarbeitung:** FFmpeg  

---

## 🛠 Weiterentwicklung  
📌 **Feature Ideen:**  
- Benutzerprofile & Login  
- Admin-Panel für das Hochladen, Freischalten, Löschen von Videos und Verwaltung der Encoder-Einstellungen  
- Löschen von Videos durch Nutzer  
- Video-Kommentare  
- Like/Dislike-Funktion

---

## 📜 Lizenz  
GPL-3.0 Lizenz – Nutze, verändere und verbessere es nach Belieben!  
