
<?php
/*
Practical 8

Aim:
Develop a PHP-based secure login system using session
management. Authenticate the user using valid credentials,
create a session after successful login, regenerate the
session ID for security, restrict unauthorized access to
protected pages using session validation, and properly
destroy the session during logout. Display appropriate
messages for successful login, invalid credentials,
unauthorized access, and logout.

Steps:
1. XAMPP open karo aur Apache start karo.
2. File ko practical8.php naam se htdocs folder mein save karo.
3. Browser mein localhost/practical8.php open karo.
4. Test credentials:
   Username: student
   Password: 12345

Database:
Is basic practical mein database ki zaroorat nahi hai.
Credentials demonstration ke liye code mein diye gaye hain.

Program:
*/

session_start();

$message = "";

if (isset($_GET['logout'])) {
    if (isset($_SESSION['username'])) {
        $_SESSION = [];
        session_destroy();
        $message = "Logout successful!";
    } else {
        $message = "You are not logged in.";
    }
}

if (isset($_GET['page']) && $_GET['page'] == 'protected') {
    if (isset($_SESSION['username'])) {
        echo "<h2>Protected Page</h2>";
        echo "Welcome, " .
             htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
        echo "<br><a href='?logout=1'>Logout</a>";
    } else {
        echo "Unauthorized access! Please login first.";
    }
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? "";
    $password = $_POST['password'] ?? "";

    if ($username === "student" && $password === "12345") {
        session_regenerate_id(true);
        $_SESSION['username'] = $username;
        $message = "Login successful!";
    } else {
        $message = "Invalid username or password!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Secure Login System</title>
</head>
<body>

<h2>Login Form</h2>

<p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>

<?php if (isset($_SESSION['username'])) { ?>

    <p>Welcome, <?php echo htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8'); ?>!</p>
    <a href="?page=protected">Open Protected Page</a>
    <br><br>
    <a href="?logout=1">Logout</a>

<?php } else { ?>

    <form method="post" action="">
        <label>Username:</label>
        <input type="text" name="username" required>
        <br><br>

        <label>Password:</label>
        <input type="password" name="password" required>
        <br><br>

        <input type="submit" value="Login">
    </form>

<?php } ?>

</body>
</html>

<?php
/*
Expected Output:

Username: student
Password: 12345

Login successful!
Welcome, student!

Protected Page:
Welcome, student

Invalid credentials:
Invalid username or password!

Unauthorized access:
Unauthorized access! Please login first.

Logout:
Logout successful!

Viva Explanation:

1. session_start():
   PHP session ko start ya resume karta hai.

2. $_SESSION:
   User ka session data store aur access karta hai.

3. session_regenerate_id(true):
   Login successful hone par naya session ID banata hai
   aur purane session ID ko delete karta hai.

4. Authentication:
   Username aur password ko verify karna.

5. Protected Page:
   Sirf logged-in user ko access dena.

6. session_destroy():
   Current session ko destroy karta hai.

7. $_GET:
   URL se page aur logout jaise parameters read karta hai.

8. htmlspecialchars():
   Output mein special HTML characters encode karta hai.

Viva Questions:

Q1. Session kya hai?
Ans: Session server par user ka data maintain karta hai.

Q2. session_start() ka use kya hai?
Ans: Session create ya resume karne ke liye.

Q3. Session ID regenerate kyu karte hain?
Ans: Session fixation ka risk kam karne ke liye.

Q4. Protected page kya hai?
Ans: Aisa page jise access karne ke liye login zaroori hai.

Q5. session_destroy() kya karta hai?
Ans: Current session data ko server par destroy karta hai.

Q6. Authentication kya hai?
Ans: User ki identity verify karna.

Q7. Unauthorized access kya hai?
Ans: Bina valid login ke restricted page access karna.

Note:
Yeh practical session management demonstrate karta hai.
Real application mein credentials ko secure database se
verify karna aur passwords ko password_hash() aur
password_verify() ke saath handle karna chahiye.
*/
?>
