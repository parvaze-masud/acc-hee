<style>
body {
    overflow: hidden;
    /* Hide scrollbars */
}
.card-block {
    padding: 0.25rem;
}
.card {
    margin-bottom: -28px;
}
</style>
<div class="coded-main-container navChild ">
    <div class="pcoded-content">
        <div class="pcoded-inner-content" ><br>
          <!-- Main-body start -->
           <div class="main-body p-0  side-component">
                    <div class="page-wrapper m-t-0 p-0">
                        <!-- Page-header start -->
                        <div class="page-header m-2 p-0">
                            <div class="col-lg-12 row">
                                <div class="col-lg-3">
                                    <div class="page-header-title">
                                        <h4>{{ $title ?? '' }}</h4>
                                    </div>
                                </div>
                                <div class="col-lg-9">
                                    <div style="float: right;margin-left:9px">
                                        <a style="float:right;text-decoration: none;cursor: pointer; "  class="print"   onclick="print_html('{{$print_layout}}','{{$print_header}}')"><span class="fa fa-print m-1" style="font-size:27px; color:teal;"></span><span  style="float:right;margin:2px; padding-top:5px; ">Print</span></a>      
                                    </div>
                                    <div style="float: right;margin-left:9px"> 
                                        <a style="float:right;text-decoration: none;cursor: pointer; "  class="excel"  onclick="exportTableToExcel('{{$print_header}}')"><span class="fa fa-file-excel-o m-1"   style="font-size:25px; color:Gray;"></span><span style="float:right;margin:2px; padding-top:5px; ">Excel</span></a>        
                                    </div>
                                    <div style="float: right;margin-left:9px">
                                        <a style="float:right;text-decoration: none;cursor: pointer;"   class="pdf"onclick="generateTable('{{$print_header}}')"><span class="fa fa-file-pdf-o m-1"  style="font-size:25px; color:MediumSeaGree;"></span><span   style="float:right;margin:2px; padding-top:5px; ">Pdf</span></a>      
                                    </div>
                                    <div style="float: right; width:200px;">
                                        <input type="text" id="myInput" style="border-radius: 5px" class="form-control form-control pb-1" width="100%" placeholder="searching">
                                    </div>
                                </div>
                                    <hr style="margin-bottom: 0px;">
                            </div>
                            {{$header_body}}
                        </div>
                    </div>
                </div>
                <!-- Page-body start -->
                <div class="page-body left-data">
                    <div class="row">
                        <div class="col-xl-12">
                            <!-- Zero config.table start -->
                            <div class="card">
                                <div class="card-block table-responsive table_content">
                                    {{$main_body}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
           </div>
        </div>
    </div>
</div>
<script>
    let scrollValue=0;
    $('.tableFixHead_report').scroll(function(){
        scrollValue = $('.tableFixHead_report').scrollTop();
    });
    function set_scroll_table(){
        $(document).find('.tableFixHead_report').scrollTop(localStorage.getItem('scrollValue'));
        $(document).find(`.${localStorage.getItem('scrollValueId')}`).addClass('current-row');
        localStorage.setItem('scrollValue', 0);
    }
    function scroll_table(){
        if (scrollValue > 0) {
            localStorage.setItem('scrollValue', scrollValue);
        }
    }
    $(document).on('click','tr',function(){
        let id=$(this).closest('tr').attr('id');
        localStorage.setItem('scrollValueId', id);
        scroll_table();
    })
</script>