
<?php
/*
Practical 3

Aim:
Create a PHP program to retrieve student records from a
MySQL database using PDO Prepared Statements. Implement
parameter binding using bindParam() and bindValue() to
securely bind values to SQL queries. Retrieve records using
fetch() and fetchAll() methods, and implement exception
handling using PDOException to handle database connection
and query execution errors.

Database Creation Steps:
1. XAMPP open karo.
2. Apache aur MySQL start karo.
3. localhost/phpmyadmin open karo.
4. lv database select karo.
5. SQL tab mein neeche diye gaye commands run karo.

SQL Commands:

CREATE DATABASE lv;

USE lv;

CREATE TABLE student (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100),
    email VARCHAR(100)
);

INSERT INTO student (name, email)
VALUES ('Rushi', 'rushi@gmail.com'),
       ('Rahul', 'rahul@gmail.com');

Program:
*/

try {
    $conn = new PDO("mysql:host=localhost;dbname=lv", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $id = 1;

    $stmt = $conn->prepare("SELECT * FROM student WHERE id = :id");
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();

    echo "Using fetch():<br>";

    $row = $stmt->fetch();

    if ($row) {
        echo $row['id'] . " - "
           . htmlspecialchars($row['name']) . " - "
           . htmlspecialchars($row['email']) . "<br>";
    } else {
        echo "Student record not found.<br>";
    }

    $email = 'rahul@gmail.com';

    $stmt = $conn->prepare("SELECT * FROM student WHERE email = :email");
    $stmt->bindValue(':email', $email, PDO::PARAM_STR);
    $stmt->execute();

    echo "<br>Using fetchAll():<br>";

    $rows = $stmt->fetchAll();

    if ($rows) {
        foreach ($rows as $row) {
            echo $row['id'] . " - "
               . htmlspecialchars($row['name']) . " - "
               . htmlspecialchars($row['email']) . "<br>";
        }
    } else {
        echo "No student records found.<br>";
    }
}
catch (PDOException $e) {
    echo "Database error: " . $e->getMessage();
}

/*
Expected Output:

Using fetch():
1 - Rushi - rushi@gmail.com

Using fetchAll():
2 - Rahul - rahul@gmail.com

Viva Explanation:

1. PDO:
   PHP ko MySQL database se connect karta hai.

2. Prepared Statement:
   Query mein values ko securely bind karne mein help karta hai.

3. bindParam():
   Variable ko parameter ke saath reference ke through bind karta hai.

4. bindValue():
   Parameter ke saath current value bind karta hai.

5. fetch():
   Ek record retrieve karta hai.

6. fetchAll():
   Query ke saare matching records retrieve karta hai.

7. PDOException:
   Database connection aur query errors ko handle karne
   ke liye use hota hai.

8. PDO::PARAM_INT:
   Parameter ko integer type specify karta hai.

9. PDO::PARAM_STR:
   Parameter ko string type specify karta hai.

Viva Questions:

Q1. bindParam() aur bindValue() mein kya difference hai?
Ans: bindParam() variable ko reference se bind karta hai,
jabki bindValue() uski current value bind karta hai.

Q2. fetch() kya karta hai?
Ans: Ek record retrieve karta hai.

Q3. fetchAll() kya karta hai?
Ans: Saare matching records array mein return karta hai.

Q4. Prepared Statements kyu use karte hain?
Ans: SQL Injection ka risk kam karne ke liye.

Q5. PDOException kya hai?
Ans: PDO database errors ko represent karne wali exception hai.

Q6. try-catch ka kya use hai?
Ans: Exception ko catch karke error handle karta hai.
*/
?>
