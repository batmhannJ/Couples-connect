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
$userid = 0;

$username_hidden = isset($_POST['username_hidden']) ? $_POST['username_hidden'] : '';

$select_db_userid = "SELECT * FROM mf_prog_users WHERE username='" . $username_hidden . "' LIMIT 1";
$stmt_userid    = $link->prepare($select_db_userid);
$stmt_userid->execute();
while ($rs_userid = $stmt_userid->fetch()) {
    $userid = $rs_userid['userid'];
}

// var_dump($header_name);


?>

<style>
    textarea:focus {
        outline: none;
    }
</style>

<link href='https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css' rel='stylesheet'>
<link href='https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css' rel='stylesheet'>
<div class="container-fluid">
    <div class='row bg-white' style="height:99px">
        <div class="col-3 pe-0 d-flex align-items-center">
            <img src="images/350 x 88.png" style='height:76px;width:auto;'>
        </div>

        <div class="col-3 offset-6" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center">
            <div style="flex:0.5;text-align:right;margin-right:10px">
                <a href="http://localhost/couples-connectprog/select_option.php" style='color:black;text-decoration:none' class='has_hover'>HOME</a>
            </div>

            <div style="flex:.1;text-align:center;padding-right:10px">
                <a style='color:black;text-decoration:none'>|</a>
            </div>

            <div style="flex:.3;text-align:center;padding-right:15px">
                <a style='color:black;text-decoration:none'><?php echo $header_name; ?> </a>
            </div>

            <div style="flex:0.6;text-align:right;padding-right:35px">
                <a href="http://localhost/couples-connectprog/logout_cc.php" class='has_hover' style='color:black;text-decoration:none'>LOGOUT</a>
            </div>

        </div>
    </div>
</div>

