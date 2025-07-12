<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');

// Kiểm tra tham số id
if (!isset($_GET['id']) || empty($_GET['id'])) {
    http_response_code(400);
    echo json_encode([
        'status' => 'error',
        'message' => 'Thiếu tham số id'
    ]);
    exit;
}

$videoId = $_GET['id'];

$curl = curl_init();

curl_setopt_array($curl, [
    CURLOPT_URL => "https://ytstream-download-youtube-videos.p.rapidapi.com/dl?id=" . urlencode($videoId),
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_HTTPHEADER => [
        "x-rapidapi-host: ytstream-download-youtube-videos.p.rapidapi.com",
        "x-rapidapi-key: a80883df5emsh89a19b89292d1a9p143054jsn24808699ea5d"
    ],
]);

$response = curl_exec($curl);
$err = curl_error($curl);
curl_close($curl);

// Xử lý phản hồi
if ($err) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Lỗi khi kết nối API: ' . $err
    ]);
} else {
    // Trả về kết quả gốc từ API
    echo $response;
}
?>
