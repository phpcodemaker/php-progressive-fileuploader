<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
<form action="upload.php" method="POST" enctype="multipart/form-data" id="upload_form">
    <input type="hidden" name="UPLOAD_IDENTIFIER" id="UPLOAD_IDENTIFIER" value="<?php echo md5(uniqid(mt_rand())); ?>"/>
    <input type="file" name="uploaded_file"/>
    <!-- Any additional required form fields can be added below-->
    <input type="submit" value="Upload File"/>
</form>
<!-- Progress Bar -->
<div id="progress-bar-container" style="border: thin solid gray;">
    <div id="progress-bar" style="height: 30px; width: 0%; background: cornflowerblue; color: white; text-align: right; line-height: 30px;">
    </div>
</div>
<!-- Estimated Time -->
<div id="time_remaining_parent" style="display:none">Time Remaining : <span id="time_remaining"></span> sec(s)</div>
<script>
/**
 * Ajax Call to retrieve file upload progress
 */
$.fn.uploadProgress = function() {
    let timer = setInterval(function () {
        $.ajax({
            type    :   'POST',
            url     :   'progress.php',
            data    :   {
                'UPLOAD_IDENTIFIER' :   $('#UPLOAD_IDENTIFIER').val()
            },
            success :   function (response) {
                if (response === 'null') {
                    clearInterval(timer);
                    document.getElementById('progress-bar').style.width = "100%";
                    document.getElementById('progress-bar').innerHTML = "100%";
                    $('#time_remaining_parent').hide();
                }
                else {
                    let progress = JSON.parse(response);
                    console.log(progress);
                    $('#time_remaining_parent').show();
                    let bytes_uploaded  =   progress['bytes_uploaded'];
                    let bytes_total     =   progress['bytes_total'];
                    let time_remaining  =   progress['est_sec'];
                    // calculate percent completed and estimated sec remaining to upload
                    let completed_percent = Math.floor(bytes_uploaded * 100 / bytes_total);
                    $('#progress-bar').css('width', completed_percent + "%")
                                    .html(completed_percent + "%");
                    $('#time_remaining').html(time_remaining);
                    if (completed_percent >= 100) {
                        $('#progress-bar').css('width', "100%").html("100%");
                        $('#time_remaining_parent').hide();
                    }
                }
            }
        });
    }, 1000);
};
$(document).ready(function () {
    $("#upload_form").on('submit', function (event) {
        event.preventDefault();
        //Ajax File upload
        let formData = new FormData();
        let file = $('input[type=file]')[0].files[0];
        let other_data = $("#upload_form").serializeArray();
        //adding additional form-fields from form to include in post data
        $.each(other_data, function (key, input) {
            formData.append(input.name, input.value);
        });
        formData.append('uploaded_file', file);
        $.ajax({
            type        :   'POST',
            url         :   'upload.php',
            data        :   formData,
            processData :   false,
            contentType :   false,
            success     :   function (response) {
                let responseObject = JSON.parse(response);
                if (responseObject.success) {
                    console.log(responseObject.message);
                }
                else {
                    console.log(responseObject);
                }
            },
            error: function (err) {
                console.log('error : ');
                console.log(err);
            }
        });
        // ajax request to get progress...
        $.fn.uploadProgress();
    });
});
</script>