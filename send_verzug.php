<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$config = require '/etc/damagepage/smtp_config.php';

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate required fields
    $requiredFields = ['order_number', 'date', 'location', 'planned_date', 'actual_date', 'delay_reason'];
    $missingFields = [];

    foreach ($requiredFields as $field) {
        if (empty($_POST[$field])) {
            $missingFields[] = $field;
        }
    }

    if (!empty($missingFields)) {
        echo json_encode([
            "status" => "error",
            "message" => "Fehlende Eingaben: " . implode(", ", $missingFields)
        ]);
        exit;
    }    

    // Sanitize POST values
    $order_number = htmlspecialchars($_POST["order_number"], ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars($_POST["date"], ENT_QUOTES, 'UTF-8');
    $location = htmlspecialchars($_POST["location"], ENT_QUOTES, 'UTF-8');
    $planned_date = htmlspecialchars($_POST["planned_date"], ENT_QUOTES, 'UTF-8');
    $actual_date = htmlspecialchars($_POST["actual_date"], ENT_QUOTES, 'UTF-8');
    $delay_reason = htmlspecialchars($_POST["delay_reason"], ENT_QUOTES, 'UTF-8');

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->SMTPAuth = true; // Enable SMTP authentication
        $mail->Host = $config['smtp_host'];
        $mail->Username = $config['smtp_username']; // Ensure this is set in your config
        $mail->Password = $config['smtp_password'];
        $mail->Port = $config['smtp_port'];
        $mail->SMTPSecure = $config['smtp_secure'];
        $mail->SMTPAutoTLS = $config['smtp_autoTLS'];

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom($config['email_from'], $config['email_from_title']);
        $mail->addAddress($config['email_to'], $config['email_to_title']);
        $mail->Subject = "Verzugsschadenmeldung";

        $body = "Sehr geehrte Damen und Herren,\n\n";
        $body .= "nachfolgend finden Sie die Details zur Verzugsschadenmeldung:\n\n";
        $body .= "------------------------------------------------------------\n";
        $body .= "Auftragsnummer: " . $order_number . "\n";
        $body .= "Datum: " . $date . "\n";
        $body .= "Ort: " . $location . "\n";
        $body .= "Soll-Termin: " . $planned_date . "\n";
        $body .= "Ist-Termin: " . $actual_date . "\n";
        $body .= "Grund: " . $delay_reason . "\n";
        $body .= "------------------------------------------------------------\n\n";
        $body .= "Mit freundlichen Grüßen,\n";
        $body .= "Ihr Schadensportal-Team";

        $mail->Body = $body;
        $mail->isHTML(false);

        // Generate XML content
        $xml = new SimpleXMLElement('<Verzugsschadenmeldung/>');
        $xml->addChild('order_number', $order_number);
        $xml->addChild('date', $date);
        $xml->addChild('location', $location);
        $xml->addChild('planned_date', $planned_date);
        $xml->addChild('actual_date', $actual_date);
        $xml->addChild('Grund', $delay_reason);

        // Save XML to a temporary file
        $tempXmlFile = tempnam(sys_get_temp_dir(), 'xml');
        file_put_contents($tempXmlFile, $xml->asXML());

        // Attach the XML file to the email
        $mail->addAttachment($tempXmlFile, 'Verzugsschadenmeldung.xml');

        if (isset($_FILES['attachments'])) {
            foreach ($_FILES['attachments']['tmp_name'] as $key => $tmp_name) {
                if ($_FILES['attachments']['error'][$key] == 0) {
                    // Validate file type and size (example: max 7MB, allow PDFs and standard image formats)
                    $allowedMimeTypes = ['application/pdf', 'image/jpeg', 'image/png'];
                    if ($_FILES['attachments']['size'][$key] <= 7 * 1024 * 1024 &&
                        in_array(mime_content_type($tmp_name), $allowedMimeTypes)) {
                        $mail->addAttachment($tmp_name, $_FILES['attachments']['name'][$key]);
                    }
                }
            }
        }

        try {
            if ($mail->send()) {
                echo json_encode(["status" => "success", "message" => "Verzugsschaden erfolgreich gemeldet!"]);
            } else {
                echo json_encode(["status" => "error", "message" => "Fehler beim Senden der E-Mail: " . $mail->ErrorInfo]);
            }
        } catch (Exception $e) {
            echo json_encode(["status" => "error", "message" => "Fehler beim Senden der E-Mail: " . $e->getMessage()]);
        }

        // Clean up the temporary file after sending the email
        if (file_exists($tempXmlFile)) {
            unlink($tempXmlFile);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "Fehler: " . $e->getMessage()]);
    }
    
}

?>