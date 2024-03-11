<?php
session_start();
include "db.php";

/**
 * Chat Class
 *
 * The Chat class handles chat functionalities within the application.
 * It extends the Database class for database connections.
 */
class Chat extends Database
{
    /**
     * Constructor method
     *
     * Initializes the Chat class by calling the parent constructor to establish a database connection.
     * Checks if the user is logged in and has the 'User' role. If not, redirects them to the login page.
     * Checks if a message or a friend email has been submitted through the POST request. If so, invokes
     * the corresponding method.
     */
    public function __construct()
    {
        parent::__construct();

        // Check if the user is not logged in or doesn't have the 'User' role
        if (!isset($_SESSION['member_details']) || $_SESSION['member_details']['role'] !== 'User') {
            header("Location: login.php");
            exit();
        }
    }

    /**
     * handleMessage method
     *
     * Handles the submission of chat messages. Retrieves the sender's email, message, and the receiver's email
     * from the POST request. Inserts the message into the messages table in the database with the current timestamp.
     * Returns a JSON response indicating the success status.
     */
    public function handleMessage()
    {
        $senderEmail = $_SESSION['member_details']['email'];
        $message = $_POST['message'];
        $friendEmail = $_POST['receiver'];
        $_SESSION['friendEmail'] = $friendEmail;

        $sql = "INSERT INTO messages (sender_email, receiver_email, message, timestamp)
            VALUES ('$senderEmail', '$friendEmail', '$message', NOW())";

        mysqli_query($this->get_connection(), $sql);

        echo json_encode(['status' => 'success', 'message' => $message]);
        exit();
    }

    /**
     * getChat method
     *
     * Retrieves chat messages between the logged-in user and a friend.
     * Constructs a SQL query to fetch chat messages from the messages table
     * based on sender and receiver emails. Executes the SQL query and returns
     * the result as a mysqli_result object or false on failure.
     *
     * @return mysqli_result|false
     */
    public function getChat()
    {
        $senderEmail = $_SESSION['member_details']['email'];

        if (isset($_SESSION['friendEmail'])) {
            $friendEmail = $_SESSION['friendEmail'];
        }

        if (isset($_POST['friendEmail'])) {
            $friendEmail = $_POST['friendEmail'];
            unset($_SESSION['redirectReceiverEmail']);
        }

        $sql = "SELECT * FROM messages 
        WHERE (sender_email = '$senderEmail' AND receiver_email = '$friendEmail') 
        OR (sender_email = '$friendEmail' AND receiver_email = '$senderEmail')
        ORDER BY timestamp ASC";

        $result = mysqli_query($this->get_connection(), $sql);
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $messageID = $row['id'];
                $message = $row['message'];
                $sender = $row['sender_email'];

                if ($sender == $_SESSION['member_details']['email']) {
                    echo "<p class='message you'>$message</p>";

                } else {
                    echo "<p class='message friend'>$message</p>";

                    $updatesql = "UPDATE messages SET status = 'read' WHERE id = $messageID";
                    mysqli_query($this->get_connection(), $updatesql);
                }
            }

        } else {
            echo "<p>No messages available.</p>";
        }




        if (!$result) {
            echo "Error: " . $sql . "<br>" . mysqli_error($this->get_connection());
            exit();
        }

        return $result;
    }
}

$chat = new Chat();


if (!empty($_POST) && isset($_POST['action'])) {
    if ($_POST['action'] === 'getChat') {
        $chat->getChat();
    } elseif ($_POST['action'] === 'handleMessage') {
        $chat->handleMessage();
    }
}
?>