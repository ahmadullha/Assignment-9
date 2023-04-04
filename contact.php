<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

  // Get form data
  $name = $_POST["name"];
  $email = $_POST["email"];
  $phone = $_POST["phone"];
  $subject = $_POST["subject"];
  $message = $_POST["message"];
  $token = $_POST["token"];

  // Validate token to prevent CSRF attacks
  if ($token !== "FsWga4&amp;@f6aw") {
    die("Invalid token.");
  }

  // Validate form data
  $errors = array();
  if (empty($name)) {
    $errors["name"] = "Name is required.";
  }
  if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors["email"] = "Email is invalid.";
  }
  if (empty($phone)) {
    $errors["phone"] = "Phone is required.";
  }
  if (empty($subject)) {
    $errors["subject"] = "Subject is required.";
  }
  if (empty($message)) {
    $errors["message"] = "Message is required.";
  }

  // If there are errors, return them to the form
  if (!empty($errors)) {
    $response = array(
      "status" => "error",
      "errors" => $errors
    );
    echo json_encode($response);
    exit();
  }

  // If there are no errors, send email to website owner
  $to = "youremail@example.com";
  $subject = "New message from $name";
  $body = "Name: $name\nEmail: $email\nPhone: $phone\nSubject: $subject\n\n$message";
  $headers = "From: $email\nReply-To: $email";
  if (mail($to, $subject, $body, $headers)) {
    $response = array(
      "status" => "success",
      "message" => "Thank you for contacting us. We will get back to you shortly."
    );
    echo json_encode($response);
    exit();
  } else {
    $response = array(
      "status" => "error",
      "message" => "Oops! Something went wrong. Please try again later."
    );
    echo json_encode($response);
    exit();
  }
}
?>
