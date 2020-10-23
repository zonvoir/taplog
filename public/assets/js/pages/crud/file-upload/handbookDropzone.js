"use strict";
// Class definition

var KTDropzoneDemo = function () {
    // Private functions
    var demo1 = function () {
        // handbook upload
        var handbookUploadDz = new Dropzone("#handbook-upload",{
            method: 'POST',
            url: HOST_URL+"upload-handbook", // Set the url for your upload script location
            paramName: "file", // The name that will be used to transfer the file
            maxFiles: 10,
            maxFilesize: 5, // MB
            addRemoveLinks: true,
            acceptedFiles: 'image/*',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        handbookUploadDz.on("sending", function (file, xhr, formData) {
            formData.append("ids", ids);
        });
        handbookUploadDz.on("success", function(file,resp) {
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
