<?php
// Konfigurasi API NewsAPI.org menggunakan API Key Anda
$apiKey = 'b4de1020c4f444bc93acf79ad137dc96'; 
$url = 'https://newsapi.org/v2/top-headlines?country=us&apiKey=' . $apiKey;

// Inisialisasi cURL
$ch = curl_init();

// Set opsi cURL
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
// NewsAPI memerlukan header User-Agent agar request tidak ditolak
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: PHP-REST-Client-App'
]);
// Opsional untuk pengembangan lokal jika ada kendala sertifikat SSL
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

// Eksekusi cURL
$response = curl_exec($ch);
$err = curl_error($ch);
curl_close($ch);

$articles = [];
if (!$err) {
    $data = json_decode($response, true);
    if (isset($data['articles'])) {
        $articles = $data['articles'];
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>REST Client cURL - NewsAPI</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container my-5">
        <div class="text-center mb-4">
            <h1 class="fw-bold">PHP cURL REST Client</h1>
            <p class="text-muted">Prakgit init
git add .
git commit -m "feat: initial commit php curl rest client for newsapi"
git branch -M main
git remote add origin https://github.com/davinamaya67-coder/rest-client-news.git
git push -u origin maintikum System Test - Konsumsi Public API (NewsAPI.org)</p>
        </div>

        <?php if ($err): ?>
            <div class="alert alert-danger" role="alert">
                <strong>cURL Error:</strong> <?php echo htmlspecialchars($err); ?>
            </div>
        <?php elseif (empty($articles)): ?>
            <div class="alert alert-warning" role="alert">
                Gagal memuat data. Periksa kembali koneksi internet Anda atau batasan kuota akses NewsAPI.
            </div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($articles as $article): ?>
                    <div class="col">
                        <div class="card h-100 shadow-sm">
                            <?php if (!empty($article['urlToImage'])): ?>
                                <img src="<?php echo htmlspecialchars($article['urlToImage']); ?>" class="card-img-top" alt="News Image" style="height: 200px; object-fit: cover;">
                            <?php else: ?>
                                <div class="bg-secondary text-white d-flex align-items-center justify-content-center" style="height: 200px;">
                                    <span>No Image Available</span>
                                </div>
                            <?php endif; ?>
                            <div class="card-body d-flex flex-column">
                                <span class="badge bg-primary mb-2 align-self-start"><?php echo htmlspecialchars($article['source']['name'] ?? 'Unknown'); ?></span>
                                <h5 class="card-title fs-6 fw-bold"><?php echo htmlspecialchars($article['title']); ?></h5>
                                <p class="card-text small text-secondary flex-grow-1"><?php echo htmlspecialchars($article['description'] ?? 'Tidak ada deskripsi singkat.'); ?></p>
                                <a href="<?php echo htmlspecialchars($article['url']); ?>" target="_blank" class="btn btn-outline-primary btn-sm mt-auto">Baca Selengkapnya</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>