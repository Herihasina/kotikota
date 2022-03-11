jQuery(document).on( 'click', '#zipcodes_export_btn', function(e) {
    e.stopPropagation();

    jQuery.ajax({
        type:"POST",
        url:ajax_object.ajax_url,
        data: {action:'download_zipcodes_report'},
        success:function(res){
            //console.log(res);

            /*
               * Make CSV downloadable
               */
            var downloadLink = document.createElement("a");
            var fileData = ['\ufeff'+res];

            var blobObject = new Blob(fileData,{
               type: "text/csv;charset=utf-8;"
             });

            var url = URL.createObjectURL(blobObject);
            downloadLink.href = url;
            downloadLink.download = "zipcodes_report.csv";

            /*
             * Actually download CSV
             */
            document.body.appendChild(downloadLink);
            downloadLink.click();
            document.body.removeChild(downloadLink);
        }
    });
});