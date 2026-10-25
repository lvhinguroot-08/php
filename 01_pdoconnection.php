
<?php
/*
Practical 1

Aim:
Create a PHP program to establish a secure connection
with a MySQL database using PDO. Configure the connection
by enabling exception-based error handling, setting the
default fetch mode, and disabling emulated prepared
statements. Display an appropriate message indicating
whether the connection was established successfully.

Database Creation Steps:
1. XAMPP open karo.
2. Apache aur MySQL start karo.
3. Browser mein localhost/phpmyadmin open karo.
4. New par click karke lv naam ka database banao.

SQL Command:
CREATE DATABASE lv;

Program:
*/

$dsn = "mysql:host=localhost;dbname=lv";
$username = "root";
$password = "";

try {
    $conn = new PDO($dsn, $username, $password);

    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

    echo "Database connected successfully!";
}
catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

/*
Output:
Database connected successfully!

Viva Explanation:

1. PDO:
   PHP ko MySQL database se connect karta hai.

2. DSN:
   Database host aur database name specify karta hai.

3. PDO::ERRMODE_EXCEPTION:
   Database error hone par exception generate karta hai.

4. PDO::FETCH_ASSOC:
   Data ko associative array mein fetch karta hai.

5. PDO::ATTR_EMULATE_PREPARES:
   Emulated prepared statements ko control karta hai.

6. try-catch:
   Database errors ko handle karta hai.

Viva Questions:

Q1. PDO ka full form kya hai?
Ans: PHP Data Objects.

Q2. PDO ka use kya hai?
Ans: PHP aur database ke beech connection banane ke liye.

Q3. try-catch kya karta hai?
Ans: Exceptions ko handle karta hai.

Q4. FETCH_ASSOC kya karta hai?
Ans: Column names ke through data access karne deta hai.

Q5. Connection fail hone par kya hoga?
Ans: Catch block error message display karega.

Q6. Kya table banana zaroori hai?
Ans: Nahi, is practical mein sirf database connection chahiye.
*/
?>
