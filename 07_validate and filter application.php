
<?php
/*
Practical 7

Aim:
Develop a PHP program to validate and filter student
information submitted through an HTML form using appropriate
PHP validation and filtering techniques. Validate fields such
as name, email, and age, display suitable error messages for
invalid or missing input, and process the submitted data only
when all inputs are valid.

Steps:
1. XAMPP open karo.
2. Apache start karo.
3. File ko practical7.php naam se htdocs folder mein save karo.
4. Browser mein localhost/practical7.php open karo.

Database:
Is practical mein database ki zaroorat nahi hai.

Program:
*/

$name = "";
$email = "";
$age = "";
$errors = [];
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"] ?? "");
    $email = trim($_POST["email"] ?? "");
    $age = trim($_POST["age"] ?? "");

    if ($name == "") {
        $errors[] = "Name is required.";
    } elseif (!preg_match("/^[a-zA-Z ]+$/", $name)) {
        $errors[] = "Name must contain only letters and spaces.";
    }

    if ($email == "") {
        $errors[] = "Email is required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Enter a valid email address.";
    }

    if ($age == "") {
        $errors[] = "Age is required.";
    } elseif (filter_var($age, FILTER_VALIDATE_INT) === false
        || $age < 1 || $age > 120) {
        $errors[] = "Enter a valid age between 1 and 120.";
    }

    if (empty($errors)) {
        $success = "Student information submitted successfully!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Student Information Validation</title>
</head>
<body>

<h2>Student Information Form</h2>

<form method="post" action="">
    <label>Name:</label>
    <input type="text" name="name"
           value="<?php echo htmlspecialchars($name, ENT_QUOTES, 'UTF-8'); ?>">
    <br><br>

    <label>Email:</label>
    <input type="text" name="email"
           value="<?php echo htmlspecialchars($email, ENT_QUOTES, 'UTF-8'); ?>">
    <br><br>

    <label>Age:</label>
    <input type="number" name="age"
           value="<?php echo htmlspecialchars($age, ENT_QUOTES, 'UTF-8'); ?>">
    <br><br>

    <input type="submit" value="Submit">
</form>

<?php
if (!empty($errors)) {
    echo "<h3>Errors:</h3>";
    foreach ($errors as $error) {
        echo htmlspecialchars($error, ENT_QUOTES, 'UTF-8') . "<br>";
    }
}

if ($success != "") {
    echo "<h3>" . htmlspecialchars($success, ENT_QUOTES, 'UTF-8') . "</h3>";
    echo "Name: " . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . "<br>";
    echo "Email: " . htmlspecialchars($email, ENT_QUOTES, 'UTF-8') . "<br>";
    echo "Age: " . htmlspecialchars($age, ENT_QUOTES, 'UTF-8');
}
?>

</body>
</html>

<?php
/*
Expected Output:

Student Information Form
Name:  [____________]
Email: [____________]
Age:   [____________]
       [Submit]

Valid data:
Name: Rushi
Email: rushi@gmail.com
Age: 20

Output:
Student information submitted successfully!
Name: Rushi
Email: rushi@gmail.com
Age: 20

Invalid data par suitable error messages display honge.

Viva Explanation:

1. trim():
   Input ke starting aur ending spaces remove karta hai.

2. filter_var():
   Email aur age jaise input ko validate karne mein help karta hai.

3. FILTER_VALIDATE_EMAIL:
   Email format check karta hai.

4. FILTER_VALIDATE_INT:
   Check karta hai ki age valid integer hai ya nahi.

5. preg_match():
   Name mein sirf letters aur spaces allow karta hai.

6. empty():
   Check karta hai ki errors array empty hai ya nahi.

7. htmlspecialchars():
   Output mein HTML special characters encode karta hai.

8. $_POST:
   Form se submitted data receive karta hai.

Viva Questions:

Q1. Validation kya hai?
Ans: User input ko rules ke according check karna.

Q2. Filtering kya hai?
Ans: Input ko check ya filter karne ke liye PHP functions
use karna.

Q3. filter_var() ka use kya hai?
Ans: Data validate ya filter karne ke liye.

Q4. FILTER_VALIDATE_EMAIL kya karta hai?
Ans: Email address ka format validate karta hai.

Q5. trim() kya karta hai?
Ans: Starting aur ending whitespace remove karta hai.

Q6. Data kab process hota hai?
Ans: Jab name, email aur age sab valid hote hain.
*/
?>
