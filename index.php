<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peta Kecamatan dan Layanan Kesehatan Banyumas</title>
    <link rel="stylesheet"
          href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <style>
        #map { height: 700px; width: 100%; }
        body { font-family: Arial, sans-serif; text-align: center; }
    </style>
</head>
<body>
    <h1>Peta Kecamatan dan Layanan Kesehatan Kabupaten Banyumas</h1>
    <a href="crud.php" target="_blank">
        <button>Data</button>
    </a>
    
    <div id="map"></div>

    <!-- Script untuk menambahkan peta -->
    <script>
        // Inisialisasi peta
        const map = L.map('map').setView([-7.450161992561026, 109.16218062235068], 11);

        // Tile layer menggunakan OpenStreetMap
        const tiles = L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(map);
    </script>

    <!-- Inklusi File JSON Kecamatan -->
    <script src="data/kecamatan.json"></script>
    <script>
        // Menambahkan polygon kecamatan dari data JSON
        L.geoJSON(kecamatan, {
            style: function (feature) {
                return { color: 'blue', weight: 2 };
            }
        }).addTo(map);
    </script>

    <!-- Script untuk menambahkan marker layanan kesehatan dari database -->
    <script>
        <?php
        include 'db_connection.php';
        $sql = "SELECT name, latitude, longitude FROM health_services";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "L.marker([" . $row["latitude"] . ", " . $row["longitude"] . "]).addTo(map)
                    .bindPopup('<b>" . addslashes($row["name"]) . "</b>');\n";
            }
        }
        $conn->close();
        ?>
    </script>
</body>
</html>
