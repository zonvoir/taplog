"use strict";
// Class definition

var KTDropzoneDemo = function () {
    // Private functions
    var demo1 = function () {
        // single file upload
        var beatsUploadDz = new Dropzone("#beat-csv-upload",{
            method: 'POST',
            url: HOST_URL+"import", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            acceptedFiles: 'text/csv',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        beatsUploadDz.on("success", function(file,resp) {
            console.log(resp)
            if(resp.status == 1){
                this.defaultOptions.success(file, resp.message)
            }else{
                this.defaultOptions.error(file, resp.message);
            }
        });
    }
    return {
        // public functions
        init: function() {
            demo1();
        }
    };
}();

KTUtil.ready(function() {
    KTDropzoneDemo.init();
});
