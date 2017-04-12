$(function(){
    $('#formUpload').on("submit", function(event){
        event.preventDefault();
        if (typeof $("input[name='type']:checked").val() == 'undefined'){
            alert("Set output type");
            return;
        }
        if ($('#fi1e').get(0).files.length === 0) {
            alert("Set input file");
            return;
        }
        var formData = new FormData();
        formData.append('file', $("#fi1e")[0].files[0]);
        formData.append('type_output', $("input[name='type']:checked").val());
        $.ajax({
            url : 'controller/file_convert.php',
            type : 'POST',
            data : formData,
            dataType: "json",
            processData: false,  // tell jQuery not to process the data
            contentType: false,  // tell jQuery not to set contentType
            success : function(data) {
                window.location.href = data.file;
            }
        });

    });
});
