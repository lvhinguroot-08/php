
<?php
/*
Practical 4

Aim:
Develop a Student Registration System using HTML, PHP,
MySQL, and PDO. Design an HTML form to collect student
information, establish a secure database connection, and
store the submitted data in a MySQL database using PDO
Prepared Statements with parameter binding. Display
appropriate success or failure messages after form submission.

Database Creation Steps:
1. XAMPP open karo.
2. Apache aur MySQL start karo.
3. localhost/phpmyadmin open karo.
4. SQL tab mein neeche diye gaye commands run karo.

SQL Commands:

CREATE DATABASE lv;

USE lv;

CREATE TABLE student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
);

Program:
*/

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=lv", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $name = trim($_POST['name']);
        $email = trim($_POST['email']);

        $stmt = $conn->prepare(
            "INSERT INTO student (name, email) VALUES (:name, :email)"
        );

        $stmt->bindParam(':name', $name, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        $message = "Student registered successfully!";
    }
    catch (PDOException $e) {
        $message = "Registration failed: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Registration</title>
</head>
<body>

<h2>Student Registration Form</h2>

<p><?php echo htmlspecialchars($message); ?></p>

<form method="post" action="">
    <label>Name:</label>
    <input type="text" name="name" required>
    <br><br>

    <label>Email:</label>
    <input type="email" name="email" required>
    <br><br>

    <input type="submit" value="Register">
</form>

</body>
</html>

<?php
/*
Expected Output:

Student Registration Form

Name:  [____________]
Email: [____________]

        [Register]

Form submit karne ke baad:
Student registered successfully!

Viva Explanation:

1. HTML Form:
   Student ka name aur email collect karta hai.

2. POST Method:
   Form ka data server ko send karta hai.

3. PDO:
   PHP ko MySQL database se connect karta hai.

4. Prepared Statement:
   SQL query mein parameters securely pass karta hai.

5. bindParam():
   PHP variables ko query parameters ke saath bind karta hai.

6. execute():
   Prepared SQL query execute karta hai.

7. try-catch:
   Database errors ko handle karta hai.

8. htmlspecialchars():
   Message display karte waqt HTML special characters
   ko encode karta hai.

Viva Questions:

Q1. Student Registration System kya karta hai?
Ans: Student details collect karke database mein store karta hai.

Q2. POST method kyu use kiya hai?
Ans: Form data ko server par submit karne ke liye.

Q3. Prepared Statements kyu use karte hain?
Ans: SQL Injection ka risk kam karne ke liye.

Q4. bindParam() kya karta hai?
Ans: Variable ko SQL parameter ke saath bind karta hai.

Q5. required attribute ka kya use hai?
Ans: Form field ko empty submit hone se rokta hai.

Q6. PDOException kya hai?
Ans: PDO database errors ko represent karne wali exception hai.
*/
?>
