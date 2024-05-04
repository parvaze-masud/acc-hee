 
 
 // pdf 

    function generateTable(name) {
            var doc = new jsPDF('p', 'pt', 'letter');
            var y = 20;
            doc.setLineWidth(2);
            var pageWidth = doc.internal.pageSize.width || doc.internal.pageSize.getWidth();
            doc.text(pageWidth/2, y = y + 20, name,{align: 'center'});
            doc.text(pageWidth/2, y = y + 20, `Date :${new Date()}`,{align: 'center'});
            doc.autoTable({
                html: '#tableId',
                startY: 70,
                theme: 'grid',
            })
            doc.save(name);
    }
 // print
 function print_html(pageView = 'portrait',print_header) {
    let htmlToPrint = '';
    let divToPrint = document.getElementsByClassName("table_content");
    console.log(divToPrint[0].outerHTML);
    const newWin = window.open("");
    htmlToPrint = `<style type="text/css" media="print">
                    @page { size: ${pageView}; }
                    table, td, th {
                        border: 1px solid  #ddd ;
                    }
                    table {
                        width: 100%;
                        border-collapse: collapse;
                    }
                    .hide-btn{
                        visibility: hidden;
                    }
                    .row_style{
                        display: flex;
                        flex-direction: row;
                        flex-basis: 100%;
                        flex: 1;
                    }
                    .box {
                        padding: 20px;
                        border: 1px solid black;
                        width:100%;
                        height: 100px;
                        margin: 10px;
                      }
                </style>`;
    let html_header=`<h4 style="text-align:center;">${print_header}<br>Print Date :${new Date()}</h4> `;
    newWin.document.write(htmlToPrint);
    newWin.document.write(html_header);
    newWin.document.write(divToPrint[0].outerHTML);
    newWin.document.close();
    newWin.location.reload();
    newWin.focus();
    newWin.print();
    newWin.close();
}

// excel 
function exportTableToExcel(name) {
    
    // Get the table element using the provided ID
    const table = document.getElementById('tableId');
    // Extract the HTML content of the table
    var cloneTable = table.cloneNode(true);
    jQuery(cloneTable).find('.d-none').remove();
    const html = cloneTable.outerHTML;
    let html_header=`<h4 style="text-align:center;">${name}<br>Excel Date :${new Date()}</h4> `;
    let css_style=`<style type="text/css">
                         table, td, th {
                            border: 1px solid  #ddd ;
                        }
                    </style> `;
    // Create a Blob containing the HTML data with Excel MIME type
    const blob = new Blob([html_header+css_style+html], { type: "application/vnd.ms-excel" });
    // Create a URL for the Blob
    const url = URL.createObjectURL(blob);
    // Create a temporary anchor element for downloading
    const a = document.createElement("a");
    a.href = url;
    // Set the desired filename for the downloaded file
    a.download = `${name}.xls`;
    // Simulate a click on the anchor to trigger download
    a.click();
    // Release the URL object to free up resources
    URL.revokeObjectURL(url);
}