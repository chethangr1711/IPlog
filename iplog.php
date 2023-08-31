<?php
$ip = isset($_GET['ip']) ? $_GET['ip'] : '';
$apiKey = 'ed42569e5664df';

if (!empty($ip)) {
    $jsonData = file_get_contents("https://ipinfo.io/{$ip}/json?token={$apiKey}");

    // Create or open the file for appending
    $filename = "ip_info.txt";
    $file = fopen($filename, "a");

    // Append data along with the current date
    $dataToAppend = date("Y-m-d H:i:s") . " - IP: {$ip} - " . $jsonData . "\n";
    fwrite($file, $dataToAppend);

    // Close the file
    fclose($file);

    echo "Data appended to file.";
}
?>

<script>
const getPublicIP = async () => {
  try {
    const response = await fetch("https://api64.ipify.org?format=json");
    const data = await response.json();
    return data.ip;
  } catch (error) {
    console.error("Error getting public IP:", error);
    return null;
  }
};

getPublicIP().then((ip) => {
  if (ip) {
    console.log("Your public IP address:", ip);

    fetch("<?php echo $_SERVER['PHP_SELF']; ?>?ip=" + ip)
      .then((response) => response.text())
      .then((result) => console.log(result))
      .catch((error) => console.error("Error sending IP to server:", error));
  } else {
    console.log("Failed to retrieve public IP.");
  }
});
</script>
