<div class="card card-header">
    <div class="header">
        <h2>
            Member Card
        </h2>
        <ul class="header-dropdown m-r--5">
            <button type="button" class="btn bg-blue m-r-15 waves-effect" onclick="downloadCard()">
                <i class="material-icons">file_download</i>
            </button>
        </ul>
    </div>
</div>
<div class="card-modal align-center">
    <div class="card-container">
        <div class="card bg-member-front" id="printFront" style="margin:0px">
            <div class="body" style="padding-bottom:0px">
                <div class="member-info" style="margin-top: 80px;">
                    <h4 id="card-name">Nama Member</h4>
                    <h5 id="card-category">Category</h5>
                </div>
    
    
                <div class="media">
                    <div class="media-body member-since">
                        Member Since<br>
                        <p id="card-since">Date</p>
                    </div>
                    <div class="media-right member-qr">
                        {{-- <img class="media-object" id="card-qr" src="" alt="" width="64" height="64"> --}}
                        <span id="card-qr"></span>
                        <span id="card-code">barcode</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="card bg-member-back" id="printBack" style="margin:0px">
        </div>
    </div>
</div>
<div id="card-download"></div>
