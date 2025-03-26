<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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
        $mail->Host = '62.245.135.33';
        $mail->SMTPAuth = true;
        $mail->Username = 'fmrelay4you';
        $mail->Password = 'mgrelay4fm!';
        $mail->SMTPSecure = false;
        $mail->SMTPAutoTLS = false;
        $mail->Port = 25;

        $mail->CharSet = 'UTF-8';
        $mail->Encoding = 'base64';

        $mail->setFrom('test@oberrader.com', 'Schadensportal');
        $mail->addAddress('test@oberrader.com', 'Schadensmanagement');
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

        foreach ($_FILES['delivery_note']['tmp_name'] as $key => $tmp_name) {
            if ($_FILES['delivery_note']['error'][$key] == 0) {
                $mail->addAttachment($tmp_name, $_FILES['delivery_note']['name'][$key]);
            }
        }

        if ($mail->send()) {
            echo json_encode(["status" => "success", "message" => "Verzugsschaden erfolgreich gemeldet!"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Fehler beim Senden der E-Mail."]);
        }

        // Clean up the temporary file after sending the email
        if (file_exists($tempXmlFile)) {
            unlink($tempXmlFile);
        }
    } catch (Exception $e) {
        echo json_encode(["status" => "error", "message" => "? Fehler: {$mail->ErrorInfo}"]);
    }
    
}

?>