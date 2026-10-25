
<?php
/*
Practical 6

Aim:
Develop a PHP-based login application to demonstrate a SQL
Injection vulnerability and prevent it using PDO Prepared
Statements. The practical involves creating a login form,
executing a vulnerable SQL query using user input, demonstrating
how malicious input can manipulate the query, and then securing
the application using prepare(), parameter binding, and execute()
to ensure that user input is treated as data rather than SQL code.

Database Creation Steps:
1. XAMPP open karo.
2. Apache aur MySQL start karo.
3. localhost/phpmyadmin open karo.
4. SQL tab mein neeche diye gaye commands run karo.

SQL Commands:

CREATE DATABASE lv;

USE lv;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50),
    password VARCHAR(100)
);

INSERT INTO users (username, password)
VALUES ('student', '12345');

Program:
*/

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $conn = new PDO("mysql:host=localhost;dbname=lv", "root", "");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        $username = $_POST['username'];
        $password = $_POST['password'];

        if (isset($_POST['mode']) && $_POST['mode'] == 'vulnerable') {
            $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
            $stmt = $conn->query($sql);
        } else {
            $sql = "SELECT * FROM users WHERE username = :username AND password = :password";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':username', $username, PDO::PARAM_STR);
            $stmt->bindParam(':password', $password, PDO::PARAM_STR);
            $stmt->execute();
        }

        if ($stmt->fetch()) {
            $message = "Login successful!";
        } else {
            $message = "Invalid username or password!";
        }
    }
    catch (PDOException $e) {
        $message = "Database error occurred.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>SQL Injection Demonstration</title>
</head>
<body>

<h2>Login Application</h2>

<p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>

<form method="post" action="">
    <label>Username:</label>
    <input type="text" name="username" required>
    <br><br>

    <label>Password:</label>
    <input type="password" name="password" required>
    <br><br>

    <label>Mode:</label>
    <select name="mode">
        <option value="secure">Secure PDO</option>
        <option value="vulnerable">Vulnerable Demo</option>
    </select>
    <br><br>

    <input type="submit" value="Login">
</form>

</body>
</html>

<?php
/*
Expected Output:

Login Application

Username: [________]
Password: [________]
Mode: Secure PDO / Vulnerable Demo

Valid test login:
Username: student
Password: 12345

Output:
Login successful!

Incorrect credentials:
Invalid username or password!

SQL Injection Demonstration:
Sir ke supervision mein sirf local test database use karo.
Vulnerable mode mein username field mein yeh input try karo:

' OR '1'='1' --

MySQL ke kuch configurations mein yeh input vulnerable
query ki condition manipulate kar sakta hai. Secure PDO mode
mein input data ke roop mein treat hota hai, SQL code nahi.

Viva Explanation:

1. SQL Injection:
   User input ke through SQL query manipulate karne ka attack hai.

2. Vulnerable Query:
   User input ko directly SQL string mein add karti hai.

3. prepare():
   SQL statement ko prepare karta hai.

4. bindParam():
   Variable ko query parameter ke saath bind karta hai.

5. execute():
   Prepared statement execute karta hai.

6. PDO Prepared Statements:
   User input ko SQL code se alag rakhte hain aur SQL Injection
   ka risk kam karte hain.

7. $_POST:
   Login form se username aur password receive karta hai.

8. try-catch:
   Database exceptions ko handle karta hai.

Viva Questions:

Q1. SQL Injection kya hai?
Ans: User input se SQL query manipulate karne ka attack hai.

Q2. SQL Injection ka main cause kya hai?
Ans: User input ko directly SQL query mein jodna.

Q3. prepare() ka use kya hai?
Ans: SQL statement prepare karne ke liye.

Q4. bindParam() kya karta hai?
Ans: Variable ko SQL parameter ke saath bind karta hai.

Q5. execute() kya karta hai?
Ans: Prepared SQL statement execute karta hai.

Q6. SQL Injection ko kaise prevent karte hain?
Ans: PDO Prepared Statements aur parameter binding use karke.

Q7. Kya Prepared Statements password ko hash karte hain?
Ans: Nahi, Prepared Statements query ko secure karte hain.
Password hashing alag security technique hai.
*/
?>
