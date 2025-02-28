<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = strip_tags(trim($_POST["name"]));
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $message = trim($_POST["message"]);

    if (empty($name) || empty($message) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400); // Bad request
        echo json_encode(['success' => false, 'message' => "Please fill out all fields correctly."]);
        exit;
    }

    $recipient = "rsfdvg@gmail.com"; // Replace with your email address
    $subject = "New Contact Form Submission from $name";
    $email_content = "Name: $name\n";
    $email_content .= "Email: $email\n\n";
    $email_content .= "Message:\n$message\n";
    $email_headers = "From: $name <$email>";

    if (mail($recipient, $subject, $email_content, $email_headers)) {
        http_response_code(200); // OK
        echo json_encode(['success' => true, 'message' => "Thank you! Your message has been sent."]);
    } else {
        http_response_code(500); // Internal Server Error
        echo json_encode(['success' => false, 'message' => "Oops! Something went wrong and we couldn't send your message."]);
    }

} else {
    http_response_code(403); // Forbidden
    echo json_encode(['success' => false, 'message' => "There was a problem with your submission, please try again."]);
}
?>