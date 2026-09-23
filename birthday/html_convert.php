<?php
// The HTML content
$htmlContent = '<html><body><h1>Hello, World!</h1><p>This is a test HTML content.</p></body></html>';

// Temporary file for HTML content
$fileHtml = 'temp.html';
file_put_contents($fileHtml, $htmlContent);

// Output image file
$imageFile = 'output.png';

// Command to convert HTML to image
$command = "wkhtmltoimage --format png --quality 90 $fileHtml $imageFile";

// Execute the command
exec($command);

// Remove the temporary HTML file
unlink($fileHtml);

// Check if the image was created successfully
if (file_exists($imageFile)) {
    echo "Image created successfully.";
} else {
    echo "Failed to create image.";
}
?>