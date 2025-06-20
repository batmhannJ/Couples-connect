<?php
require "includes/cc_header.php";
?>
    <style>
        .overflowYScroll{
            overflow-y:scroll;
        }
    </style>

    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" />
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>

    <div class="container-fluid">
        <div class='row bg-white' style="height:99px">
            <div class="col-3 pe-0 d-flex align-items-center">
                <img src="images/350 x 88.png" style='height:76px;width:auto;'>
            </div>

            <div class="col-4 offset-5" style="display:flex;flex-direction:row;justify-content:center;font-family:inter;font-size:21px;align-items:center"> 
                <div style="flex:0.8">
                    <a href="http://localhost/couplesconnect_wp/" style='color:black;text-decoration:none'>HOME</a>
                </div>

                <div style="flex:1.1">
                    
                    <a href="http://localhost/couplesconnect_wp/about-us/" style='color:black;text-decoration:none'>ABOUT US</a>

                </div>

                <div style="flex:1.1">
                    <a href="http://localhost/couplesconnect_wp/contact-us/" style='color:black;text-decoration:none'>CONTACTS</a>
                </div>

                <div style="flex:1">
                    <a href="http://localhost/couplesconnectprog/login_cc.php" style='color:black;text-decoration:none'>| LOGIN</a>
                </div>

            </div> 
        </div>
    </div>
    
    <form name='myforms' id="myforms" method="post" target="_self" style='height:100%'> 
        <table style="width:100%;height:calc(100% - 100px);	filter: drop-shadow(0px 4px 15px rgba(0, 0, 0, 0.25))">
            <tr>
                <td>
                    <div class="row justify-content-center align-items-center">
                        <div class='confirm_main_div' style='width:1400px;height:600px;background-color:white;border-radius:30px'>
                            <div class="mx-5 px-3 pt-4 text-left login_form_header">
                                <p style="margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:33px">Confirmation</p>
                                <p style="line-height:0.9;margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:21px;color:#9B9B9B">Personal Information</p>
                                <img src="images/Rectangle 11942.png"/>
                            </div>

                            <div class="mx-5 px-3 pt-3 form-group">
                                <label class='form-label'style="color:black;font-size:21px;font-family:inter">Please attach proof that one partner is from/ is a resident of Cabuyao City (i.e. Government ID, Birth Certificate, other government documents, letter of recommendation)</label>
                                <div class="container mt-3 mx-0 px-0">
                                    <div class="card">
                                        <div class="card-body" >
                                            <div id="drop-area" class="dropzone border rounded d-flex justify-content-center align-items-center"
                                                style="height: 200px; cursor: pointer;border:none !important">
                                                <div class="text-center">
                                                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 60px;"></i>
                                                    <p class="mt-3">Drag and drop your image here or click to select a file.</p>
                                                    <p style='font-style:inter;font-weight:bold;font-size:20px' class='file_upload_text'>Empty File...</p>
                                                </div>
                                            </div>
                                            <input type="file" id="fileElem" name="fileElem" accept="image/*" class="d-none">
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <div class="mx-5 px-3 pt-2">
                                <img src="images/Rectangle 11942.png" style="width:100%"/>
                            </div>

                            <div class="mt-3 mx-5 px-3 form-group" style="color:black;font-size:21px;font-family:inter">
                                <label class='form-label'>(Available only for special cases i.e. partner living overseas, partner is pregnant, persons with disabilities)</label>
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="input-group input-group-sm" style='height:100%'>
                                            <div style='height:100%;display:flex;align-items:center'>
                                                <input type="checkbox" name="chk_pmoc" id="chk_pmoc" style="width:30px;height:auto" value="0" />
                                            </div>
    
                                            <label class="checkbox-inline mt-2" aria-describedby="ProcessingConsultantYN" id="lbProcessingConsultant" for="ProcessingConsultantYN">Do you wish to apply for Online PMOC? </label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="mx-5 mb-5 px-3 pmoc_tab" style='display:none'>

                                <div class="pt-4 text-left login_form_header">
                                    <p style="margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:33px">PMOC Application</p>
                                    <p style="line-height:0.9;margin-bottom:0;font-weight:bold;font-size:25px;font-family:inter;font-size:21px;color:#9B9B9B">Personal Information</p>
                                    <img src="images/Rectangle 11942.png" style='width:100%'/>
                                </div>

                                <label class='form-label' style="color:black;font-size:21px;font-family:inter">
                                    Justification
                                </label>

                                <textarea class="form-control" rows="3">

                                </textarea>
                                
                                <label class='form-label mt-3' style="color:black;font-size:21px;font-family:inter">
                                    Please attach evidence (Official government documents or medical certificate:)
                                </label>

                                <div class="container mx-0 px-0">
                                    <div class="card">
                                        <div class="card-body" >
                                            <div id='drop-area2' class="border rounded d-flex justify-content-center align-items-center"
                                                style="height: 200px; cursor: pointer;border:none !important">
                                                <div class="text-center">
                                                    <i class="bi bi-cloud-arrow-up-fill text-primary" style="font-size: 60px;"></i>
                                                    <p class="mt-3">Drag and drop your image here or click to select a file.</p>
                                                    <p style='font-style:inter;font-weight:bold;font-size:20px' class='file_upload_text_online' >Empty File...</p>
                                                </div>
                                            </div>
                                            <input type="file" id="fileElemOnline" name="fileElemOnline" accept="image/*" class="d-none">
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                                

                    <div class="pt-4 mt-1 form-group d-flex align-items-center justify-content-center">
                        <button onclick="onMeiForm()" type="button" class="btn" style="background: rgb(35,64,142);background: linear-gradient(90deg, rgba(35,64,142,1) 35%, rgba(60,148,198,1) 100%);color:white;width:300px;height:50px;font-size:25px;font-family:inter;font-weight:700;border-radius:10px;filter: drop-shadow(0px 4px 11px rgba(0, 0, 0, 0.25))">Continue</button>
                    </div>
                </td>
            </tr>

        
        </table>


        <footer style='height:100px;background-color:#23408E' class='footer'>
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
        </footer>
        <input type="hidden" name="hdn_mode" id="hdn_mode">
        
    </form>

    <script>

        function checkval(){

            var fileElem = document.getElementById('fileElem');   
            var filename = fileElem.files[0].name;

            // var fileElemOnline = document.getElementById('fileElemOnline');   
            // var filename2 = fileElemOnline.files[0].name;
            // alert("FIRST:"+filename+",SECOND:"+filename2);

            alert("FIRST:"+filename);
        }

        function onMeiForm(){
            document.forms.myforms.method = "post";
            document.forms.myforms.target = "_self";
            document.forms.myforms.action = "reg_meiform.php";
            document.forms.myforms.submit();
        }

        $("#chk_pmoc").on('change', function() {

            if(this.checked) {
                $(".confirm_main_div").addClass('overflowYScroll');
                $(".pmoc_tab").css({"display":"block"});
            }else{
                $(".confirm_main_div").removeClass('overflowYScroll');
                $(".pmoc_tab").css({"display":"none"});
            }
        });
                
        // let dropArea = document.getElementById("drop-area");
        // let dropArea2 = document.getElementById("drop-area2");

        // ["dragenter", "dragover", "dragleave", "drop"].forEach((eventName) => {

        //     dropArea.addEventListener(eventName, preventDefaults, false);
        //     dropArea2.addEventListener(eventName, preventDefaults, false);
        //     document.body.addEventListener(eventName, preventDefaults, false);
        // });

        // ["dragenter", "dragover"].forEach((eventName) => {
        //     dropArea.addEventListener(eventName, highlight, false);
        //     dropArea2.addEventListener(eventName, highlight, false);
        // });

        // ["dragleave", "drop"].forEach((eventName) => {
        //     dropArea.addEventListener(eventName, unhighlight, false);
        //     dropArea2.addEventListener(eventName, unhighlight, false);
        // });

        // dropArea.addEventListener("drop", handleDrop, false);
        // dropArea2.addEventListener("drop", handleDrop, false);

        // function preventDefaults(e) {
        //     e.preventDefault();
        //     e.stopPropagation();
        // }

        // function highlight(e) {
        //     dropArea.classList.add("highlight");
        //     dropArea2.classList.add("highlight");
        // }

        // function unhighlight(e) {
        //     dropArea.classList.remove("highlight");
        //     dropArea2.classList.remove("highlight");
        // }

        // function handleDrop(e) {


        //     var pass_input_id = "";

        //     if(e.currentTarget.id == 'drop-area'){
        //         $("#hdn_mode").val('REG');
        //         pass_input_id = 'fileElem';
        //     }else if(e.currentTarget.id == 'drop-area2'){
        //         $("#hdn_mode").val('ONL');
        //         pass_input_id = 'fileElemOnline';
        //     }

       
        //     let dt = e.dataTransfer;
        //     let files = dt.files;
        //     alert(JSON.stringify(files));
        //     handleFiles(files,e.pass_input_id);

            
        // }

        // function handleFiles(files,xpass_input_id) {

        //     alert(JSON.stringify(files))


            
        //     let fileInput = document.querySelector('input[type="file"][name="' + xpass_input_id + '"]');
        //     [...files].forEach((file) => {
        //         uploadFile(file, fileInput);
        //     });

        //     // [...files].forEach(uploadFile);
        // }

        // function uploadFile(file,xfileInput) {


        //     var chk_mode = $("#hdn_mode").val();

        //     if(chk_mode == 'REG'){
        //         $(".file_upload_text").html(file.name);
        //         var fileElem = document.getElementById('fileElem');   
        //         var filename2 = fileElem.files[0].name;


        //         alert(filename2);


        //     }else if(chk_mode == 'ONL'){

        //         $(".file_upload_text_online").html(file.name);
        //         var fileElemOnline = document.getElementById('fileElemOnline');   
        //         var filename = fileElemOnline.files[0].name;

        //         alert(filename);
                
        //     }
            
            
        //     console.log("Uploading", file.name);
        // }

        // dropArea.addEventListener("click", () => {
        //     $("#hdn_mode").val('REG');
        //     fileElem.click();
        // });

        // dropArea2.addEventListener("click", () => {
        //     $("#hdn_mode").val('ONL');
        //     fileElemOnline.click();
        // });

        // let fileElem = document.getElementById("fileElem");
        // fileElem.addEventListener("change", function (e) {

        //     $("#hdn_mode").val('REG');
        //     handleFiles(this.files);

        // });

        // let fileElemOnline = document.getElementById("fileElemOnline");
        // fileElemOnline.addEventListener("change", function (e) {

        //     $("#hdn_mode").val('ONL');
        //     handleFiles(this.files);

        // });


        let dropArea = document.getElementById('drop-area');
  let fileElem = document.getElementById('fileElem');
  let gallery = document.getElementById('gallery');

  ['dragenter', 'dragover', 'dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, preventDefaults, false);
    document.body.addEventListener(eventName, preventDefaults, false);
  });

  ['dragenter', 'dragover'].forEach(eventName => {
    dropArea.addEventListener(eventName, highlight, false);
  });

  ['dragleave', 'drop'].forEach(eventName => {
    dropArea.addEventListener(eventName, unhighlight, false);
  });

  dropArea.addEventListener('drop', handleDrop, false);

  function preventDefaults(e) {
    e.preventDefault();
    e.stopPropagation();
  }

  function highlight(e) {
    dropArea.classList.add('highlight');
  }

  function unhighlight(e) {
    dropArea.classList.remove('highlight');
  }

  function handleDrop(e) {
    let dt = e.dataTransfer;
    let files = dt.files;
    handleFiles(files);
  }

  dropArea.addEventListener('click', () => {
    fileElem.click();
  });

  fileElem.addEventListener('change', function (e) {
    handleFiles(this.files);
  });

  function handleFiles(files) {
    files = [...files];
    files.forEach(previewFile);
  }

  function previewFile(file) {
    let reader = new FileReader();
    reader.readAsDataURL(file);
    reader.onloadend = function () {
      let img = document.createElement('img');
      img.src = reader.result;
      gallery.appendChild(img);
    }
  }


  Dropzone.autoDiscover = false;

    // Dropzone configuration
    var myDropzone = new Dropzone(".dropzone", {
        url: "/file/post", 
        paramName: "fileElem",
        maxFilesize: 2, // MB
        maxFiles: 10,
        acceptedFiles: 'image/*',
        dictDefaultMessage: "Drag files here or click to upload.",
        clickable: true 
    });

    </script>


    



<?php 
require "includes/cc_footer.php";
?>

