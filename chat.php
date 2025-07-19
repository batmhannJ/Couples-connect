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
            padding: 8px 12px;
            margin: 5px 0;
            background-color: #f0f0f0;
            border-radius: 10px;
            display: inline-block;
            max-width: 80%;
        }
        .bot-question {
            color: #0066cc;
            font-weight: bold;
            padding: 8px 12px;
            margin: 5px 0;
            background-color: #e6f3ff;
            border-radius: 10px;
            display: inline-block;
            max-width: 80%;
            cursor: pointer;
            border: 1px solid #cce6ff;
            transition: all 0.2s ease;
        }
        .bot-question:hover {
            background-color: #cce6ff;
            border-color: #99ccff;
            transform: translateY(-1px);
        }
        .user-message {
            text-align: right;
            color: #0066cc;
            padding: 8px 12px;
            margin: 5px 0;
            background-color: #0066cc;
            color: white;
            border-radius: 10px;
            display: inline-block;
            max-width: 80%;
            margin-left: auto;
        }
        .message-container {
            width: 100%;
            margin: 3px 0;
        }
        .message-container.user {
            text-align: right;
        }
        .message-container.bot {
            text-align: left;
        }
        .staff-message {
    color: #fff;
    font-weight: bold;
    padding: 8px 12px;
    margin: 5px 0;
    background-color: #28a745;
    border-radius: 10px;
    display: inline-block;
    max-width: 80%;
    border: 1px solid #1e7e34;
}

.staff-message::before {
    content: "Staff: ";
    font-size: 0.8em;
    opacity: 0.8;
}
</style>


<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>

        <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center">
            <div style="flex:0.5;text-align:right;margin-right:10px">
                <a href="http://localhost/couples-connect/dashboard_user.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
            </div>

            <div style="flex:.1;text-align:center;padding-right:10px">
                <a style='color:black;text-decoration:none'>|</a>
            </div>

            <div style="flex:.3;text-align:center;padding-right:15px">
                <a style='color:black;text-decoration:none'><?php echo $header_name; ?> </a>
            </div>

            <div style="flex:0.6;text-align:right;padding-right:35px">
                <a href="http://localhost/couples-connect/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
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
        url: 'fetch_questions.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
            console.log('Chat data received:', data); // Debug log
            questions = data.questions || [];
            chatHistory = data.chat_history || [];
            displayChatHistory();
            displayQuestions();
            
            // Check for new staff responses periodically
            setTimeout(loadChat, 5000); // Refresh every 5 seconds
        },
        error: function(error) {
            console.error('Error fetching chat data:', error);
            // Retry after 10 seconds on error
            setTimeout(loadChat, 10000);
        }
    });
}

        // Display chat history
        function displayChatHistory() {
            $('#chatlog').empty();

            // Display each message from the chat history
            chatHistory.forEach(item => {
                displayMessage(item.message, item.sender);
            });
        }

        // Display questions as clickable elements
        function displayQuestions() {
            questions.forEach(question => {
                displayMessage(question.questions, 'question', question.questions_id);
            });
        }

        // Display message in the chat window with proper styling and click handlers
        function displayMessage(message, sender, questionId = null) {
            const chatlog = $('#chatlog');
            
            // Create message container
            const messageContainer = $('<div></div>')
                .addClass('message-container')
                .addClass(sender === 'user' ? 'user' : 'bot');

            let messageClass = '';
            let clickable = false;

            if (sender === 'user') {
                messageClass = 'user-message';
            } else if (sender === 'question') {
                messageClass = 'bot-question';
                clickable = true;
            } else {
                messageClass = 'bot-message';
            }

            const messageElement = $('<div></div>')
                .addClass(messageClass)
                .text(message);

            // Add click handler for questions
            if (clickable && questionId) {
                messageElement
                    .attr('data-question-id', questionId)
                    .attr('title', 'Click to see answer')
                    .on('click', function() {
                        fetchAnswer(questionId);
                    });
            }

            messageContainer.append(messageElement);
            chatlog.append(messageContainer);
            
            // Auto-scroll to the latest message
            chatlog.scrollTop(chatlog[0].scrollHeight);
        }

        // Send user message to the backend and store it in the session
        function sendMessage() {
            const userInput = $('#userInput');
            const userMessage = userInput.val().trim();
            
            if (userMessage) {
                // Display user message immediately
                displayMessage(userMessage, 'user');
                userInput.val('');

                // Send to backend
                $.ajax({
                    url: 'fetch_questions.php',
                    method: 'POST',
                    data: {
                        message: userMessage,
                        sender: 'user'
                    },
                    success: function(response) {
                        console.log('Message sent successfully');
                    },
                    error: function(error) {
                        console.error('Error sending message:', error);
                    }
                });
            }
        }

        // Fetch and display the answer when a question is clicked
        function fetchAnswer(questionId) {
            console.log('Fetching answer for question ID:', questionId);
            
            // Find the question in our questions array
            const questionData = questions.find(q => q.questions_id == questionId);
            
            if (questionData && questionData.answers) {
                // Display the answer immediately
                displayMessage(questionData.answers, 'bot');

                // Store the answer in chat history via backend
                $.ajax({
                    url: 'fetch_questions.php',
                    method: 'POST',
                    data: {
                        message: questionData.answers,
                        sender: 'bot',
                        question_id: questionId
                    },
                    success: function(response) {
                        console.log('Answer stored in chat history');
                    },
                    error: function(error) {
                        console.error('Error storing answer:', error);
                    }
                });
            } else {
                console.error('Question not found or no answer available for ID:', questionId);
                displayMessage('Sorry, no answer is available for this question.', 'bot');
            }
        }

        // Initialize chat when the page is ready
        $(document).ready(function() {
            loadChat();
        });
        function displayMessage(message, sender, questionId = null) {
        const chatlog = $('#chatlog');
        
        // Create message container
        const messageContainer = $('<div></div>')
            .addClass('message-container')
            .addClass(sender === 'user' ? 'user' : 'bot');

        let messageClass = '';
        let clickable = false;

        if (sender === 'user') {
            messageClass = 'user-message';
        } else if (sender === 'question') {
            messageClass = 'bot-question';
            clickable = true;
        } else if (sender === 'staff') {
            messageClass = 'staff-message';  // New class for staff messages
        } else {
            messageClass = 'bot-message';
        }

        const messageElement = $('<div></div>')
            .addClass(messageClass)
            .text(message);

        // Add click handler for questions
        if (clickable && questionId) {
            messageElement
                .attr('data-question-id', questionId)
                .attr('title', 'Click to see answer')
                .on('click', function() {
                    fetchAnswer(questionId);
                });
        }

        messageContainer.append(messageElement);
        chatlog.append(messageContainer);
        
        // Auto-scroll to the latest message
        chatlog.scrollTop(chatlog[0].scrollHeight);
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