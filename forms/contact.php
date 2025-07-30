<?php
// Simple PHP Contact Form
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');

// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['status' => 'error', 'message' => 'Method not allowed']);
    exit;
}

// Get form data
$name = $_POST['name'] ?? '';
$email = $_POST['email'] ?? '';
$subject = $_POST['subject'] ?? '';
$message = $_POST['message'] ?? '';

// Validate required fields
if (empty($name) || empty($email) || empty($subject) || empty($message)) {
    echo json_encode(['status' => 'error', 'message' => 'Please fill in all required fields']);
    exit;
}

// Validate email
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(['status' => 'error', 'message' => 'Please enter a valid email address']);
    exit;
}

// Set recipient email (your email)
$to = 'shatkratuswarnkar22@gmail.com';

// Create email headers
$headers = array(
    'From: ' . $email,
    'Reply-To: ' . $email,
    'X-Mailer: PHP/' . phpversion(),
    'Content-Type: text/html; charset=UTF-8'
);

// Create email subject
$email_subject = "Portfolio Contact: " . $subject;

// Create email body
$email_body = "
<html>
<head>
    <title>Portfolio Contact Form</title>
</head>
<body>
    <h2>New Contact Form Submission</h2>
    <p><strong>Name:</strong> " . htmlspecialchars($name) . "</p>
    <p><strong>Email:</strong> " . htmlspecialchars($email) . "</p>
    <p><strong>Subject:</strong> " . htmlspecialchars($subject) . "</p>
    <p><strong>Message:</strong></p>
    <p>" . nl2br(htmlspecialchars($message)) . "</p>
    <hr>
    <p><small>This message was sent from your portfolio contact form.</small></p>
</body>
</html>
";

// Try to send the email
if (mail($to, $email_subject, $email_body, implode("\r\n", $headers))) {
    echo json_encode(['status' => 'success', 'message' => 'Your message has been sent successfully!']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Sorry, there was an error sending your message. Please try again later.']);
}
?>
