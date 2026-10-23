
<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "Silakan isi form terlebih dahulu.";
    exit;
}

$labels = [
    "surname" => "Surname",
    "email" => "Email Address",
    "password" => "Password",
    "street_address" => "Street Address",
    "state" => "State",
    "country" => "Country",
    "sex" => "sex",
    "vegetarian" => "Vegetarian?"
];

echo "<h1>Hasil Data Form</h1>";

foreach ($_POST as $field => $value) {
    $label = $labels[$field] ?? $field;

    if ($field === "password") {
        $value = str_repeat("*", strlen($value));
    }

    echo "<p><strong>"
        . htmlspecialchars($label, ENT_QUOTES, "UTF-8")
        . ":</strong> "
        . htmlspecialchars((string) $value, ENT_QUOTES, "UTF-8")
        . "</p>";
}

?>
