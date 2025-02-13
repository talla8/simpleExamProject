<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="Keywords" content="student,exam,questions">
    <title>Exam Form</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
		 background-image: url("../htdocs/pic5.jpg"); 	/*//fixx this */
            background-attachment: fixed;
            background-size: cover;
            background-repeat: no-repeat;
            background-position:center;
            height: 100vh;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 8px;
			backdrop-filter:blur(30px);
			box-shadow: 0 0 20px black;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
        }
		p {
		font-weight: bold;
		}
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        .questions {
            margin-top: 20px;
        }
        .question {
            margin-bottom: 15px;
        }
        .btn-submit {
            display: block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
        }
        .btn-submit:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "student"; 

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = isset($_POST['studentName']) ? $_POST['studentName'] : '';
$id = isset($_POST['studentId']) ? $_POST['studentId'] : '';
$section = isset($_POST['section']) ? $_POST['section'] : '';
$question1 = isset($_POST['question1']) ? $_POST['question1'] : '';
$question2 = isset($_POST['question2']) ? $_POST['question2'] : '';
$question3 = isset($_POST['question3']) ? $_POST['question3'] : '';
$question4 = isset($_POST['question4']) ? $_POST['question4'] : '';
$question5 = isset($_POST['question5']) ? $_POST['question5'] : '';

$mark = 0;

if (!empty($name) && !empty($id) && !empty($section) && !empty($question1) && !empty($question2) && !empty($question3) && !empty($question4) && !empty($question5)) {

    $questions = [
        136 => $question1,  
        137 => $question2,
        138 => $question3,
        139 => $question4,
        140 => $question5
    ];

    foreach ($questions as $questionId => $answer) {
        $sql = "SELECT rightAnswer FROM examquestions WHERE id = '$questionId'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $correctAnswer = $row['rightAnswer'];

            if (trim($correctAnswer) == trim($answer)) {
                $mark++;
            }
        } else {
            echo "No correct answer found for question ID $questionId.<br>";
        }
    }

    $stmt = $conn->prepare("UPDATE studentlist SET mark = ? WHERE ID = ?");
    $stmt->bind_param("ii", $mark, $id);
    $stmt->execute();
            }

          header("Location: thanks.html");
            exit();


 $conn->close();
// 
// 

?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Exam Form</title>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>Student Exam Form</h2>
        </div>
        <form action="exam2.php" method="POST">
            
            <div class="form-group">
                <label for="studentName"><b>Name:</b></label>
                <input type="text" id="studentName" name="studentName" value="" required>
            </div>
            <div class="form-group">
                <label for="studentId"><b>Student ID:</b></label>
                <input type="text" id="studentId" name="studentId" value="" required>
            </div>
            <div class="form-group">
                <label for="section"><b>Section:</b></label>
                <select id="section" name="section" required>
                    <option value="">Select your section</option>
                    <option value="11">#1</option>
                    <option value="22">#2</option>
                    <option value="33">#3</option>
                    <option value="44">#4</option>
                </select>
            </div>
            
            
            <div class="questions">
                <div class="question">
                    <p>1. Which programming language is primarily used for web development along with HTML and CSS?</p>
                    <label>
                        <input type="radio" name="question1" value="python2" required> Python
                    </label><br>
                    <label>
                        <input type="radio" name="question1" value="JavaScript"> JavaScript
                    </label><br>
                    <label>
                        <input type="radio" name="question1" value="ruby"> Ruby
                    </label>
                </div>
                <div class="question">
                    <p>2. What does "HTTP" stand for?</p>
                    <label>
                        <input type="radio" name="question2" value="HyperText Transfer Protocol" required> HyperText Transfer Protocol
                    </label><br>
                    <label>
                        <input type="radio" name="question2" value="High-Tech Transfer Protocol"> High-Tech Transfer Protocol
                    </label><br>
                    <label>
                        <input type="radio" name="question2" value="High-Tech Transmission Protocol"> HyperText Transmission Path
                    </label>
                </div>
                <div class="question">
                    <p>3. Which of the following is NOT a type of database?</p>
                    <label>
                        <input type="radio" name="question3" value="Relational Databases" required> Relational Databases
                    </label><br>
                    <label>
                        <input type="radio" name="question3" value="Object-oriented Databases"> Object-oriented Databases
                    </label><br>
                    <label>
                        <input type="radio" name="question3" value="Sql Databases"> Sql Databases
                    </label>
                </div>
                <div class="question">
                    <p>4. What is the primary function of a firewall in computer networks?</p>
                    <label>
                        <input type="radio" name="question4" value="Monitor and control incoming and outgoing network traffic" required> Monitor and control incoming and outgoing network traffic
                    </label><br>
                    <label>
                        <input type="radio" name="question4" value="Boost internet speed"> Boost internet speed
                    </label><br>
                    <label>
                        <input type="radio" name="question4" value="Manage software updates"> Manage software updates
                    </label>
                </div>
                <div class="question">
                    <p>5. What is the term for harmful software designed to damage, disrupt, or gain unauthorized access to a system?</p>
                    <label>
                        <input type="radio" name="question5" value="Virus" required> Virus
                    </label><br>
                    <label>
                        <input type="radio" name="question5" value="Malware"> Malware
                    </label><br>
                    <label>
                        <input type="radio" name="question5" value="Trojan Horse"> Trojan Horse
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn-submit">Submit Exam</button>
        </form>
    </div>
</body>
</html>
