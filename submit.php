<?php
// Check if the form was submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish a connection to the MySQL database
    $dbh = mysqli_connect("localhost", "DATABASE NAME", "PASSWORD", "USERNAME");
    
    // Check if the connection was successful
    if (!$dbh) {
        die('Could not connect: ' . mysqli_error());
    }
    
    mysqli_set_charset($dbh, "utf8mb4");
    
    // Get the URL value from the form
    $url = $_POST["url"];
    
    // Escape the URL to prevent SQL injection
    $url = mysqli_real_escape_string($dbh, $url);
    
    // Initialize cURL session
    $ch = curl_init($url);
    
    // Set cURL options
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    
    // Execute cURL session and get the HTML content
    $html = curl_exec($ch);
    
    // Check for cURL errors
    if (curl_errno($ch)) {
        echo "cURL Error: " . curl_error($ch);
        exit;
    }
    
    // Close cURL session
    curl_close($ch);
    
    // Extract the title from the HTML content
    if ($html) {
        if (preg_match("/<title>(.*?)<\/title>/i", $html, $matches)) {
            $title = mysqli_real_escape_string($dbh, $matches[1]);
        } else {
            $title = "Title not found";
        }
    } else {
        $title = "URL not accessible or invalid.";
    }
    
    // Get the current maximum ID value from the database
    $maxIdQuery = "SELECT MAX(ID) AS maxId FROM articles";
    $result = mysqli_query($dbh, $maxIdQuery);
    $row = mysqli_fetch_assoc($result);
    $maxId = $row["maxId"];
    
    // Calculate the new ID value
    $newId = $maxId + 1;
    
    // Create the current timestamp
    $timestamp = date('Y-m-d H:i:s');
    
    // Create an SQL query to insert the data into the "articles" table
    $sql = "INSERT INTO articles (ID, timestamp, URL, title) VALUES ('$newId', '$timestamp', '$url', '$title')";
    
    // Output HTML with CSS to center the result
    echo '<html>';
    echo '<head>';
    echo '<style>';
    echo 'body {';
    echo '    display: flex;';
    echo '    justify-content: center;';
    echo '    align-items: center;';
    echo '    height: 100vh;';
    echo '    margin: 0;';
    echo '    background-color: #f0f0f0;';
    echo '}';
    echo 'div {';
    echo '    text-align: center;';
    echo '    background-color: white;';
    echo '    padding: 20px;';
    echo '    border-radius: 5px;';
    echo '}';
    echo '</style>';
    echo '</head>';
    echo '<body>';
    echo '<div>';
    if (mysqli_query($dbh, $sql)) {
        echo "Article successfully submitted!";
    } else {
        echo "Error: " . $sql . "<br>" . mysqli_error($dbh);
    }
    echo '</div>';
    echo '</body>';
    echo '</html>';
    
    // Close the database connection
    mysqli_close($dbh);
}
?>
