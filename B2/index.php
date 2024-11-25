<?php
// Đọc nội dung từ file Quiz.txt
$filename = "Quiz.txt";
if (file_exists($filename)) {
    $questions = file($filename, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
} else {
    die("Không tìm thấy file Quiz.txt");
}

// Xử lý dữ liệu để lấy câu hỏi và đáp án
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
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài thi trắc nghiệm</title>
</head>
<body>
    <h1>Bài thi trắc nghiệm</h1>
    <form method="POST" action="result.php">
        <?php foreach ($quiz as $index => $q): ?>
            <div>
                <p><strong>Câu <?= $index + 1 ?>: <?= $q['question'] ?></strong></p>
                <?php foreach ($q['options'] as $key => $option): ?>
                    <label>
                        <input type="radio" name="question_<?= $index ?>" value="<?= chr(65 + $key) ?>">
                        <?= $option ?>
                    </label><br>
                <?php endforeach; ?>
            </div>
            <br>
        <?php endforeach; ?>
        <button type="submit">Nộp bài</button>
    </form>
</body>
</html>
