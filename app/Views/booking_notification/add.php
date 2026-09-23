<?php        
$db = db_connect();
?>
<style>
.ui-autocomplete{
            padding: 0px !important;
    }
    .ui-autocomplete ul{
        background-color: #5d8dff; font-size:14px;
    }
    li a{
        color: #fff;
    }
</style>
<?php 
if($view == true){
    $readonly = 'readonly';
    $disable = "disabled";
}
?>
<style>
<?php if($view == true) { ?>
label.form-label span { display:none !important; color:transporant; }
<?php } ?>
</style>
<style>
.ck-editor__editable_inline {
    min-height: 200px;
}
.ck-powered-by{
    display:none;
}
</style>
<section class="content">
        <div class="container-fluid">
            <div class="block-header">
                <h2>Booking Notification<small>PROFILE</small></h2>
            </div>
            <!-- Basic Examples -->
            <div class="row clearfix">
                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                    <div class="card">
                        <div class="header">
                            <div class="row"><div class="col-md-8"><!--<h2>Cash Donation</h2>--></div>
                            <div class="col-md-4" align="right"><a href="<?php echo base_url(); ?>/bookingnotification">
                            <button type="button" class="btn bg-deep-purple waves-effect">List</button></a></div></div>
                        </div>
                        <div class="body">
                            <form method="post" action="<?php echo base_url(); ?>/bookingnotification/save" enctype="multipart/form-data">
                                <input type="hidden" name="book_noti_id" value="<?php echo $booktype['id'];?>">
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                            <label class="form-label" style="display: contents;">Booking Type <span style="color: red;">*</span></label>
                                                <select class="form-control" id="booking_type" name="booking_type" required>
                                                    <option value="">-- Select Booking Type --</option>
                                                    <?php
                                                    if(count($booking_type_list) > 0){
                                                        foreach($booking_type_list as $rows){
                                                    ?>
                                                    <option value="<?php echo $rows['id']; ?>" <?php if(!empty($booktype['type'])){ if($booktype['type'] == $rows['id']){ echo "selected";} }?>><?php echo $rows['name']; ?></option>
                                                    <?php
                                                        }
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Title </label>
                                                <input type="text" name="booking_title" id="booking_title" class="form-control" value="<?php if(!empty($booktype['title'])){ echo $booktype['title']; }?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">Description </label>
                                                <textarea name="booking_description" id="booking_description" class="form-control" rows="5" cols="40"><?php if(!empty($booktype['description'])){ echo $booktype['description']; }?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-sm-8">
                                        <div class="form-group form-float">
                                            <div class="form-line">
                                                <label class="form-label">File </label>
                                                <input type="file" name="booking_file" id="booking_file" class="form-control">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                <div class="row">
                                    <div class="col-md-2"></div>                    
                                    <div class="col-sm-8">
                                        <?php
                                        if (!empty($booktype['image'])) {
                                            ?>
                                            <img id="img_pre"
                                                src="<?php echo base_url(); ?>/uploads/notification/<?php echo $booktype['image']; ?>"
                                                class="img-responsive" style="width:100px;">
                                            <?php
                                        }
                                        ?>
                                    </div>
                                    <div class="col-md-2"></div>
                                </div> 
                                
                                <div class="row">
                                    <div class="col-md-2"></div>
                                    <div class="col-sm-8">
                                        <input type="submit" value="Submit" class="btn btn-success" style="width:100px;">
                                    </div>
                                    <div class="col-md-2"></div>
                                </div>
                                        

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="<?php echo base_url(); ?>/assets/ckeditor.js"></script>
<script>
ClassicEditor
    .create( document.querySelector( '#booking_description' ) )
    .catch( error => {
        console.error( error );
    });

</script>
