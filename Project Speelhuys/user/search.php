<?php

include "../classes/connection.php";
$db = Database::start();

$keywords = $_GET['keywords'] ?? '';
$merk = $_GET['merk'] ?? '';
$thema = $_GET['thema'] ?? '';
$prijs = $_GET['prijs'] ?? '';
$leeftijd = $_GET['leeftijd'] ?? '';

$sql = "SELECT sets.*
FROM sets
JOIN brands ON sets.set_brand_id = brands.brand_id
LEFT JOIN themes on sets.set_theme_id = themes.theme_id
WHERE sets.set_name LIKE ?";

$search = "%" . $keywords . "%";

$params = [$search];
$types = "s";
if ($merk !== '') {
    $sql .= " AND brands.brand_name = ?";
    $params[] = $merk;
    $types .= "s";
}
if ($thema !== '') {
    $sql .= " AND themes.theme_name = ?";
    $params[] = $thema;
    $types .= "s";
}


if ($leeftijd === '0-3') {
    $sql .= " AND sets.set_age BETWEEN 0 AND 3";
    }
    if ($leeftijd === '4-6') {
    $sql .= " AND sets.set_age BETWEEN 4 AND 6";
}
if ($leeftijd === '7-9') {
    $sql .= " AND sets.set_age BETWEEN 7 AND 9";
    }
    if ($leeftijd === '10-12') {
        $sql .= " AND sets.set_age BETWEEN 10 AND 12";
        }
        if ($leeftijd === '13+') {
            $sql .= " AND sets.set_age >= 13";
            }
            
if ($prijs === 'laag') {
      $sql .= " ORDER BY sets.set_price ASC";
 }
 if ($prijs === 'hoog') {
    $sql .= " ORDER BY sets.set_price DESC";
 }

 $stmt = $db->prepare($sql);

$bindParams = [$types];

foreach ($params as $key => $value) {
    $bindParams[] = &$params[$key];
}

call_user_func_array([$stmt, 'bind_param'], $bindParams);

$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    echo $row['set_name'] . "<br>";
}