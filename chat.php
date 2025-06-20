<?php
require "includes/cc_header.php";

$header_name = '';
if ($_SESSION['usertype'] == 'DSK') {
    $header_name = "DESK";
} else if ($_SESSION['usertype'] == 'CNR') {
    $header_name = "COUNSELOR";
} else if ($_SESSION['usertype'] == 'HED') {
    $header_name = "HEAD";
}

?>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script>
    $(document).ready(function() {
        $('#tbl_list').DataTable();
    });
</script>

<style type="text/css">
        #chatbox {
            background-color: #fff;
            border-radius: 10px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 500px;
            margin: 0 auto;
            margin-top: 100px;
        }
        #chatlog {
            height: 300px;
            overflow-y: scroll;
            border-bottom: 1px solid #ddd;
            padding: 10px;
            margin-bottom: 10px;
        }
        #userInput {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ddd;
        }
        .bot-message {
            color: #333;
            font-weight: bold;
        }
        .user-message {
            text-align: right;
            color: #0066cc;
        }
</style>


<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>

        <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center">
            <div style="flex:0.5;text-align:right;margin-right:10px">
                <a href="http://localhost/couplesconnectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
            </div>

            <div style="flex:.1;text-align:center;padding-right:10px">
                <a style='color:black;text-decoration:none'>|</a>
            </div>

            <div style="flex:.3;text-align:center;padding-right:15px">
                <a style='color:black;text-decoration:none'><?php echo $header_name; ?> </a>
            </div>

            <div style="flex:0.6;text-align:right;padding-right:35px">
                <a href="http://localhost/couplesconnectprog/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
            </div>

        </div>
    </div>
</div>

    <div id="chatbox">
        <p id="chatdefault">Hello, how can I help you?</p>
        <div id="chatlog">
        </div>
        <input type="text" id="userInput" placeholder="Type your answer..." onkeypress="if(event.key === 'Enter'){sendMessage()}">
    </div>

<script>
        let questions = [];
        let chatHistory = [];

        // Fetch questions and chat history from the backend
        function loadChat() {
            $.ajax({
                url: 'fetch_questions.php',  // PHP file to fetch questions and chat history
                method: 'GET',
                dataType: 'json',
                success: function(data) {
                    questions = data.questions;  // Data contains an array of question objects
                    chatHistory = data.chat_history;  // Existing chat history for the user
                    displayChatHistory();
                    displayQuestions();
                },
                error: function(error) {
                    console.error('Error fetching chat data:', error);
                }
            });
        }

        // Display chat history
        function displayChatHistory() {
            $('#chatlog').empty();  // Clear chat log

            // Display each message from the chat history
            chatHistory.forEach(item => {
                displayMessage(item.message, item.sender);
            });
        }

        // Display questions and answers
        function displayQuestions() {
            questions.forEach(question => {
                displayMessage(question.questions, 'bot', question.questions_id);
            });
        }

        // Display message in the chat window
        function displayMessage(message, sender, questionId) {
            const chatlog = $('#chatlog');
            const messageElement = $('<div></div>')
                .addClass(sender === 'bot' ? 'bot-message' : 'user-message')
                .text(message)
                .attr('data-id', questionId)
                .on('click', function() {
                    if (sender === 'bot') {
                        fetchAnswer(questionId);
                    }
                });

            chatlog.append(messageElement);
            chatlog.scrollTop(chatlog[0].scrollHeight);  // Auto-scroll to the latest message
        }

        // Send user message to the backend and store it in the session
        function sendMessage() {
            const userInput = $('#userInput');
            const userMessage = userInput.val().trim();
            if (userMessage) {
                $.ajax({
                    url: 'fetch_questions.php',
                    method: 'POST',
                    data: {
                        message: userMessage,
                        sender: 'user'
                    },
                    success: function(response) {
                        displayMessage(userMessage, 'user');
                        userInput.val('');
                    },
                    error: function(error) {
                        console.error('Error sending message:', error);
                    }
                });
            }
        }

        // Fetch and display the answer when a question is clicked
        function fetchAnswer(questionId) {
            const questionData = questions.find(q => q.questions_id === String(questionId));
            if (questionData && questionData.answers) {
                $.ajax({
                    url: 'fetch_questions.php',
                    method: 'POST',
                    data: {
                        message: questionData.answers,
                        sender: 'bot'
                    },
                    success: function(response) {
                        displayMessage(questionData.answers, 'bot');
                    },
                    error: function(error) {
                        console.error('Error fetching answer:', error);
                    }
                });
            }
        }

        // Initialize chat when the page is ready
        $(document).ready(function() {
            loadChat();
        });
    </script>

</div>
</div>
</div>
</div>
</td>
</tr>

</table>







