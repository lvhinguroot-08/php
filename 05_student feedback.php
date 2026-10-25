
<?php
/*
Practical 5

Aim:
Develop a PHP-based Student Feedback System that accepts
student name and feedback through an HTML form and displays
the submitted data securely. The practical demonstrates how
directly displaying untrusted user input can lead to Cross-Site
Scripting (XSS) and implements output encoding using PHP's
htmlspecialchars() function to prevent the browser from
interpreting user-supplied HTML or script content as executable
code.

Database Creation Steps:
Is practical mein database ki zaroorat nahi hai, kyunki
feedback form ka data sirf screen par display karna hai.

Program:
*/

$name = "";
$feedback = "";
$submitted = false;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'] ?? "";
    $feedback = $_POST['feedback'] ?? "";
    $submitted = true;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Feedback System</title>
</head>
<body>

<h2>Student Feedback Form</h2>

<form method="post" action="">
    <label>Student Name:</label>
    <input type="text" name="name" required>
    <br><br>

    <label>Feedback:</label>
    <textarea name="feedback" required></textarea>
    <br><br>

    <input type="submit" value="Submit Feedback">
</form>

<?php
if ($submitted) {
    echo "<h3>Submitted Feedback</h3>";
    echo "Student Name: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br>";
    echo "Feedback: " . htmlspecialchars($feedback, ENT_QUOTES, 'UTF-8');
}
?>

</body>
</html>

<?php
/*
Expected Output:

Student Feedback Form

Student Name: [____________]

Feedback: [________________]

[Submit Feedback]

Submit karne ke baad:
Submitted Feedback
Student Name: Rushi
Feedback: Good teaching.

Viva Explanation:

1. HTML Form:
   Student ka name aur feedback collect karta hai.

2. POST Method:
   Form data PHP script ko send karta hai.

3. $_POST:
   Submitted form values access karta hai.

4. XSS:
   Cross-Site Scripting ek attack hai jisme untrusted input
   ke through browser mein malicious script execute ho sakti hai.

5. htmlspecialchars():
   HTML special characters ko encode karta hai, jisse
   user-supplied HTML ya script executable code nahi banti.

6. ENT_QUOTES:
   Single aur double quotes dono ko encode karta hai.

7. UTF-8:
   Character encoding specify karta hai.

Viva Questions:

Q1. XSS ka full form kya hai?
Ans: Cross-Site Scripting.

Q2. XSS kya hai?
Ans: Aisa attack jisme malicious script browser mein
execute ho sakti hai.

Q3. htmlspecialchars() ka use kya hai?
Ans: HTML special characters ko encode karke unsafe
input ko executable HTML/script banne se rokta hai.

Q4. $_POST kya hai?
Ans: Form se submit hua data access karne ke liye PHP
superglobal array hai.

Q5. ENT_QUOTES kya karta hai?
Ans: Single aur double quotes ko encode karta hai.

Q6. Kya is practical mein database chahiye?
Ans: Nahi, kyunki data sirf display kiya ja raha hai.
*/
?>