<form name='myforms' id="myforms" method="post" target="_self" style='height:100%'>
    <table style="width:100%;height:100%;background-color:#f2f2f2">
        <tr>
            <td style='width:30%'>
                <div class="row h-100 justify-content-center align-items-center">
                    <div style='width:437px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))'>
                        <div class="m-3 pt-2 text-center login_form_header">
                            <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0">Options</p>
                            <img src="images/Rectangle 11934.png" style='width:100%'>
                        </div>

                        <?php
                        require 'cc_mf_menu.php';
                        ?>


                    </div>
                </div>
            </td>

            <td style='width:70%'>
                <div class="row h-100 justify-content-center align-items-center">
                    <div style='width:1025px;height:700px;background-color:white;border-radius:30px;filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25));display:flex;flex-direction:column'>

                        <div class="m-3 pt-2">

                            <div class="row">
                                <div class="col-2">
                                    <a href="http://localhost/couples-connectprog/cc_counseling.php"><img src="images/Vector (1).png" style='height:30px;width:20px'></a>
                                </div>

                                <div class="col-10 d-flex justify-content-center" style='padding-right:375px'>
                                    <p style="font-weight:bold;font-size:27px;font-family:inter;margin-bottom:0;margin-left:75px">Documentation Report</p>
                                </div>
                            </div>


                            <img src="images/Rectangle 11934.png" style='width:100%;height:4px'>

                        </div>
                        <div class="mb-2 mx-2 px-2 mt-0">
                            <div style='font-size:21px;font-family:inter;font-weight:500'>
                                Counseling/PM Counseling Session
                            </div>

                            <div style='font-size:18px;font-family:inter;font-weight:500' class='mt-3'>
                                Date of Session: <?php


                                                    $select_db_userid = "SELECT * FROM ext_mf_meiform WHERE userid='" . $userid . "' LIMIT 1";
                                                    $stmt_userid    = $link->prepare($select_db_userid);
                                                    $stmt_userid->execute();
                                                    while ($rs_date_userid = $stmt_userid->fetch()) {
                                                        echo "<span style='font-weight:700'>" . date('F j, Y', strtotime($rs_date_userid['date'])) . "<span>";
                                                    }

                                                    ?>
                            </div>

                            <div class='container mt-3 mx-0 px-0' style='max-height:130px;overflow-y:auto'>




                                <table style="width: 800px" id="change_table" name="change_table">
                                    <thead>
                                        <tr style="font-size: 14px; font-family: inter; font-weight: 700">
                                            <td class="text-center">Concerns</td>
                                            <td class="text-center">Detailed Description</td>
                                            <td class="text-center">Recommendations</td>
                                            <td class="text-center">Future Actions</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td style='height:80px;width:25%'>

                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-left:1px solid black;                                                         
                                                            width:100%;height:100%'>


                                                    <select
                                                        class="issue-select"
                                                        name="text_submit[1][concern]"
                                                        id="text_submit[1][concern]"
                                                        style='width:100%;height:100%;border:none;border-radius:none;'>
                                                        <?php

                                                        $select_db_concerns = "SELECT * FROM mf_concerns";
                                                        $stmt_concerns    = $link->prepare($select_db_concerns);
                                                        $stmt_concerns->execute();
                                                        while ($rs_concerns = $stmt_concerns->fetch()) {
                                                            echo "<option value='" . $rs_concerns['concern_id'] . "'>" . $rs_concerns['concerns'] . "</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                </div>

                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-left:1px solid black;
                                                            border-right:1px solid black;
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        class="detailedDescription"
                                                        name="text_submit[1][description]"
                                                        id="text_submit[1][description]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-right:1px solid black;
                                                           
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        class="recommendations"
                                                        name="text_submit[1][reccomendation]"
                                                        id="text_submit[1][reccomendation]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-right:1px solid black;
                                                           
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        class="futureActions"
                                                        name="text_submit[1][future_actions]"
                                                        id="text_submit[1][future_actions]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>


                                <div style='font-size:14px;font-weight:500;font-family:inter;color:#797979;margin-left:100px;margin-top:10px' id="addRowBtn" class="add-row-btn">
                                    Add New
                                    <img src='images/add_new_cnr.png' style='width:18px;height:18px' />
                                </div>


                                <!-- <table style='width:800px' id='change_table' name='change_table'>

                                    <thead>
                                        <tr style='font-size:14px;font-family:inter;font-weight:700'>
                                            <td class='text-center'>
                                                Concerns
                                            </td>
                                            <td class='text-center'>
                                                Detailed Description
                                            </td>
                                            <td class='text-center'>
                                                Recommendations
                                            </td>
                                            <td class='text-center'>
                                                Future Actions
                                            </td>
                                        </tr>
                                    </thead>

                                    <tbody>
                                        <tr>
                                            <td style='height:80px;width:25%'>

                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-left:1px solid black;                                                         
                                                            width:100%;height:100%'>


                                                    <select
                                                        name="text_submit[1][concern]"
                                                        id="text_submit[1][concern]"
                                                        style='width:100%;height:100%;border:none;border-radius:none;'>
                                                        <?php

                                                        $select_db_concerns = "SELECT * FROM mf_concerns";
                                                        $stmt_concerns    = $link->prepare($select_db_concerns);
                                                        $stmt_concerns->execute();
                                                        while ($rs_concerns = $stmt_concerns->fetch()) {
                                                            echo "<option value='" . $rs_concerns['concern_id'] . "'>" . $rs_concerns['concerns'] . "</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                </div>

                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-left:1px solid black;
                                                            border-right:1px solid black;
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        name="text_submit[1][description]"
                                                        id="text_submit[1][description]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>

                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-right:1px solid black;
                                                           
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        name="text_submit[1][reccomendation]"
                                                        id="text_submit[1][reccomendation]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-right:1px solid black;
                                                           
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        name="text_submit[1][future_actions]"
                                                        id="text_submit[1][future_actions]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table> -->
                                <!-- <div style='font-size:14px;font-weight:500;font-family:inter;color:#797979;margin-left:100px;margin-top:10px' onclick="add_new('add_new')">
                                    Add New
                                    <img src='images/add_new_cnr.png' style='width:18px;height:18px' />
                                </div> -->
                            </div>


                            <!-- <div style='margin-top:20px'>
                                    <div style='font-size:20px;font-family:inter;font-weight:500'>
                                        Reccomendations For Future Action
                                    </div>
                                    <textarea name="future_reco" id="future_reco" cols="10" rows="2" class='form-control' style='
                                    width:450px;
                                    border: 1px solid black;'></textarea>
                                </div> -->

                            <div style='margin-top:20px'>
                                <div style='font-size:18px;font-family:inter;font-weight:500'>
                                    General Evaluation
                                </div>
                                <select name="select_status" id="select_status" class='form-control' style='width:260px;font-size:18px'>
                                    <option value='APR'>Approved</option>
                                    <option value='DAR'>Disapproved</option>
                                </select>
                            </div>

                            <div style='font-size:18px;font-family:inter;font-weight:500;flex-direction:row' class='d-flex mt-3'>
                                <div>
                                    Prepared By: <?php echo "<span style='font-weight:700'>" . $_SESSION['username'] . "</span>"; ?></br>
                                </div>
                            </div>

                            <div style='font-size:20px;font-family:inter;font-weight:500;flex-direction:row' class='d-flex mt-3'>
                                <div>
                                    <button type="button" class="btn" id="fetchData" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:250px;height:auto;font-size:17px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))"><img src="images/robot.png" alt="" style='margin-bottom:4px'> Generate Suggestions</button>
                                    <div id="output"></div>

                                    <script>
                                        // Add new row functionality
                                        document.getElementById("addRowBtn").addEventListener("click", () => {
                                            const tableBody = document.querySelector("#change_table tbody");

                                            const newRow = document.createElement("tr");

                                            newRow.innerHTML = `
 <td style='height:80px;width:25%'>

                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-left:1px solid black;                                                         
                                                            width:100%;height:100%'>


                                                    <select
                                                        class="issue-select"
                                                        name="text_submit[1][concern]"
                                                        id="text_submit[1][concern]"
                                                        style='width:100%;height:100%;border:none;border-radius:none;'>
                                                        <?php

                                                        $select_db_concerns = "SELECT * FROM mf_concerns";
                                                        $stmt_concerns    = $link->prepare($select_db_concerns);
                                                        $stmt_concerns->execute();
                                                        while ($rs_concerns = $stmt_concerns->fetch()) {
                                                            echo "<option value='" . $rs_concerns['concern_id'] . "'>" . $rs_concerns['concerns'] . "</option>";
                                                        }

                                                        ?>
                                                    </select>
                                                </div>

                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-left:1px solid black;
                                                            border-right:1px solid black;
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        class="detailedDescription"
                                                        name="text_submit[1][description]"
                                                        id="text_submit[1][description]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-right:1px solid black;
                                                           
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        class="recommendations"
                                                        name="text_submit[1][reccomendation]"
                                                        id="text_submit[1][reccomendation]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>

                                            <td style='height:80px;width:25%'>
                                                <div style='border-top:1px solid black;
                                                            border-bottom:1px solid black;
                                                            border-right:1px solid black;
                                                           
                                                            width:100%;height:100%'>
                                                    <textarea
                                                        class="futureActions"
                                                        name="text_submit[1][future_actions]"
                                                        id="text_submit[1][future_actions]"
                                                        style='width:100%;height:100%;border:none;border-radius:15px;'></textarea>
                                                </div>
                                            </td>
        `;
                                            tableBody.appendChild(newRow);
                                        });

                                        // Fetch Recommendations for all rows
                                        document
                                            .getElementById("fetchData")
                                            .addEventListener("click", async () => {
                                                const output = document.getElementById("output");
                                                output.textContent = "Loading..."; // Indicate loading

                                                const apiKey = "AIzaSyAn1lc5_YQFiS3296o9SwXxjtujWomQt0c"; // Replace with your actual API key
                                                const endpoint = `https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=${apiKey}`;

                                                // Loop through all rows to fetch data for each issue
                                                const rows = document.querySelectorAll("#change_table tbody tr");

                                                await detailedDescription(rows, apiKey, endpoint);

                                                await recomedation(rows, apiKey, endpoint);

                                                await futureActions(rows, apiKey, endpoint);
                                                output.textContent = ""; 
                                            });

                                        const detailedDescription = async (rows, apiKey, endpoint) => {
                                            // Loop through each row
                                            for (let row of rows) {
                                                const issueSelect = row.querySelector(".issue-select");
                                                const selectedIssue = issueSelect.options[issueSelect.selectedIndex].text;

                                                const problemCategory = "General Issue";
                                                const timeline = "Immediate";
                                                const responseFormat = "Paragraph";

                                                const rbRecomendation = {
                                                    contents: [{
                                                        parts: [{
                                                            text: `  
                Please generate recommendations for the following issue, focusing only on professional recommendations:

                **Issue:** ${selectedIssue}

                **Problem Category:** ${problemCategory}
    
                **Timeline:** ${timeline}
                **Desired Response Format:** ${responseFormat}

                **Detailed Description: Please provide a professional, detailed description of the issue.**

                **Recommendations:** "Please provide professional recommendations."

                **Future Actions:** "Please suggest future steps for resolution."
              `,
                                                        }, ],
                                                    }, ],
                                                };

                                                try {
                                                    const response = await fetch(endpoint, {
                                                        method: "POST",
                                                        headers: {
                                                            "Content-Type": "application/json",
                                                        },
                                                        body: JSON.stringify(rbRecomendation),
                                                    });

                                                    if (!response.ok) {
                                                        throw new Error(
                                                            "Network response was not ok: " + response.statusText
                                                        );
                                                    }

                                                    const data = await response.json();
                                                    console.log("API Response:", data); // Log to inspect the structure

                                                    // Ensure the expected structure is present
                                                    if (data && data.candidates && data.candidates.length > 0) {
                                                        const aiResponse =
                                                            data.candidates[0].content?.parts[0]?.text?.trim();

                                                        if (
                                                            aiResponse &&
                                                            !row.querySelector(".detailedDescription").value
                                                        ) {
                                                            // If there's no value already in the textarea, set the AI response
                                                            row.querySelector(".detailedDescription").value =
                                                                aiResponse || "No Detailed Description provided.";
                                                        } else if (row.querySelector(".detailedDescription").value) {
                                                            // Skip setting value if it already has one
                                                            console.log(
                                                                "Skipping Detailed Description for row with pre-filled value"
                                                            );
                                                        }
                                                    } else {
                                                        throw new Error(
                                                            "API response does not contain the expected content."
                                                        );
                                                    }
                                                } catch (error) {
                                                    console.error("Error:", error); // Log the error
                                                    row.querySelector(".detailedDescription").value =
                                                        "Error: " + error.message;
                                                }
                                            }
                                        };

                                        const recomedation = async (rows, apiKey, endpoint) => {
                                            for (let row of rows) {
                                                const issueSelect = row.querySelector(".issue-select");
                                                const selectedIssue = issueSelect.options[issueSelect.selectedIndex].text;

                                                const problemCategory = "General Issue";
                                                const timeline = "Immediate";
                                                const responseFormat = "Paragraph";

                                                const rbRecomendation = {
                                                    contents: [{
                                                        parts: [{
                                                            text: `  
                  Please generate recommendations for the following issue, focusing only on professional recommendations:

                  **Issue:** ${selectedIssue}

                  **Problem Category:** ${problemCategory}
    
                  **Timeline:** ${timeline}
                  **Desired Response Format:** ${responseFormat}

                  **Recommendations:** "Please provide professional recommendations."
                `,
                                                        }, ],
                                                    }, ],
                                                };

                                                try {
                                                    const response = await fetch(endpoint, {
                                                        method: "POST",
                                                        headers: {
                                                            "Content-Type": "application/json",
                                                        },
                                                        body: JSON.stringify(rbRecomendation),
                                                    });

                                                    if (!response.ok) {
                                                        throw new Error(
                                                            "Network response was not ok: " + response.statusText
                                                        );
                                                    }

                                                    const data = await response.json();

                                                    if (data && data.candidates && data.candidates.length > 0) {
                                                        const aiResponse =
                                                            data.candidates[0].content?.parts[0]?.text?.trim();

                                                        if (aiResponse && !row.querySelector(".recommendations").value) {
                                                            // If there's no value already in the textarea, set the AI response
                                                            row.querySelector(".recommendations").value =
                                                                aiResponse || "No recommendations provided.";
                                                        } else if (row.querySelector(".recommendations").value) {
                                                            // Skip setting value if it already has one
                                                            console.log(
                                                                "Skipping recommendations for row with pre-filled value"
                                                            );
                                                        }
                                                    } else {
                                                        throw new Error(
                                                            "API response does not contain the expected content."
                                                        );
                                                    }
                                                } catch (error) {
                                                    output.textContent = "Error: " + error.message;
                                                }
                                            }
                                        };

                                        const futureActions = async (rows, apiKey, endpoint) => {
                                            // Loop through each row
                                            for (let row of rows) {
                                                const issueSelect = row.querySelector(".issue-select");
                                                const selectedIssue = issueSelect.options[issueSelect.selectedIndex].text;

                                                const problemCategory = "General Issue";
                                                const timeline = "Immediate";
                                                const responseFormat = "Paragraph";

                                                const rbRecomendation = {
                                                    contents: [{
                                                        parts: [{
                                                            text: `  
                Please generate recommendations for the following issue, focusing only on professional recommendations:

                **Issue:** ${selectedIssue}

                **Problem Category:** ${problemCategory}
    
                **Timeline:** ${timeline}
                **Desired Response Format:** ${responseFormat}

                **Future Actions:** "Please suggest future steps for resolution."
              `,
                                                        }, ],
                                                    }, ],
                                                };

                                                try {
                                                    const response = await fetch(endpoint, {
                                                        method: "POST",
                                                        headers: {
                                                            "Content-Type": "application/json",
                                                        },
                                                        body: JSON.stringify(rbRecomendation),
                                                    });

                                                    if (!response.ok) {
                                                        throw new Error(
                                                            "Network response was not ok: " + response.statusText
                                                        );
                                                    }

                                                    const data = await response.json();
                                                    console.log("API Response:", data); // Log to inspect the structure

                                                    // Ensure the expected structure is present
                                                    if (data && data.candidates && data.candidates.length > 0) {
                                                        const aiResponse =
                                                            data.candidates[0].content?.parts[0]?.text?.trim();

                                                        if (aiResponse && !row.querySelector(".futureActions").value) {
                                                            // If there's no value already in the textarea, set the AI response
                                                            row.querySelector(".futureActions").value =
                                                                aiResponse || "No future actions.";
                                                        } else if (row.querySelector(".futureActions").value) {
                                                            // Skip setting value if it already has one
                                                            console.log(
                                                                "Skipping recommendations for row with pre-filled value"
                                                            );
                                                        }
                                                    } else {
                                                        throw new Error(
                                                            "API response does not contain the expected content."
                                                        );
                                                    }
                                                } catch (error) {
                                                    console.error("Error:", error); // Log the error
                                                    row.querySelector(".futureActions").value =
                                                        "Error: " + error.message;
                                                }
                                            }
                                        };
                                    </script>

                                </div>

                                <div style='margin-left:50px;'>
                                    <button type="button" class="btn" onclick="viewMei('PMC')" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:185px;height:auto;font-size:18px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">View MEI form</button>
                                </div>
                            </div>

                            <div class="row d-flex justify-content-center align-items-center" style="margin-top:20px">
                                <button type="button" onclick="add_new('submit_data')" class="btn" style="background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:175px;height:auto;font-size:19px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </td>
        </tr>

    </table>

    <div class="modal fade  xerror_modal" data-bs-backdrop="static" id="xerror_modal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Couples Connect Says:</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <p class="error_msg">Modal body text goes here.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal_meiform" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" style='max-width:80vw'>
            <div class="modal-content" style='border-radius:20px'>
                <div class="modal-header pb-0 mb-0">
                    <div class="modal-title" style='margin-left:18px'>
                        <div class="modal-title" id="exampleModalLabel" style='font-size:33px;font-family:inter;font-weight:600'>Marriage Expectatiton Form</div>
                        <div class="modal-title" id="exampleModalLabel" style='font-size:21px;font-family:inter'>Fill-up Form</div>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" style="font-size:30px"></button>
                </div>
                <div class="modal-body">
                    <table style='width:100%;max-height:100px'>
                        <tr>
                            <td style='width:40%'>
                                &nbsp;
                            </td>

                            <td style='width:30%' colspan="2">
                                <div style='margin-left:18px'>

                                    <div style='font-family:inter;font-size:24px;font-weight:500;'>Partner 1</div>
                                    <?php
                                    echo "<div style='font-family:inter;font-size:24px;font-weight:300;color:#3D3D3D' id='meiform_p1_name'></div>";
                                    ?>
                                </div>
                            </td>

                            <td style='width:30%' colspan="2">
                                <div style='margin-left:18px'>

                                    <div style='font-family:inter;font-size:24px;font-weight:500;'>Partner 2</div>
                                    <?php
                                    echo "<div style='font-family:inter;font-size:24px;font-weight:300;color:#3D3D3D' id='meiform_p2_name'></div>";
                                    ?>
                                </div>
                            </td>

                        </tr>

                        <tr>
                            <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:50%;padding-left:20px;width:40%'>
                                Statement
                            </td>

                            <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:10%;margin-left:18px' class='px-3'>
                                Answer
                            </td>

                            <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:10%;margin-left:18px' class='px-3'>
                                Reason/s
                            </td>

                            <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:10%;margin-left:18px' class='px-3'>
                                Answer
                            </td>

                            <td style='font-size:23px;font-family:inter;font-weight:500;color:#797979;width:15%;margin-left:18px' class='px-3'>
                                Reason/s
                            </td>
                        </tr>

                        <?php
                        $meiform_count = 1;
                        $select_db_meiform = "SELECT  * FROM mf_meiform";
                        // $select_db_meiform = "SELECT mf_meiform.questions as 'questions',  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid=?";
                        $stmt_meiform    = $link->prepare($select_db_meiform);
                        $stmt_meiform->execute();
                        while ($row_meiform = $stmt_meiform->fetch()) {
                            echo "<tr>";

                            echo "<td style='width:50%;font-weight:500;font-family:inter;font-size:16px;padding-left:20px;padding-top:10px'>";
                            echo "<div style='width:90%'>" . $meiform_count . ". " . $row_meiform['questions'] . "</div>";
                            echo "</td>";

                            $select_db_meiform_1 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='" . $row_meiform['meiformid'] . "' AND ext_mf_meiform.partnerid='1' LIMIT 1";
                            $stmt_meiform_1    = $link->prepare($select_db_meiform_1);
                            $stmt_meiform_1->execute();

                            while ($row_meiform_1 = $stmt_meiform_1->fetch()) {

                                echo "<td class='px-3' style='width:10%'>";
                                echo "<select style='color:white' name='ans_1[" . $meiform_count . "]' class='form_control' id='ans_1[" . $meiform_count . "]' disabled>";
                                echo "<option>Agree</option>";
                                echo "<option>Disagree</option>";
                                echo "</select>";
                                echo "</td>";

                                echo "<td class='px-3' style='width:15%'>";
                                echo "<textarea style='width:100%;border-radius:5px' disabled name='reason_1[" . $meiform_count . "]' id='reason_1[" . $meiform_count . "]'>" . $row_meiform_1['reasons'] . "</textarea>";
                                echo "</td>";
                            }

                            $select_db_meiform_2 = "SELECT ext_mf_meiform.answers as 'answers', ext_mf_meiform.reasons as 'reasons'  FROM ext_mf_meiform LEFT JOIN mf_meiform ON ext_mf_meiform.meiformid =  mf_meiform .meiformid WHERE ext_mf_meiform.meiformid='" . $row_meiform['meiformid'] . "' AND ext_mf_meiform.partnerid='2' LIMIT 1";
                            $stmt_meiform_2    = $link->prepare($select_db_meiform_2);
                            $stmt_meiform_2->execute();

                            $meiform_count2 = $meiform_count + 10;

                            while ($row_meiform_2 = $stmt_meiform_2->fetch()) {

                                echo "<td class='px-3' style='width:10%'>";
                                echo "<select style='color:white' disabled name='ans_2[" . $meiform_count2 . "]' class='form_control' id='ans_2[" . $meiform_count2 . "]'>";
                                echo "<option>Agree</option>";
                                echo "<option>Disagree</option>";
                                echo "</select>";
                                echo "</td>";

                                echo "<td class='px-3' style='width:20%'>";
                                echo "<textarea style='width:100%;border-radius:5px'  name='reason_2[" . $meiform_count2 . "]' id='reason_2[" . $meiform_count2 . "]' disabled>" . $row_meiform_2['reasons'] . "</textarea>";
                                echo "</td>";
                            }
                            echo "</tr>";


                            $meiform_count++;
                        }

                        ?>
                    </table>
                </div>
                <!-- <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Save changes</button>
                    </div> -->
            </div>
        </div>
    </div>

    <!-- <footer style='height:100px;background-color:#23408E' class='footer'>
            <div class="container-fluid"  style='height:100px'>

                <div class="row"  style='height:100px'>
                    <div class="col-4">
                        <div class="row ms-3"  style='height:100px'>
                            <div class="col-2 d-flex align-items-center">
                                <img src="images/op office logo.png" style="height:77px;width:auto">
                            </div>

                            <div class="col-10 d-flex align-items-center">
                                <div class="container" style='font-family:inter;color:white'>
                                    <div class="col-12" style='font-size:15px;font-weight:bold'>
                                        City Population Office of Cabuyao
                                    </div>

                                    <div class="col-12" style='font-size:9px'>
                                        Brgy Dos. Cabuyao Retail Plaza, Cabuyao, Philippines
                                    </div>

                                    <div class="col-12" style='font-size:9px'>
                                        cpocabuyao@gmail.com
                                    </div>

                                </div>
          
                            </div>
                        </div>       
                    </div>

                    <div class="col-8 d-flex align-items-center justify-content-end">
                        <div>
                            <img src="images/pajamas_question.png" style='width:63px;height:auto;'>
                        </div>   
                    </div>
                </div>

            </div>
        </footer> -->

    <input type="hidden" name="ac_recid_hidden" id="ac_recid_hidden" value="<?php echo $_POST['ac_recid_hidden']; ?>">
    <input type="hidden" name="current_rows" id="current_rows">
    <input type="hidden" name="username_hidden" id="username_hidden" value="<?= $username_hidden; ?>">

