
<?php
/*
Practical 2

Aim:
Create a PHP program to perform Create (Insert), Read
(Display), Update, and Delete (CRUD) operations on student
records in a MySQL database using PDO Prepared Statements.
Execute SQL queries securely and display appropriate
success or failure messages for each database operation.

Database Creation Steps:
1. XAMPP open karo.
2. Apache aur MySQL start karo.
3. Browser mein localhost/phpmyadmin open karo.
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

Program:
*/

try {
    $conn = new PDO("mysql:host=localhost;dbname=lv", "root", "");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    $stmt = $conn->prepare(
        "INSERT INTO student (name, email) VALUES (:name, :email)"
    );
    $stmt->execute([
        ':name' => 'Rushi',
        ':email' => 'rushi@gmail.com'
    ]);

    if ($stmt->rowCount() > 0) {
        echo "Record inserted successfully!<br>";
    } else {
        echo "Record insertion failed!<br>";
    }

    $stmt = $conn->prepare("SELECT * FROM student");
    $stmt->execute();

    echo "Student Records:<br>";

    while ($row = $stmt->fetch()) {
        echo $row['id'] . " - "
           . htmlspecialchars($row['name']) . " - "
           . htmlspecialchars($row['email']) . "<br>";
    }

    $stmt = $conn->prepare(
        "UPDATE student SET name = :name WHERE id = :id"
    );
    $stmt->execute([
        ':name' => 'Rushi Patel',
        ':id' => 1
    ]);

    if ($stmt->rowCount() > 0) {
        echo "Record updated successfully!<br>";
    } else {
        echo "No record updated!<br>";
    }

    $stmt = $conn->prepare("DELETE FROM student WHERE id = :id");
    $stmt->execute([':id' => 1]);

    if ($stmt->rowCount() > 0) {
        echo "Record deleted successfully!<br>";
    } else {
        echo "No record deleted!<br>";
    }
}
catch (PDOException $e) {
    echo "Database operation failed: " . $e->getMessage();
}

/*
Expected Output:

Record inserted successfully!
Student Records:
1 - Rushi - rushi@gmail.com
Record updated successfully!
Record deleted successfully!

Note:
Output mein ID aur records database ke actual data par
depend karte hain. UPDATE aur DELETE ke liye yahan ID 1
use ki gayi hai. Agar ID 1 available nahi hai, toh apne
record ki actual ID use karo.

Viva Explanation:

1. CRUD:
   Create, Read, Update aur Delete operations ko CRUD kehte hain.

2. PDO:
   PHP aur MySQL database ke beech connection banata hai.

3. Prepared Statements:
   SQL queries mein parameters securely pass karne mein
   help karte hain.

4. prepare():
   SQL query ko prepare karta hai.

5. execute():
   Prepared query ko execute karta hai.

6. fetch():
   Ek time par ek record retrieve karta hai.

7. rowCount():
   INSERT, UPDATE aur DELETE se affect hue rows ki
   sankhya batata hai.

8. htmlspecialchars():
   Display karte waqt HTML special characters ko
   encode karta hai.

9. try-catch:
   Database exceptions ko handle karta hai.

Viva Questions:

Q1. CRUD ka full form kya hai?
Ans: Create, Read, Update and Delete.

Q2. Prepared Statements kyu use karte hain?
Ans: SQL Injection ka risk kam karne ke liye.

Q3. prepare() kya karta hai?
Ans: SQL query prepare karta hai.

Q4. execute() kya karta hai?
Ans: Prepared query execute karta hai.

Q5. fetch() aur fetchAll() mein kya difference hai?
Ans: fetch() ek record deta hai, fetchAll() saare
records ko array mein return karta hai.

Q6. SQL Injection kya hai?
Ans: Malicious SQL input ke through query ko manipulate
karne ka attack hai.

Q7. rowCount() kya karta hai?
Ans: Affected rows ki count return karta hai.
*/
?>
