
<?php
/*
Practical 9

Aim:
Develop a PHP-based web application to implement Cross-Site
Request Forgery (CSRF) protection using a CSRF token. Generate
and store a unique token in the user's session, include the
token in an HTML form, and verify the submitted token before
processing the request. Display appropriate messages for valid
and invalid CSRF token verification.

Steps:
1. XAMPP open karo aur Apache start karo.
2. File ko practical9.php naam se htdocs folder mein save karo.
3. Browser mein localhost/practical9.php open karo.

Database:
Is practical mein database ki zaroorat nahi hai.

Program:
*/

session_start();

if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['csrf_token'] ?? "";

    if (is_string($token) &&
        hash_equals($_SESSION['csrf_token'], $token)) {

        $message = "Valid CSRF token! Request processed successfully.";

        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    } else {
        $message = "Invalid CSRF token! Request rejected.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>CSRF Protection</title>
</head>
<body>

<h2>CSRF Protection Form</h2>

<p><?php echo htmlspecialchars($message, ENT_QUOTES, 'UTF-8'); ?></p>

<form method="post" action="">
    <label>Enter Message:</label>
    <input type="text" name="user_message" required>
    <input type="hidden" name="csrf_token"
           value="<?php echo htmlspecialchars($_SESSION['csrf_token'], ENT_QUOTES, 'UTF-8'); ?>">
    <br><br>

    <input type="submit" value="Submit">
</form>

</body>
</html>

<?php
/*
Expected Output:

CSRF Protection Form

Enter Message: [____________]
              [Submit]

Valid token:
Valid CSRF token! Request processed successfully.

Invalid token:
Invalid CSRF token! Request rejected.

Viva Explanation:

1. CSRF:
   Cross-Site Request Forgery ek attack hai jisme user ke
   authenticated browser se unwanted request karwayi jaati hai.

2. session_start():
   PHP session ko start ya resume karta hai.

3. random_bytes(32):
   Secure random bytes generate karta hai.

4. bin2hex():
   Random bytes ko hexadecimal string mein convert karta hai.

5. $_SESSION:
   CSRF token ko session mein store karta hai.

6. Hidden Input:
   Form ke saath token submit karta hai.

7. hash_equals():
   Token ko safely compare karta hai.

8. Token Verification:
   Request process karne se pehle submitted token check karta hai.

Viva Questions:

Q1. CSRF ka full form kya hai?
Ans: Cross-Site Request Forgery.

Q2. CSRF token kya hai?
Ans: Ek unique random value jo request ki validity verify
karne ke liye use hoti hai.

Q3. Token session mein kyu store karte hain?
Ans: Server par original token maintain karne ke liye.

Q4. Hidden input ka kya use hai?
Ans: Token ko form ke saath submit karne ke liye.

Q5. hash_equals() kya karta hai?
Ans: Do strings ko timing-safe tareeke se compare karta hai.

Q6. Invalid token par kya karna chahiye?
Ans: Request reject kar deni chahiye.

Q7. Kya CSRF token aur password same hote hain?
Ans: Nahi, CSRF token request verification ke liye hota hai.

Note:
Yeh practical token generation aur verification demonstrate
karta hai. Real application mein sensitive action ko sirf
valid token verify hone ke baad hi perform karna chahiye.
*/
?>