</form>

<script>
    function add_new(xevent_action) {


        var current_rows = $("#current_rows").val();
        var ac_recid_hidden = $("#ac_recid_hidden").val();


        if (current_rows == "" || current_rows == null) {
            current_rows = 1;
        }


        if (xevent_action == 'add_new') {
            var xallData = `event_action=${xevent_action}&current_rows=${current_rows}`;
        } else if (xevent_action == 'submit_data') {
            var xallData = $("#myforms *").serialize() + `&event_action=${xevent_action}&current_rows=${current_rows}&ac_recid_hidden=${ac_recid_hidden}`;
        }

        $.ajax({
            url: 'cc_counseling2_ajax.php',
            type: "post",
            data: xallData,
            success: function(xdata) {

                if (xevent_action == "add_new") {
                    $("#current_rows").val(xdata['new_row']);
                    $("#change_table").append(xdata['html']);
                } else if (xevent_action == "submit_data") {
                    document.forms.myforms.method = "post";
                    document.forms.myforms.target = "_self";
                    document.forms.myforms.action = "cc_counseling.php";
                    document.forms.myforms.submit();
                }


            },
            error: function(request, status, error) {}
        });
    }

    function viewMei() {

        var username_hidden2 = $("#username_hidden").val();

        $.ajax({
            url: 'cc_counseling_ajax.php',
            type: "post",
            data: {
                xevent_action: "view_meiform",
                xusername: username_hidden2
            },
            success: function(xdata) {

                var counter_cert = 1;
                $.each(xdata, function(index, value) {

                    if (value.hasOwnProperty('p1')) {

                        $(`[id="ans_1[${counter_cert}]"]`).val(function() {
                            return $(this).find("option").filter(function() {
                                return $(this).text() === value.p1.answer;
                            }).val();
                        });

                        if (value.p1.answer == 'Agree') {
                            $(`[id="ans_1[${counter_cert}]"]`).css('background-color', '#2eb82e')
                        } else {
                            $(`[id="ans_1[${counter_cert}]"]`).css('background-color', '#e62e00')
                        }

                        $(`[id="reason_1[${counter_cert}]"]`).html(value.p1.reason);

                        // console.log('p1 answer: ' + value.p1.answer);
                        // console.log('p1 reason: ' + value.p1.reason);
                        // console.log('p1 reason: ' + value.p1.counter);

                    } else if (value.hasOwnProperty('p2')) {

                        $(`[id="ans_2[${counter_cert}]"]`).val(function() {
                            return $(this).find("option").filter(function() {
                                return $(this).text() === value.p2.answer;
                            }).val();
                        });

                        if (value.p2.answer == 'Agree') {
                            $(`[id="ans_2[${counter_cert}]"]`).css('background-color', '#2eb82e')
                        } else {
                            $(`[id="ans_2[${counter_cert}]"]`).css('background-color', '#e62e00')
                        }

                        $(`[id="reason_2[${counter_cert}]"]`).html(value.p2.reason);


                    }

                    counter_cert++;

                });

                $("#meiform_p1_name").html(xdata['partner1_name']);
                $("#meiform_p2_name").html(xdata['partner2_name']);
            },
            error: function(request, status, error) {}
        });
        $("#modal_meiform").modal("show");
    }
</script>

<?php
require "includes/cc_footer.php";
?>