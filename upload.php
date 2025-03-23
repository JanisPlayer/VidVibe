<?php
header('Content-Type: application/json');

// Definiere das Passwort
$requiredPassword = 'PositiveVidVibes';

$uploadDir = __DIR__ . '/videos/';
$jsonFile = __DIR__ . '/v_index.json';
$logFile = '/var/www/html/vidvibe/upload_debug.log'; // Change this pfad
$logFileActive = true;

function logMessage($message) {
    global $logFile;
    global $logFileActive;
    
    if ($logFileActive) {  // Überprüfen, ob Logging aktiviert ist
        // Sicherstellen, dass die Log-Datei existiert, und gegebenenfalls erstellen
        if (!file_exists($logFile)) {
            // Erstelle die Datei, wenn sie noch nicht existiert
            touch($logFile);
        }

        // Prüfen, ob die Datei oder das Verzeichnis beschreibbar ist
        if (is_writable($logFile) || is_writable(dirname($logFile))) {
            file_put_contents($logFile, date('[Y-m-d H:i:s] ') . $message . PHP_EOL, FILE_APPEND);
        } else {
            error_log("Fehler: Log-Datei ist nicht beschreibbar oder der Pfad ist ungültig.");
        }
    }
}

// Überprüfe, ob das Passwort im POST-Request vorhanden ist
if (!isset($_POST['password']) || $_POST['password'] !== $requiredPassword) {
    echo json_encode(['error' => 'Falsches Passwort']);
    logMessage("⚠️ Passwort falsch.". $_POST['password']);
    exit;
}

// Erstelle Videos-Ordner, falls nicht vorhanden
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0755, true);
    logMessage("📁 Ordner '$uploadDir' wurde erstellt.");
}

// Prüfe, ob eine Datei hochgeladen wurde
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['video'])) {
    $file = $_FILES['video'];
    $tmpPath = $file['tmp_name'];
    $fileExt = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $fileMimeType = $finfo->file($tmpPath);
    $tmpfilesize = filesize($tmpPath);

    //logMessage("📥 Upload erhalten: Name={$file['name']}, Typ={$file['type']}, Größe={$file['size']} Bytes");
    logMessage("📥 Upload erhalten: MimeType={$fileMimeType} Größe={$tmpfilesize} Bytes");

    // Prüfe die Dateigröße (optional, für zusätzliche Sicherheit)
    $maxFileSize = 100 * 1024 * 1024; // z.B. 100 MB
    if (filesize($tmpPath) > $maxFileSize) {
        logMessage("❌ Datei ist zu groß.");
        echo json_encode(['error' => 'Die Datei ist zu groß. Maximal erlaubte Größe: ' . ($maxFileSize / (1024 * 1024)) . ' MB']);
        exit;
    }

    // Prüfe das Client-Info-Format (optional: MIME-Typ und Dateiendung sollten übereinstimmen)
    $allowedFormats = ['mp4', 'mov', 'avi', 'mkv'];
    if (!in_array($fileExt, $allowedFormats)) {
        logMessage("❌ Ungültiges Videoformat: .$fileExt");
        echo json_encode(['error' => "Ungültiges Videoformat ($fileExt erlaubt: " . implode(', ', $allowedFormats) . ")"]);
        exit;
    }

    // Prüfe den tatsächlichen MIME-Typ der Datei mit der Fileinfo-Erweiterung
    // Erlaubte MIME-Typen für Videos (in diesem Fall MP4, MOV, AVI, MKV)
    $allowedMimeTypes = ['video/mp4', 'video/x-matroska', 'video/quicktime', 'video/avi'];

    if (!in_array($fileMimeType, $allowedMimeTypes)) {
        logMessage("❌ Ungültiger MIME-Typ: $fileMimeType");
        echo json_encode(['error' => "Ungültiger MIME-Typ ($fileMimeType erlaubt: " . implode(', ', $allowedMimeTypes) . ")"]);
        exit;
    }
    
    // Erstelle eine eindeutige ID für das Video
    $videoID = uniqid('vid_', true);
    $outputPath = $uploadDir . $videoID . '.mp4';
    
    // FFMPEG-Befehl mit zusätzlicher Fehlerausgabe
    $ffmpegCmd = "ffmpeg -i " . escapeshellarg($tmpPath) . 
        " -c:v libsvtav1 -b:v 500k -crf 45 -vf 'scale=trunc(iw*854/ih/2)*2:854' -c:a libopus -b:a 32k -ac 1 -strict -2 -y " . 
        escapeshellarg($outputPath) . " 2>&1";
    
    exec($ffmpegCmd, $output, $returnCode);
    logMessage("🔍 FFmpeg Ausgabe: " . implode("\n", $output));
    
    if ($returnCode === 0) {
        // JSON-Datei aktualisieren
        $videos = file_exists($jsonFile) ? json_decode(file_get_contents($jsonFile), true) : ['videos' => []]; 
        $videos['videos'][] = $videoID . '.mp4';
        file_put_contents($jsonFile, json_encode($videos, JSON_PRETTY_PRINT));
        
        logMessage("✅ Video erfolgreich verarbeitet: $videoID.mp4");
        echo json_encode(['success' => 'Video erfolgreich hochgeladen!', 'video' => $videoID . '.mp4']);
    } else {
        logMessage("❌ Fehler bei FFmpeg! Rückgabecode: $returnCode $ffmpegCmd");
        echo json_encode(['error' => "FFmpeg Fehler! Code: $returnCode  . $ffmpegCmd"]);
        if(file_exists($outputPath)) {
            unlink($outputPath);
        }
    }
    
    unlink($tmpPath);
    exit;
}

logMessage("⚠️ Ungültige Anfrage empfangen.");
echo json_encode(['error' => 'Ungültige Anfrage.']);
