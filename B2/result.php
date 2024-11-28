<?php
// Đọc nội dung từ file Quiz.txt để lấy dữ liệu
$filename = "Quiz.txt";
if (file_exists($filename)) {
    $questions = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
    die("Không tìm thấy file Quiz.txt");
}

// Xử lý dữ liệu từ file để lấy danh sách câu hỏi và đáp án
$quiz = [];
$currentQuestion = null;
foreach ($questions as $line) {
    if (stripos($line, "Đáp án:") !== false) {
        // Gán đáp án cho câu hỏi hiện tại
        if ($currentQuestion) {
            $currentQuestion['answer'] = trim(str_replace("Đáp án:", "", $line));
            $quiz[] = $currentQuestion;
            $currentQuestion = null; // Reset câu hỏi hiện tại
        }
    } elseif (stripos($line, "Câu") === 0) {
        // Khởi tạo một câu hỏi mới
        $currentQuestion = [
            'question' => trim(substr($line, strpos($line, ":") + 1)),
            'options' => []
        ];
    } elseif (preg_match('/^[A-D]\./', $line)) {
        // Thêm đáp án vào danh sách
        if ($currentQuestion) {
            $currentQuestion['options'][] = trim($line);
        }
    }
}

// Kiểm tra câu trả lời từ form
$score = 0;
$totalQuestions = count($quiz);
$userAnswers = [];

foreach ($quiz as $index => $q) {
    $correctAnswer = $q['answer']; // Đáp án đúng
    $userAnswer = isset($_POST["question_$index"]) ? $_POST["question_$index"] : null;

    // Lưu lại câu trả lời của người dùng
    $userAnswers[] = [
        'question' => $q['question'],
        'correctAnswer' => $correctAnswer,
        'userAnswer' => $userAnswer
    ];

    // So sánh câu trả lời đúng
    if ($userAnswer === $correctAnswer) {
        $score++;
    }
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết quả bài thi</title>
</head>
<body>
    <h1>Kết quả bài thi</h1>
    <p>Bạn đã trả lời đúng <strong><?= $score ?></strong> trên tổng số <strong><?= $totalQuestions ?></strong> câu hỏi.</p>
    
    <h2>Chi tiết kết quả</h2>
    <ul>
        <?php foreach ($userAnswers as $index => $result): ?>
            <li>
                <strong>Câu <?= $index + 1 ?>:</strong> <?= $result['question'] ?><br>
                <strong>Đáp án đúng:</strong> <?= $result['correctAnswer'] ?><br>
                <strong>Đáp án của bạn:</strong> <?= $result['userAnswer'] ?? 'Chưa trả lời' ?><br>
                <?= ($result['userAnswer'] === $result['correctAnswer']) ? '<span style="color:green;">Đúng</span>' : '<span style="color:red;">Sai</span>' ?>
            </li>
            <br>
        <?php endforeach; ?>
    </ul>

    <a href="index.php">Làm lại bài thi</a>
</body>
</html>
